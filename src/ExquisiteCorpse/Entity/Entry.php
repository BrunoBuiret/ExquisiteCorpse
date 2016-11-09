<?php

namespace ExquisiteCorpse\Entity;

use MongoDB\Driver\CursorId;

/**
 * Class Entry
 *
 * @package ExquisiteCorpse\Entity
 * @author Thomas Arnaud <thomas.arnaud@etu.univ-lyon1.fr>
 * @author Bruno Buiret <bruno.buiret@etu.univ-lyon1.fr>
 * @author Bastien Guyl <bastien.guyl@etu.univ-lyon1.fr>
 * @author Alexis Rabilloud <alexis.rabilloud@etu.univ-lyon1.fr>
 * @version 1.0
 */
class Entry
{
    /**
     * @var CursorId
     */
    protected $id;

    /**
     * @var string
     */
    protected $words;

    /**
     * @var int
     */
    protected $order;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var Game
     */
    protected $game;

    /**
     * @return CursorId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param CursorId $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * @param string $words
     */
    public function setWords($words)
    {
        $this->words = $words;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param int $order
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Game
     */
    public function getGame(): Game
    {
        return $this->game;
    }

    /**
     * @param Game $game
     */
    public function setGame($game)
    {
        $this->game = $game;
        return $this;
    }
}