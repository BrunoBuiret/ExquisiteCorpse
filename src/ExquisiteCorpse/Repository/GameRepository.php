<?php

namespace ExquisiteCorpse\Repository;

use ExquisiteCorpse\Entity\Entry;
use ExquisiteCorpse\Entity\Game;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Query;
use MongoDB\BSON\ObjectID;

/**
 * Class GameRepository
 *
 * @package ExquisiteCorpse\Repository
 * @author Thomas Arnaud <thomas.arnaud@etu.univ-lyon1.fr>
 * @author Bruno Buiret <bruno.buiret@etu.univ-lyon1.fr>
 * @author Bastien Guyl <bastien.guyl@etu.univ-lyon1.fr>
 * @author Alexis Rabilloud <alexis.rabilloud@etu.univ-lyon1.fr>
 * @version 1.0
 */
class GameRepository extends AbstractRepository
{
    const COLLECTION = 'exquisite_corpse.games';

    /**
     * @param $id
     * @return Game
     */
    public function fetch($id)
    {
        $query = new Query(['_id' => new ObjectID($id)]);

        $cursor = $this->manager->executeQuery(self::COLLECTION, $query);
        $cursor->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);

        $documents = $cursor->toArray();

        return !empty($documents[0]) ? $this->buildEntity($documents[0]) : 0;
    }

    /**
     * @return Game[]
     */
    public function fetchAll()
    {
        $query = new Query([]);
        $games = [];

        $cursor = $this->manager->executeQuery(self::COLLECTION, $query);
        $cursor->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);

        foreach($cursor as $document) {

            $games[] = $this->buildEntity($document);
        }

        return $games;
    }

    public function save(Game $game)
    {
        // Initialize vars
        $bulk = new BulkWrite();
        $data = $game->toArray();
        $data['createdAt'] = $data['createdAt']->format('d/m/Y H:i:s');

        foreach($data['entries'] as &$entry)
        {
            $entry['createdAt'] = $entry['createdAt']->format('d/m/Y H:i:s');
        }

        if(!empty($game->getId())) {
            /*
             *  Game already exists, need to update (COMMAND UPDATE)
             */
            $bulk->update(['_id' => $game->getId()], $data);
        }
        else {
            /*
             *  Game doesn't yet exist, need to create it (COMMAND INSERT)
             */
            $bulk->insert($data);
        }

        $this->manager->executeBulkWrite(self::COLLECTION, $bulk);
    }

    public function delete(Game $game)
    {
        $bulk = new BulkWrite();
        $bulk->delete(['_id' => $game->getId()], ['limit' => 1]);
    }

    /**
     * @param array $data
     * @return Game
     */
    protected function buildEntity($data)
    {
        $game = new Game();

        $game
            ->setId($data['_id'])
            ->setTitle($data['title'])
            ->setLikesNumber($data['likes'])
            ->setCreatedAt(\DateTime::createFromFormat('d/m/Y H:i:s', $data['createdAt']))
            ->setFinished($data['isFinished']);

        $entries = [];

        foreach($data['entries'] as $entryData) {
            $entry = new Entry();

            $entry
                ->setId($entryData['id'])
                ->setWords($entryData['words'])
                ->setOrder($entryData['order'])
                ->setCreatedAt(\DateTime::createFromFormat('d/m/Y H:i:s', $entryData['createdAt']))
                ->setGame($game);

            $entries[] = $entry;
        }
        $game->setEntries($entries);

        return $game;
    }
}