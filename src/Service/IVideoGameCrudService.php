<?php
/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2018. 12. 14.
 * Time: 23:41
 */

namespace App\Service;


use App\Entity\VideoGame;
use Symfony\Component\Form\FormInterface;

interface IVideoGameCrudService
{
    /**
     * @return VideoGame[]
     */
    public function getAllVideoGames();

    /**
     * @param $review_id
     * @return VideoGame
     */
    public function getVideoGameByReview($review_id);

    /**
     * @param $game_id
     * @return VideoGame
     */
    public function getVideoGameById($game_id);

    /**
     * @param $videogame
     */
    public function saveVideoGame($videogame);

    /**
     * @param $game_id
     */
    public function deleteVideoGame($game_id);

    /**
     * @param $videogame
     * @return FormInterface
     */
    public function getVideoGameForm($videogame);
}