<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HeaderController extends Controller
{
    /**
     * @Route(service ="app.header_controller")
     */
    public function createHeader()
    {
        return $this->render('header/index.html.twig', [
            'controller_name' => 'HeaderController',
        ]);
    }
}
