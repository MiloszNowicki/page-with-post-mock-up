<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Controller\HeaderController;
use GuzzleHttp\Client;

class HomeController extends Controller
{

    /**
     * @Route("/", name="home")
     */
    public function index(HeaderController $header)
    {
        $cmsUrl = "https://cdn.contentful.com";
        $hardcodedRequestHeaderUrl= '/spaces/0wzf2bvw11ro/entries?access_token=da65e853a24aff691bb246b6c0fb1ebbdd6ddafcd5e135eb52106238a8b6260b&fields.slug=header&content_type=staticContent';
        $hardcodedRequestFooterUrl = '/spaces/0wzf2bvw11ro/entries?access_token=da65e853a24aff691bb246b6c0fb1ebbdd6ddafcd5e135eb52106238a8b6260b&fields.slug=footer&content_type=staticContent';
        $client = new Client([
            'base_uri' => $cmsUrl,
            'timeout' => 2.0,
        ]);
        $response = $client->request('GET', $hardcodedRequestHeaderUrl,array('Accept' => 'application/json') );
        $responseData  = json_decode($response->getBody(), true);

        return $this->render('home/index.html.twig', [ 'header' => $header -> createHeader(),
            'controller_name' =>$response->getStatusCode(),
        ]);
    }
}
