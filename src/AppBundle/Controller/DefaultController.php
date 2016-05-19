<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }

    public function searchAction(Request $request)
    {
        $q = $request->get('q');
        if(empty($q)){
            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/search.html.twig', [
            'q' => $q
        ]);
    }
}
