<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WidgetProviderController extends Controller
{

    public function resolveWidgets(...$widgets)
    {
        $contact = null;
        $availableWidgets = ['contactForm' => $contact = ($this->forward('App\Controller\ContactFormController::getContactForm', array()))];
        foreach ($widgets as $widget){
            if(array_key_exists($widget, $availableWidgets)){
                $availableWidgets[$widget];
            }
        }
        return $this->render('widget_provider/index.html.twig', [
            'contact' => $contact->getContent(),
        ]);
    }
}
