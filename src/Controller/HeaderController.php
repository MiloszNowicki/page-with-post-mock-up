<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;

class HeaderController extends Controller
{
    private $config = [
        'headerRequest' => '/spaces/0wzf2bvw11ro/entries?access_token=da65e853a24aff691bb246b6c0fb1ebbdd6ddafcd5e135eb52106238a8b6260b&fields.slug=header&content_type=staticContent',
        'footerRequest' => '/spaces/0wzf2bvw11ro/entries?access_token=da65e853a24aff691bb246b6c0fb1ebbdd6ddafcd5e135eb52106238a8b6260b&fields.slug=footer&content_type=staticContent',
        'defaultRequest' => '/spaces/0wzf2bvw11ro/entries?access_token=da65e853a24aff691bb246b6c0fb1ebbdd6ddafcd5e135eb52106238a8b6260b&fields.slug=header&content_type=staticContent',
        'headerBlankRequest' => '/#',
        'cmsUrl' =>"https://cdn.contentful.com",
    ];

    public function __invoke() {
        return $this->createHeader();
    }
    public function createHeader() {
        $headerData = $this->getProprerData();
        $content = $headerData['items'][0]['fields']['content'];
        return $this->render('header/index.html.twig', [
            'content' =>  $content,
        ]);
    }

    public function getProprerData() {
        $domain = $this->get('request_stack')->getCurrentRequest()->server->get('HTTP_HOST');
        $route = $this->get('request_stack')->getCurrentRequest()->server->get('REDIRECT_URL');
        $baseUriRequests = [
            'www.aramis.local' => $this->config['headerRequest'],
            'www.aramis.pl' => $this->config['headerBlankRequest'],
        ];

        $routeRequestUri = [
            '/post' => $this->config['footerRequest'],
            '/post/regex' => $this->config['footerRequest'],
        ];

        if(array_key_exists($route, $routeRequestUri)) {
            return $this->makeRequest($routeRequestUri[$route]);
        }

        if(array_key_exists($domain, $baseUriRequests)) {
            return $this->makeRequest($baseUriRequests[$domain]);
        }

        return $this->makeRequest($this->config['defaultRequest']);

    }

    public function makeRequest($url) {
        $client = new Client([
            'base_uri' => $this->config['cmsUrl'],
            'timeout' => 2.0,
        ]);
        return json_decode($client->request(
            'GET',
            $url,
            array('Accept' => 'applpication/json'))->getBody(), true);
    }
}


//    private $twig;
//
//    public function __construct(\Twig_Environment $twig)
//    {
//        $this->twig = $twig;
//    }
//
//    public function createHeader($headerConfig)
//    {
//
//        $content = $this->twig->render('header/index.html.twig', [
//            'header' => 'header',
//        ]);
//        return new Response($content);
//    }
//$dataToUrlConfig = [
//            'www.aramis.local/' => $this->headerRequest,
//            'www.aramis.pl' => $this->headerBlankRequest,
//            'www.aramis.local/post' => $this->footerRequest,
//            'www.aramis.local/post/*' => $this->footerRequest,
//        ];
