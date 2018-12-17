<?php
/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2018. 12. 15.
 * Time: 17:07
 */

namespace App\Controller;


use App\Entity\VideoGame;
use App\Service\IVideoGameCrudService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VideoGameController extends Controller
{

    /**
     * @var IVideoGameCrudService
     */
    private $videogameService;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->videogameService=$container->get('app.videogames');
    }


    /**
     * @param Request $request
     * @return mixed
     * @Route("/games", name="games")
     */
    public function listAction(Request $request) {

        $games = $this->videogameService->getAllVideoGames();
        $twigParams = array("games"=>$games);
        return $this->render('Game/games.html.twig', $twigParams);
    }

    /**
     * @Route("/gamedel/{gameId}", name="gamedel")
     */
    public function delAction(Request $request,$gameId)
    {
        $this->videogameService->deleteVideoGame($gameId);
        $this->addFlash('notice', 'VIDEO GAME DELETED');
        return $this->redirectToRoute('games');
    }

    /**
     * @Route("/gameedit/{gameId}", name="gameedit")
     */
    public function editAction(Request $request,$gameId = 0)
    {
        if ($gameId){
            $game = $this->videogameService->getVideoGameById($gameId);
        } else {
            $game = new VideoGame();
        }
        $form = $this->videogameService->getVideoGameForm($game);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->videogameService->saveVideoGame($game);
            $this->addFlash('notice', 'GAMES EDITED');
            return $this->redirectToRoute('games');
        }
        return $this->render('Game/gameedit.html.twig',
            ["form"=>$form->createView()]);
    }

    /**
     * @Route("/gameShow/{gameId}", name="gameShow")
     */
    public function showReview(Request $request,$gameId)
    {
        $game = $this->videogameService->getVideoGameById($gameId);
        return $this->render('Game/game.html.twig',["game"=>$game]);

    }

}