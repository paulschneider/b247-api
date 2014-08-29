<?php namespace Apiv1\Responders;

use Input;
use time;
use App;
use Carbon\Carbon;

Class ChannelListingResponder {

	public function make( $channel, $user )
	{
        $range = Input::get('range') ? Input::get('range') : 'week';
        $time = Input::get('time') ? Input::get('time') : time();		

        $articles = $this->getArticlesInRange( $channel, $range, $time, $user );	

        return [
        	'days' => $articles,
        	'numberOfDays' => count($articles)
        ];
	}

    public function getArticlesInRange($channel, $range, $time, $user)
    {
        $subChannelId = getSubChannelId($channel);

        $articles = App::make('ArticleRepository')->getChannelListing( $subChannelId, 999, $range, $time, $user );

        # if we have a user we need to filter all articles and remove any they have opted out of
        if(!is_null($user)) {
            $articles = App::make('Apiv1\Tools\ContentFilter')->setUser($user)->filterArticlesByUserCategory($articles);
        }

        if( $range == "week" )
        {
            $days = [];

            $dateStamp = convertTimestamp( 'Y-m-d', $time);

            $dateArray = explode('-', $dateStamp); 

            for( $i = 0; $i < 7; $i++ )
            {
                if( $i == 0 )
                {
                    $date = Carbon::create($dateArray[0], $dateArray[1], $dateArray[2], '00', '00', '01')->toDateString();

                    $days[$date] = [];
                }
                else
                {
                    $dateArray = explode('-', $date); 
                    $date = Carbon::create($dateArray[0], $dateArray[1], $dateArray[2], '00', '00', '01')->addDays(1)->toDateString();

                    $days[$date] = [];
                }
            }

            return App::make('ListingTransformer')->transformCollection( $articles, [ 'perDayLimit' => 999, 'days' => $days ] );
        }
        else if( $range == "day" )
        {         
            $articles = App::make('ListingTransformer')->transform( $articles, ['day' => date('Y-m-d', $time)] );
        }

        return $articles;
    }
}