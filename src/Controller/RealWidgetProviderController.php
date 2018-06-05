<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RealWidgetProviderController extends Controller
{
    private $twig;
    private $cmsUrl = 'https://cdn.contentful.com/';
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function provideWidgets()
    {
        $url = $this->get('request_stack')->getCurrentRequest()->server->get('REDIRECT_URL');
        $slug = $id = substr($url, strrpos($url, '/') + 1);
        $contentLinkRequest = '/spaces/0wzf2bvw11ro/entries?access_token=da65e853a24aff691bb246b6c0fb1ebbdd6ddafcd5e135eb52106238a8b6260b&fields.slug=$slug&content_type=shortUrl';;
        $slugToReplace = array(
            '$slug' => $slug,
        );
        $formedRequest = strtr($contentLinkRequest, $slugToReplace);
        $articleData = $this->makeRequest($formedRequest);
        $fields = $articleData["includes"]["Entry"][0]["fields"];
        return $this->render('real_widget_provider/index.html.twig', [
            'controller_name' => 'RealWidgetProviderController',
        ]);
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
