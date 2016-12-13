<?php

namespace ExquisiteCorpse\Repository;

use ExquisiteCorpse\Entity\Entry;
use ExquisiteCorpse\Entity\Game;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Query;
use MongoDB\BSON\ObjectID;
use MongoDB\Driver\Command;

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
    /**
     * @var string The collection's name.
     */
    const COLLECTION = 'games';

    /**
     * @var string Full collection name.
     */
    const FULL_NAME = AbstractRepository::DATABASE.'.'.self::COLLECTION;

    /**
     * Fetches one game from the database.
     *
     * @param string $id The game's id.
     * @return Game The wanted {@code Game}, or {@code null} if it doesn't exist.
     */
    public function fetch($id)
    {
        $query = new Query(['_id' => new ObjectID($id)]);

        $cursor = $this->manager->executeQuery(self::FULL_NAME, $query);
        $cursor->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);

        $documents = $cursor->toArray();

        return !empty($documents[0]) ? $this->buildEntity($documents[0]) : null;
    }

    /**
     * Fetches every game from the database.
     *
     * @return Game[] An array of games.
     */
    public function fetchAll()
    {
        $query = new Query([]);
        $games = [];

        $cursor = $this->manager->executeQuery(self::FULL_NAME, $query);
        $cursor->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);

        foreach($cursor as $document)
        {

            $games[] = $this->buildEntity($document);
        }

        return $games;
    }

    /**
     * Saves a game into the database.
     *
     * @param Game $game The game to save.
     */
    public function save(Game $game)
    {
        // Initialize vars
        $bulk = new BulkWrite();
        $data = $game->toArray();

        // Format dates for storage
        $data['createdAt'] = $data['createdAt']->format('d/m/Y H:i:s');

        foreach($data['entries'] as &$entry)
        {
            $entry['createdAt'] = $entry['createdAt']->format('d/m/Y H:i:s');
        }

        // Update or insert whether the game already exists or not
        if(!empty($game->getId()))
        {
            $bulk->update(['_id' => $game->getId()], $data);
        }
        else
        {
            // Remove _id so that MongoDb generates it
            unset($data['_id']);
            $bulk->insert($data);
        }

        $this->manager->executeBulkWrite(self::FULL_NAME, $bulk);
    }

    /**
     * Deletes a game from the database.
     *
     * @param Game $game The game to delete.
     */
    public function delete(Game $game)
    {
        $bulk = new BulkWrite();
        $bulk->delete(['_id' => $game->getId()], ['limit' => 1]);
    }

    /**
     * Builds a game from with data extracted from the database.
     *
     * @param array $data The extracted data.
     * @return Game The newly built game.
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

        foreach($data['entries'] as $entryData)
        {
            $entry = new Entry();
            $entry
                ->setId($entryData['id'])
                ->setWords($entryData['words'])
                ->setOrder($entryData['order'])
                ->setCreatedAt(\DateTime::createFromFormat('d/m/Y H:i:s', $entryData['createdAt']))
                ->setGame($game);
            $entries[] = $entry;
        }

        usort(
            $entries,
            function($a, $b)
            {
                if($a == $b)
                {
                    return 0;
                }

                return $a->getCreatedAt() < $b->getCreatedAt() ? -1 : +1;
            }
        );

        $game->setEntries($entries);

        return $game;
    }

    /**
     * Gets the next id for an entry.
     *
     * @param string $gameId The game's id.
     * @return int The id.
     */
    public function getNextEntryId($gameId)
    {
        $command = new Command([
            'findAndModify' => 'entryCounters',
            'query'         => ['_id' => $gameId],
            'update'        => ['$inc' => ['seq' => 1]],
            'new'           => true,
            'upsert'        => true,
        ]);

        $cursor = $this->manager->executeCommand(AbstractRepository::DATABASE, $command);
        $cursor->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);

        $data = current($cursor->toArray());

        return $data['value']['seq'];
    }
}