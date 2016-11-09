<?php

namespace ExquisiteCorpse\Repository;

use ExquisiteCorpse\Entity\Game;

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
     * @param $id
     * @return Game
     */
    public function fetch($id)
    {

    }

    /**
     * @return Game[]
     */
    public function fetchAll()
    {

    }

    public function save(Game $game)
    {

    }

    public function delete(Game $game)
    {

    }

    /**
     * @param array $data
     * @return Game
     */
    protected function buildEntity($data)
    {

    }
}