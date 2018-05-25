<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;

class FooterController extends Controller
{
    private $request;
    private $headerRequest = '/spaces/0wzf2bvw11ro/entries?access_token=da65e853a24aff691bb246b6c0fb1ebbdd6ddafcd5e135eb52106238a8b6260b&fields.slug=header&content_type=staticContent';
    private $footerRequest = '/spaces/0wzf2bvw11ro/entries?access_token=da65e853a24aff691bb246b6c0fb1ebbdd6ddafcd5e135eb52106238a8b6260b&fields.slug=footer&content_type=staticContent';
    private $footerBlankRequest = '/#';
    private $defaultRequest = '/spaces/0wzf2bvw11ro/entries?access_token=da65e853a24aff691bb246b6c0fb1ebbdd6ddafcd5e135eb52106238a8b6260b&fields.slug=footer&content_type=staticContent';

    private $cmsUrl = "https://cdn.contentful.com";
    public function __invoke() {
        return $this->createFooter();
    }
    public function createFooter() {
        $footerData = $this->getProprerData();
        $content = $footerData['items'][0]['fields']['content'];
        return $this->render('footer/index.html.twig', [
            'content' =>  $content,
        ]);
    }

    public function getProprerData() {
        $domain = $this->get('request_stack')->getCurrentRequest()->server->get('HTTP_HOST');
        $route = $this->get('request_stack')->getCurrentRequest()->server->get('REDIRECT_URL');
        $baseUriRequests = [
            'www.aramis.local' => $this->footerRequest,
            'www.aramis.pl' => $this->footerBlankRequest,
        ];

        $routeRequestUri = [
            '/post' => $this->headerRequest,
            '/post/regex' => $this->footerRequest
        ];

        if(array_key_exists($route, $routeRequestUri)) {
            return $this->makeRequest($routeRequestUri[$route]);
        }

        if(array_key_exists($domain, $baseUriRequests)) {
            return $this->makeRequest($baseUriRequests[$domain]);
        }

        return $this->makeRequest($this->defaultRequest);

    }

    public function makeRequest($url) {
        $client = new Client([
            'base_uri' => $this->cmsUrl,
            'timeout' => 2.0,
        ]);
        return json_decode($client->request(
            'GET',
            $url,
            array('Accept' => 'applpication/json'))->getBody(), true);
    }
}
