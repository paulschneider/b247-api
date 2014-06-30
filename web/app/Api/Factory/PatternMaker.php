<?php namespace Api\Factory;

use Api\Transformers\ArticleTransformer;
use Api\Transformers\SponsorTransformer;

Class PatternMaker
{
    private $patterns = [
        1 => [
                        //  [2 , 1]
            0 => "doubleAd"
            , 1 => 1
                        //  [2 , 1]
            , 2 => 1
            , 3 => "doubleAd"
                        //  [1, 2]
            ,4 => 1
            , 5 => 2
        ]
        ,2 => [
                        //  [1 , 2]
            0 => "singleAd"
            , 1 => 2
                        //  [2 , 1]
            , 2 => 1
            , 3 => 2
                        //  [1, 1, 1]
            ,4 => "doubleAd"
            , 5 => 1
        ]
    ];

    public $activePattern;

    private $pattern;

    public function __construct($activePattern = 1)
    {
        $this->activePattern = $activePattern;
        $this->pattern = $this->patterns[ $this->activePattern ];
    }

    public function setPattern($pattern)
    {
        $this->activePattern = $pattern;
    }

    public function getPattern()
    {
        return $this->activePattern;
    }

    public function make( array $content, $type = "" )
    {
        $counter = 0;
        $patternCounter = 0;
        $totalPatterns = count($this->pattern);
        $sorted = [];

        $articles = $content['articles'];
        $sponsors = $content['sponsors'];

        $sponsorTransformer = new SponsorTransformer();
        $articleTransformer = new ArticleTransformer();



        while (count($articles) > 0)
        {
            $thisPattern = $this->pattern[$patternCounter];

             if( $thisPattern == "singleAd" and count($sponsors) > 0  )
             {
                 $thisAd = $sponsors->shift();

                 $thisAd = $thisAd->toArray();

                 $thisAd['display_style'] = 1;

                 $sorted[] = $sponsorTransformer->transform( $thisAd, [ 'showBody' => false] );
             }
             else if($thisPattern == "doubleAd" and count($sponsors) > 0 )
             {
                 $thisAd =  $sponsors->shift();

                 $thisAd = $thisAd->toArray();

                 $thisAd['display_style'] = 2;

                 $sorted[] = $sponsorTransformer->transform( $thisAd, [ 'showBody' => false] );
             }
             else
             {
                $thisArticle = $articles[$counter];

                $thisArticle['display_style'] = $thisPattern;

                $article = $articleTransformer->transform( $thisArticle, [ 'showBody' => false] );

                // make sure the transformer returned something
                if( ! is_null($article) )
                {
                    $sorted[] = $article;
                }

                unset($articles[$counter]);

                $counter++;
             }

             $patternCounter++;

             if( $totalPatterns == $patternCounter )
             {
                 $patternCounter = 0;
             }
        }

        $response = new \stdClass();
        $response->articles = $sorted;
        $response->sponsors = $sponsors;

        return $response;
    }
}
