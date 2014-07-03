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

    public function make( array $content, $type = "", $pages = 5 )
    {
        $counter = 0;
        $patternCounter = 0;
        $totalPatterns = count($this->pattern);
        $sorted = [];
        $pageCount = 1;
        $spaceCount = 0;

        $articles = array_values($content['articles']); // reset the array keys as we'll be targeting them specifically
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

                 $spaceCount = $spaceCount + 1;

                 $sorted[] = $sponsorTransformer->transform( $thisAd );
             }
             else if($thisPattern == "doubleAd" and count($sponsors) > 0 )
             {
                 $thisAd =  $sponsors->shift();

                 $thisAd = $thisAd->toArray();

                 $thisAd['display_style'] = 2;

                 $spaceCount = $spaceCount + 2;

                 $sorted[] = $sponsorTransformer->transform( $thisAd );
             }
             else
             {
                $thisArticle = $articles[$counter];

                $thisArticle['display_style'] = $thisPattern;

                $spaceCount = $spaceCount + $thisPattern;

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

             if( $spaceCount == 3 )
             {
                $spaceCount = 0;
            
                if( $pageCount == $pages )
                {
                    break;
                }

                $pageCount++;
             }             
        }

        $response = new \stdClass();
        $response->articles = $sorted;
        $response->sponsors = $sponsors;

        return $response;
    }
}
