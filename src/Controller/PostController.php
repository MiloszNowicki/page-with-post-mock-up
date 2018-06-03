<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;
use App\Controller\WidgetProviderController;

class PostController extends Controller
{

    private  $contentLinkRequest = '/spaces/0wzf2bvw11ro/entries?access_token=da65e853a24aff691bb246b6c0fb1ebbdd6ddafcd5e135eb52106238a8b6260b&fields.slug=why-we-are-the-best&content_type=shortUrl';
    private $cmsUrl = 'https://cdn.contentful.com/';





    /**
     * Matches /post exactly
     *
     * @Route("/post", name="post")
     */
    public function index()
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }



    /**
     *
     *
     * @Route("/post/{page}", name="post_list", requirements={"page"="\d+"})
     */
    public function list( $page = 1 ) {
        $linkData = $this->makeRequest($this->contentLinkRequest);
        $slug = $linkData['items'][0]['fields']['slug'];
        $id = $linkData['items'][0]['fields']['page']['sys']['id'];
        $url = $this->generateUrl('post_show', array('slug' => $slug, 'id' => $id));
        return $this->render('post/post-list.html.twig', ['url' => $url]);
    }

    /**
     * Matches /post/*
     *
     * @Route("/post/{slug}/{id}", name="post_show")
     */
    public function show( $id ) {

        $linkData = $this->getArticleById($id);
        $title = $linkData['includes']['Entry'][0]['fields']['title'];
        $widgets = $this->forward('App\Controller\WidgetProviderController::resolveWidgets', array('widgets' => ['contactForm', 'why']));
        $content = $linkData['includes']['Entry'][0]['fields']['content'];
        return $this->render('post/single-post.html.twig', ['widgets' => $widgets->getContent(), 'title' => $title, 'content' => $content]);
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

    public function getArticleById($id){
        $url = '\/\^/\get the post by id, its mocked, so fuck off/\^/\/';
        $articleData = $linkData = $this->makeRequest($this->contentLinkRequest);
        return $articleData;
    }
}
