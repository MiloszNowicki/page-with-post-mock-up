<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WidgetProviderController extends Controller
{
    /**
     * @Route("/widget/provider", name="widget_provider")
     */
    public function index()
    {
        return $this->render('widget_provider/index.html.twig', [
            'controller_name' => 'WidgetProviderController',
        ]);
    }
}
