<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WhyController extends Controller
{
    /**
     * @Route("/why", name="why")
     */
    public function index()
    {
        return $this->render('why/index.html.twig', [
            'controller_name' => 'WhyController',
        ]);
    }
}
