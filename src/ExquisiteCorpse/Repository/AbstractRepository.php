<?php

namespace ExquisiteCorpse\Repository;
use MongoDB\Driver\Manager;

/**
 * Class AbstractRepository
 *
 * @package ExquisiteCorpse\Repository
 * @author Thomas Arnaud <thomas.arnaud@etu.univ-lyon1.fr>
 * @author Bruno Buiret <bruno.buiret@etu.univ-lyon1.fr>
 * @author Bastien Guyl <bastien.guyl@etu.univ-lyon1.fr>
 * @author Alexis Rabilloud <alexis.rabilloud@etu.univ-lyon1.fr>
 * @version 1.0
 */
abstract class AbstractRepository
{
    /**
     * @var string The database's name.
     */
    const DATABASE = 'exquisite_corpse';

    /**
     * @var Manager A reference to the MongoDb manager.
     */
    protected $manager;

    /**
     * AbstractRepository constructor.
     *
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        // Initialize properties
        $this->manager = $manager;
    }

    /**
     * Builds an entity with data extracted from the database.
     *
     * @param array $data The extracted data.
     * @return mixed The newly built entity.
     */
    protected abstract function buildEntity($data);
}