<?php
/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2018. 12. 15.
 * Time: 14:38
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 * @Route("/")
 */
class HomeController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @Route(path="/",name="home")
     */
    public function HomeAction(Request $request) : Response
    {
        $twigParams = array("error"=>"", "last_username"=>"");
        $authUtils = $this->get("security.authentication_utils");
        $twigParams["error"]=$authUtils->getLastAuthenticationError();
        $twigParams["last_username"]=$authUtils->getLastUsername();
        return $this->render("home.html.twig",$twigParams);
    }
}