<?php
/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2018. 12. 14.
 * Time: 22:45
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="games")
 */
class VideoGame
{

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    var $videogame_id;


    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    var $genre;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    var $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    var $developer;

    /**
     * @var int
     * @ORM\Column(type="integer",nullable=false)
     */
    var $release_year;

    /**
     * @var int
     * @ORM\Column(type="integer",nullable=false)
     */
    var $cost;

    /**
     * @var Review
     * @ORM\OneToOne(targetEntity="Review",inversedBy="videogame")
     * @ORM\JoinColumn(name="game_review", referencedColumnName="review_id")
     */
    var $game_review;

    /**
     * @return int
     */
    public function getVideogameId(): int
    {
        return $this->videogame_id;
    }


    /**
     * @return string
     */
    public function getGenre(): ?string
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     */
    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }

    /**
     * @return string
     */
    public function getDeveloper():? string
    {
        return $this->developer;
    }

    /**
     * @param string $developer
     */
    public function setDeveloper(string $developer): void
    {
        $this->developer = $developer;
    }

    /**
     * @return int
     */
    public function getReleaseYear(): ?int
    {
        return $this->release_year;
    }

    /**
     * @param int $release_year
     */
    public function setReleaseYear(int $release_year): void
    {
        $this->release_year = $release_year;
    }

    /**
     * @return int
     */
    public function getCost(): ?int
    {
        return $this->cost;
    }

    /**
     * @param int $cost
     */
    public function setCost(int $cost): void
    {
        $this->cost = $cost;
    }

    /**
     * @return Review
     */
    public function getReview():? Review
    {
        return $this->game_review;
    }

    /**
     * @param Review $review
     */
    public function setReview(Review $review): void
    {
        $this->game_review = $review;
    }

    public function __toString()
    {
        $VideoGameString = $this->name.":".$this->release_year;
        return $VideoGameString;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }



}