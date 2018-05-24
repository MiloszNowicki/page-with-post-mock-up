<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use App\Controller\HeaderController;
use GuzzleHttp\Client;

class HomeController extends Controller
{

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)//(HeaderController $header)
    {
        $request;
        $title = $request->attributes->get('title');
        $cmsUrl = "https://cdn.contentful.com";
        $hardcodedRequestHeaderUrl= '/spaces/0wzf2bvw11ro/entries?access_token=da65e853a24aff691bb246b6c0fb1ebbdd6ddafcd5e135eb52106238a8b6260b&fields.slug=header&content_type=staticContent';
        $hardcodedRequestFooterUrl = '/spaces/0wzf2bvw11ro/entries?access_token=da65e853a24aff691bb246b6c0fb1ebbdd6ddafcd5e135eb52106238a8b6260b&fields.slug=footer&content_type=staticContent';
        $client = new Client([
            'base_uri' => $cmsUrl,
            'timeout' => 2.0,
        ]);
        $responseData  = json_decode($client->request('GET', $hardcodedRequestHeaderUrl,array('Accept' => 'application/json') )->getBody(), true);

        //$renderedTwigResponse =  $header -> createHeader($responseData);
            ///^^^^^^ this and that are returning same resoponse vvvvvvvvv
        $responseHeaderCtrl = $this->forward('App\Controller\HeaderController::createHeader', array('headerConfig' => $responseData));

        return $this->render('home/index.html.twig', [
            'header' => $responseHeaderCtrl->getContent(),
            'controller_name' =>$request->getBaseUrl(),
            'title' => $title,
        ]);
    }
}
