<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\COntroller\ContactFormController;
use Symfony\Component\HttpFoundation\Response;

class WidgetProviderController extends Controller
{

    private $twig;
    private  $contact;
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function setContact(){
        $this->contact = $this->forward('App\Controller\ContactFormController::getContactForm', array())->getContent();
    }

    public function callWidget($widget) {
        $availableWidgetsCalls = ['contactForm' => $this->setContact()];
        $availableWidgetsCalls[$widget];
    }
    public function resolveWidgets(...$widgets)
    {
        $availableWidgets = ['contactForm' => 'contactForm'];
        foreach ($widgets as $widget) {
            if(array_key_exists($widget, $availableWidgets)){
                $this->callWidget($widget);
            }
        }
        return new Response($this->twig->render('widget_provider/index.html.twig', ['contact' => $this->contact]));
    }
}
