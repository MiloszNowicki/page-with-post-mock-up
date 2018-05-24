<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class FooterController extends Controller
{
    private $request;

    public function __invoke(Request $request){
        $hello = $request->attributes;
        return $this->createFooter($request);
    }
    public function createFooter($request){
        $footerRequest = $request->attributes->get('parameters');
        return $this->render('footer/index.html.twig', [
            'controller_name' => $request->getBaseUrl(),
        ]);
    }
}
