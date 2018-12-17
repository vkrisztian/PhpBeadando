<?php
/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2018. 12. 15.
 * Time: 14:26
 */

namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LoginController
 * @package App\Controller
 * @Route("/login")
 */
class LoginController extends Controller
{

    /**
     * @param Request $request
     * @return Response
     * @Route(path="/",name="login")
     */
    public function loginAction(Request $request) :Response
    {
        $twigParams = array("error"=>"", "last_username"=>"");
        $authUtils = $this->get("security.authentication_utils");
        $twigParams["error"]=$authUtils->getLastAuthenticationError();
        $twigParams["last_username"]=$authUtils->getLastUsername();
        return $this->render("login.html.twig", $twigParams);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(path="/logout", name="logout")
     */
    public function logoutAction(Request $request) : Response
    {
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(path="/register", name="register")
     */
    public function registerAction(Request $request) : Response
    {

        $user = new User();
        $uname = $request->request->get("_username");
        $clearpass = $request->request->get("_password");
        $hashpass = $this->get("security.password_encoder")->encodePassword($user, $clearpass);
        $user->setUserEmail($uname);
        $user->setUserPass($hashpass);
        $user->setUserRank("USER");
        try {
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("notice", "USER {$uname} REGISTERED");
        }
        catch (\Exception $ex){
            $this->addFlash("notice", "ERROR {$ex->getMessage()}");
        }
        return $this->redirectToRoute("login");
    }
}