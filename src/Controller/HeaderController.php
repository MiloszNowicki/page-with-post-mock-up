<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route(service ="app.header_controller")
 */
class HeaderController extends Controller
{
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function createHeader($headerConfig)
    {

        $content = $this->twig->render('header/index.html.twig', [
            'header' => 'header',
        ]);
        return new Response($content);
    }
}
