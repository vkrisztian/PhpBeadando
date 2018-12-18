<?php
/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2018. 12. 14.
 * Time: 22:39
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="reviews")
 * @ORM\HasLifecycleCallbacks
 */
class Review
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $review_id;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
        private $review_date;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private  $title;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="user_reviews")
     * @ORM\JoinColumn(name="owner", referencedColumnName="user_id")
     */
    private $owner;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private  $rating;

    /**
     * @var VideoGame
     * @ORM\ManyToOne(targetEntity="VideoGame",inversedBy="game_review" )
     * @ORM\JoinColumn(name="videogame", referencedColumnName="videogame_id")
     */
    private $videogame;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="review")
     */
    private $comments;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $content;

    /**
     * Review constructor.
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps(){

        if ($this->review_date==null){
            $this->review_date=new \DateTime();
        }
    }

    /**
     * @return int
     */
    public function getReviewId(): int
    {
        return $this->review_id;
    }


    /**
     * @return \DateTime
     */
    public function getReviewDate(): \DateTime
    {

        return $this->review_date;

    }

    /**
     * @param \DateTime $review_date
     */
    public function setReviewDate(\DateTime $review_date): void
    {
        $this->review_date = $review_date;
    }

    /**
     * @return User
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner(User $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return int
     */
    public function getRating():? int
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return VideoGame
     */
    public function getVideogame(): ?VideoGame
    {
        return $this->videogame;
    }

    /**
     * @param VideoGame $videogame
     */
    public function setVideogame(VideoGame $videogame): void
    {
        $this->videogame = $videogame;
    }

    /**
     * @return Collection
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @param Collection $comments
     */
    public function setComments(Collection $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function __toString()
    {
        $reviewToString = $this->owner->getUsername().":".$this->review_id;
        return $reviewToString;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }



}