<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * @Route(service ="app.header_controller")
 */
class HeaderController extends Controller
{
    public function createHeader()
    {
        return $this->render('header/index.html.twig', [

        ]);
    }
}
