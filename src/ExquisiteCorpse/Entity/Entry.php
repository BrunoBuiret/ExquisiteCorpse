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
     * @var CursorId The entry's id.
     */
    protected $id;

    /**
     * @var string The entry's words.
     */
    protected $words;

    /**
     * @var int The entry's order in the game.
     */
    protected $order;

    /**
     * @var \DateTime The entry's date of creation.
     */
    protected $createdAt;

    /**
     * @var Game The entry's game.
     */
    protected $game;

    /**
     * Gets the entry's id.
     *
     * @return CursorId The entry's id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the entry's id.
     *
     * @param CursorId $id The entry's id.
     * @return Entry This entry.
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the entry's words.
     *
     * @return string The entry's words.
     */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * Sets the entry's words.
     *
     * @param string $words The entry's words.
     * @return Entry This entry.
     */
    public function setWords($words)
    {
        $this->words = $words;

        return $this;
    }

    /**
     * Gets the entry's order.
     *
     * @return int The entry's order.
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Sets the entry's order.
     *
     * @param int $order The entry's order.
     * @return Entry This entry.
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Gets the entry's date of creation.
     *
     * @return \DateTime The entry's date of creation.
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets the entry's date of creation.
     *
     * @param \DateTime $createdAt The entry's date of creation.
     * @return Entry This entry.
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Gets the entry's game.
     *
     * @return Game The entry's game.
     */
    public function getGame(): Game
    {
        return $this->game;
    }

    /**
     * Sets the entry's game.
     *
     * @param Game $game The entry's game.
     * @return Entry This entry.
     */
    public function setGame($game)
    {
        $this->game = $game;
        return $this;
    }
}