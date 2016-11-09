<?php

namespace ExquisiteCorpse\Repository;

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
     * @var
     */
    protected $connection;

    /**
     * AbstractRepository constructor.
     *
     * @param $connection
     */
    public function __construct($connection)
    {
        // Initialize properties
        $this->connection = $connection;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected abstract function buildEntity($data);
}