<?php

namespace App\Controller;

use function GuzzleHttp\default_ca_bundle;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    private $twig;
    private $landingPage;
    private $article;
    private $noArticle;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    private $cmsUrl = 'https://cdn.contentful.com/';
    /**
     * @Route("/article", name="article")
     */
    public function index()
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
    /**
     *
     *
     * @Route("/{article}", name="article_article")
     */
    public function article($article)
    {
        $url = $this->get('request_stack')->getCurrentRequest()->server->get('REDIRECT_URL');
        $slug = $id = $this->get('request_stack')->getCurrentRequest()->attributes->get('article');// get current request
        $contentLinkRequest = '/spaces/0wzf2bvw11ro/entries?access_token=da65e853a24aff691bb246b6c0fb1ebbdd6ddafcd5e135eb52106238a8b6260b&fields.slug=$slug&content_type=shortUrl';;
        $slugToReplace = array(
            '$slug' => $slug,
        );
        $formedRequest = strtr($contentLinkRequest, $slugToReplace);
        $articleData = $this->makeRequest($formedRequest);

        if(!isset($articleData['includes'])) {
            return $this->matchContentTypeWithTemplate('noArticle', []);
        }
        $contentType = $articleData["includes"]["Entry"][0]["sys"]["contentType"]["sys"]["id"];
        $fields = $articleData["includes"]["Entry"][0]["fields"];
        return $this->matchContentTypeWithTemplate($contentType, $article);
    }

    public function matchContentTypeWithTemplate($contentType, $article) {

        $slug = $article;
        switch ($contentType) {
            case 'productLandingPage':
                $content = $this->forward('App\Controller\LandingPageController::getLandingPage', array())->getContent();
                break;
            case 'article':
                $content = $this->forward('App\Controller\RealPostController::getRealPost', array())->getContent();
            break;
            case 'noArticle':
                $content = $this->whatever();
            break;
            default:
                echo 'welp, its a dead end'; die();
            break;

        }

        if(isset($content)) {
            return new Response($content);
        } else
        {
            echo 'there is no content, eat shit and';
            die();
        }
    }

    public function callTemplate($contentType, $article) {
        $availableTemplates = [
            'productLandingPage' => $this->setLandingPage($article),
            'article' => $this->whatever(),
            'noArticle' => $this->whatever(),
        ];
        $availableTemplates[$contentType];
    }
//
//    public function setLandingPage($article) {
//        $this->landingPage = $this->forward('App\Controller\LandingPageController::getLandingPage', array($article))->getContent();
//    }

    public function whatever() {
        return new Response($this->render('article/no-article.html.twig', []));
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
