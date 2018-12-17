<?php
/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2018. 12. 15.
 * Time: 0:48
 */

namespace App\Service;


use App\Entity\VideoGame;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VideoGameCrudService extends CrudService implements IVideoGameCrudService
{

    public function __construct($em, $form, $request)
    {
        parent::__construct($em, $form, $request);
    }
    /**
     * @inheritDoc
     */
    public function getRepo()
    {
        return $this->em->getRepository(VideoGame::class);
    }

    /**
     * @inheritDoc
     */
    public function getAllVideoGames()
    {
        return $this->getRepo()->findAll();
    }

    /**
     * @inheritDoc
     */
    public function getVideoGameByReview($review_id)
    {
        return $this->getRepo()->findBy(["game_review"=>$review_id]);
    }

    /**
     * @inheritDoc
     */
    public function getVideoGameById($game_id)
    {
        $game = $this->getRepo()->find($game_id);
        if (!$game){
            throw new NotFoundHttpException("VIDEO GAME NOT FOUND");
        }
        return $game;
    }

    /**
     * @inheritDoc
     */
    public function saveVideoGame($videogame)
    {
        $this->em->persist($videogame);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function deleteVideoGame($game_id)
    {
        $game = $this->getVideoGameById($game_id);
        $this->em->remove($game);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function getVideoGameForm($videogame)
    {
        $form = $this->formFactory->createBuilder(FormType::class, $videogame);
        $form->add("genre", TextType::class, [
            'required'=>true
        ]);
        $form->add("name", TextType::class, [
            'required'=>true
        ]);
        $form->add("developer", TextType::class, [
            'required'=>true
        ]);
        $form->add("release_year", TextType::class, [
            'required'=>true
        ]);
        $form->add("cost", NumberType::class, [
            'required'=>true
        ]);
        $form->add("SAVE", SubmitType::class);
        return $form->getForm();
    }


}