<?php

namespace ExquisiteCorpse\Repository;

use ExquisiteCorpse\Entity\Entry;
use ExquisiteCorpse\Entity\Game;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Query;

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
        $query = new Query(['gameID' => $id]);

        $cursor = $this->manager->executeQuery(self::COLLECTION, $query);
        $cursor->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);

        foreach($cursor as $document)
        {
            $this->buildEntity($document);
        }
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
        $data = $game.toArray();
        $bulk = new BulkWrite();

        if(!empty($game->getId())) {
            /*
             *  Game already exists, need to update (COMMAND UPDATE)
             */
            $bulk->update($data);
        }
        else {
            /*
             *  Game doesn't yet exist, need to create it (COMMAND INSERT)
             */
            $bulk->insert($data);
        }
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
            ->setId($data['id'])
            ->setTitle($data['title'])
            ->setLikesNumber($data['like'])
            ->setCreatedAt($data['createdAt'])
            ->setFinished($data['isFinished']);

        $entries = [];

        foreach($data['entries'] as $entryData) {
            $entry = new Entry();

            $entry
                ->setId($entryData['id'])
                ->setWords($entryData['words'])
                ->setOrder($entryData['order'])
                ->setCreatedAt($entryData['createdAt'])
                ->setGame($game);

            $entries[] = $entry;
        }

        return $game;
    }
}