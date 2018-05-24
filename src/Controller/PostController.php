<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{
    /**
     * Matches /post exactly
     *
     * @Route("/post", name="post")
     */
    public function index( Request $request)
    {
        $atr = $request->attributes;
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    /**
     *
     *
     * @Route("/post/{page}", name="post_list", requirements={"page"="\d+"})
     */
    public function list( $page = 1 ) {
        $stop = 'sdsd';
        return $this->render('post/post-list.html.twig', []);
    }

    /**
     * Matches /post/*
     *
     * @Route("/post/{slug}", name="post_show")
     */
    public function show( $slug ) {
        return $this->render('post/single-post.html.twig', []);
    }
}
