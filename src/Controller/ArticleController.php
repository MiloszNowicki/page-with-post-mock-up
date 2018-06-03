<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GuzzleHttp\Client;

class ArticleController extends Controller
{
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
    public function article( $article)
    {
        $contentLinkRequest = '/spaces/0wzf2bvw11ro/entries?access_token=da65e853a24aff691bb246b6c0fb1ebbdd6ddafcd5e135eb52106238a8b6260b&fields.slug=$slug&content_type=shortUrl';
        $slugToReplace = array(
          '$slug' => $article
        );
        $formedRequest = strtr($contentLinkRequest, $slugToReplace);
        $articleData = $this->makeRequest($formedRequest);
        if(!isset($articleData['includes'])) {
            return $this->matchContentTypeWithTemplate('noArticle', []);
        }
        $contentType = $articleData["includes"]["Entry"][0]["sys"]["contentType"]["sys"]["id"];
        $fields = $articleData["includes"]["Entry"][0]["fields"];
        return $this->matchContentTypeWithTemplate($contentType, $fields);
    }

    public function matchContentTypeWithTemplate($contentType, $fields) {
        $availableTemplates =[
            'productLandingPage' => $this->render('article/product-landing-page.html.twig', []),
            'article' => $this->render('article/single-post.html.twig', []),
            'noArticle' => $this->render('article/no-article.html.twig', []),
        ];
        if(array_key_exists( $contentType, $availableTemplates)) {
            return $availableTemplates[$contentType];
        }
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