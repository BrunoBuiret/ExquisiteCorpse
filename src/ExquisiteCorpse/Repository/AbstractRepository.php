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
     * @var Manager
     */
    protected $manager;

    protected $logger;

    /**
     * AbstractRepository constructor.
     *
     * @param Manager $manager
     */
    public function __construct(Manager $manager, $logger)
    {
        // Initialize properties
        $this->manager = $manager;
        $this->logger = $logger;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected abstract function buildEntity($data);
}