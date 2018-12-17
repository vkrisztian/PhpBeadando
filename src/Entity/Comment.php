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
 * @ORM\Table(name="comments")
 * @ORM\HasLifecycleCallbacks
 */
class Comment
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $comment_id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="user_comments")
     * @ORM\JoinColumn(name="owner", referencedColumnName="user_id")
     */
    private $owner;

    /**
     * @var Review
     * @ORM\ManyToOne(targetEntity="Review", inversedBy="$comments")
     * @ORM\JoinColumn(name="review", referencedColumnName="review_id")
     */
    private $review;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $rating;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $content;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $comment_date;


    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps(){

        if ($this->comment_date==null){
            $this->comment_date=new \DateTime();
        }
    }

    /**
     * @return int
     */
    public function getCommentId(): int
    {
        return $this->comment_id;
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
     * @return Review
     */
    public function getReview(): Review
    {
        return $this->review;
    }

    /**
     * @param Review $review
     */
    public function setReview(Review $review): void
    {
        $this->review = $review;
    }

    /**
     * @return int
     */
    public function getRating(): int
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
     * @return string
     */
    public function getContent(): string
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

    /**
     * @return \DateTime
     */
    public function getCommentDate(): \DateTime
    {
        return $this->comment_date;
    }

    /**
     * @param \DateTime $comment_date
     */
    public function setCommentDate(\DateTime $comment_date): void
    {
        $this->comment_date = $comment_date;
    }

    public function __toString()
    {
        $commentToString = $this->owner->getUsername().":".$this->comment_id;
        return $commentToString;
    }


}