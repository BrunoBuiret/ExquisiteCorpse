<?php

namespace ExquisiteCorpse\Entity;

use MongoDB\BSON\ObjectID;

/**
 * Class Game
 *
 * @package ExquisiteCorpse\Entity
 * @author Thomas Arnaud <thomas.arnaud@etu.univ-lyon1.fr>
 * @author Bruno Buiret <bruno.buiret@etu.univ-lyon1.fr>
 * @author Bastien Guyl <bastien.guyl@etu.univ-lyon1.fr>
 * @author Alexis Rabilloud <alexis.rabilloud@etu.univ-lyon1.fr>
 * @version 1.0
 */
class Game
{
    /**
     * @var ObjectID The game's id.
     */
    protected $id;

    /**
     * @var string The game's title.
     */
    protected $title;

    /**
     * @var int The game's number of likes.
     */
    protected $likesNumber;

    /**
     * @var \DateTime The game's date of creation
     */
    protected $createdAt;

    /**
     * @var bool
     */
    protected $isFinished;

    /**
     * @var array The game's entries.
     */
    protected $entries = [];

    /**
     * Gets the game's id.
     * @return ObjectID The game's id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the game's id.
     *
     * @param ObjectID $id The game's id.
     * @return Game This game.
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the game's title.
     * @return string The game's title.
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the game's title.
     *
     * @param string $title The game's title.
     * @return Game This game.
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Gets the game's number of likes.
     *
     * @return int The game's number of likes.
     */
    public function getLikesNumber()
    {
        return $this->likesNumber;
    }

    /**
     * Sets the game's number of likes.
     *
     * @param int $likesNumber The game's number of likes.
     * @return Game This game.
     */
    public function setLikesNumber($likesNumber)
    {
        $this->likesNumber = $likesNumber;

        return $this;
    }

    /**
     * Gets the game's date of creation.
     *
     * @return \DateTime The game's date of creation.
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets the game's date of creation.
     *
     * @param \DateTime $createdAt The game's date of creation.
     * @return Game This game.
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isFinished()
    {
        return $this->isFinished;
    }

    /**
     * @param $isFinished
     * @return $this
     */
    public function setFinished($isFinished)
    {
        $this->isFinished = $isFinished;
        return $this;
    }


    /**
     * Gets the game's entries.
     *
     * @return array The game's entries.
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Sets the game's entries.
     *
     * @param array $entries The game's entries.
     * @return Game This game.
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;

        return $this;
    }

    /**
     * Adds an entry to the game.
     *
     * @param Entry $entry The entry to add.
     * @return Game This game.
     */
    public function addEntry(Entry $entry)
    {
        $this->entries[] = $entry;

        return $this;
    }

    /**
     * Removes an entry from the game.
     *
     * @param Entry $entry The entry to remove.
     * @return Game This game.
     */
    public function removeEntry(Entry $entry)
    {
        if(($index = array_search($entry, $this->entries)) !== false)
        {
            unset($this->entries[$index]);
        }

        return $this;
    }

    /**
     * Gets the game's data as an array.
     *
     * @return array The game's data as an array.
     */
    public function toArray()
    {
        $entries = [];

        foreach($this->entries as $entry)
        {
            $entries[] = $entry->toArray();
        }

        return [
            '_id' => $this->id,
            'title' => $this->title,
            'likes' => $this->likesNumber,
            'createdAt' => $this->createdAt,
            'isFinished' => $this->isFinished,
            'entries' => $entries
        ];
    }
}