<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class WhyController extends Controller
{
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }
    public function getWhyQarson()
    {
        $content = $this->twig->render('why/index.html.twig', [
            'controller_name' => 'WhyController',
        ]);
        return new Response($content);
    }
}
