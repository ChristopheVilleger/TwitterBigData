<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
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
            'oauth_access_token' => $this->getParameter('oauth_access_token'),
            'oauth_access_token_secret' => $this->getParameter('oauth_access_token_secret'),
            'consumer_key' => $this->getParameter('consumer_key'),
            'consumer_secret' => $this->getParameter('consumer_secret')
        );

        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $requestMethod = 'GET';
        $getfield = '?count=100&result_type=mixed&q=%23' . $q;
        $twitter = new TwitterAPIExchange($settings);

        $tweets = array();
        $i = 0;
        foreach(range(0,9) as $i){
            $i++;
            $resp = json_decode($twitter->setGetfield($getfield)
                ->buildOauth($url, $requestMethod)
                ->performRequest(),$assoc = TRUE);

            $statuses = $resp['statuses'];

            foreach($statuses as $status){
                $tweets[] = $status;
            }
            if(isset($resp['search_metadata']['next_results'])){
                $getfield = $resp['search_metadata']['next_results'];
            }else{
                break;
            }
        }

        $fs = new Filesystem();
        $fs->dumpFile('/var/www/public/twitterbigdata/newTest.json', json_encode($tweets));


        return $this->render('default/search.html.twig', [
            'tweets' => json_encode($tweets)
        ]);
    }
}
