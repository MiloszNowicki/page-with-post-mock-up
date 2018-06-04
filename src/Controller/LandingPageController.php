<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LandingPageController extends Controller
{
    private $twig;

    public function __contruct(\Twig_Environment $twig) {
        $this->twig = $twig;
    }

    public function getLandingPage($article) {
        $contentLinkRequest = '/spaces/0wzf2bvw11ro/entries?access_token=da65e853a24aff691bb246b6c0fb1ebbdd6ddafcd5e135eb52106238a8b6260b&fields.slug=$slug&content_type=shortUrl';
        $slugToReplace = array(
            '$slug' => $article
        );
    }

}
