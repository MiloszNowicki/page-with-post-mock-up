<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;

class RealPostController extends Controller
{
    private $twig;
    private $cmsUrl = 'https://cdn.contentful.com/';

    public function __construct(\Twig_Environment $twig) {
        $this->twig = $twig;
    }

    public function getRealPost()
    {
        $url = $this->get('request_stack')->getCurrentRequest()->server->get('REDIRECT_URL');
        $slug = $id = substr($url,  strrpos($url, '/') + 1);
        $contentLinkRequest = '/spaces/0wzf2bvw11ro/entries?access_token=da65e853a24aff691bb246b6c0fb1ebbdd6ddafcd5e135eb52106238a8b6260b&fields.slug=$slug&content_type=shortUrl';;
        $slugToReplace = array(
            '$slug' => $slug,
        );
        $formedRequest = strtr($contentLinkRequest, $slugToReplace);
        $articleData = $this->makeRequest($formedRequest);
        $fields = $articleData["includes"]["Entry"][0]["fields"];
        $content = $this->twig->render('real_post/single-post.html.twig', array(
            'title' => $fields['title'],
            'content' => $fields['content'],
            ));
       return new Response($content);
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
