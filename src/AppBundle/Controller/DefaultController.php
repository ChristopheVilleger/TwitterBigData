<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TwitterAPIExchange;

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

        $settings = array(
            'oauth_access_token' => "630733550-nvIuANoKVx4XuY0NVuucosKhlpFfWLGZ2MVKoIXG",
            'oauth_access_token_secret' => " O7wOcUs6pjgECPJ6ns532ARk0oAGo85MRceOArjWnlxCy",
            'consumer_key' => "YjlJasQ7OLNyFgkGs1QSCmG70",
            'consumer_secret' => "OfsKYPGmqnzEpKHuLUEetcSidcNrSltkW8E4cSZLNTieTA5ZGA"
        );

        $url = 'https://api.twitter.com/1.1/search/tweets.json';

        $getfield = '?q=' . $q;
        $requestMethod = 'GET';

        $twitter = new TwitterAPIExchange($settings);
        $resp = $twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();

        return $this->render('default/search.html.twig', [
            'resp' => $resp
        ]);
    }
}
