<?php namespace Apiv1\Factory;

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
    public $limit;
    public $maxPages;
    private $pattern;

    public function __construct($activePattern = 1, $limit = null, $maxPages = 5 )
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

    public function make( array $content )
    {
        $counter = 0;
        $patternCounter = 0;
        $totalPatterns = count($this->pattern);
        $sorted = [];
        $allocatedSponsors = [];

        $articles = array_values($content['articles']); // reset the array keys as we'll be targeting them specifically

        $sponsors = $content['sponsors'];        

        while (count($articles) > 0)
        {
            $thisPattern = $this->pattern[$patternCounter];

             if( $thisPattern == "singleAd" and count($sponsors) > 0  )
             {
                 $thisAd = array_shift($sponsors);

                 $thisAd['displayStyle'] = 1;

                 $sorted[] = $thisAd;

                 $allocatedSponsors[] = $thisAd;
             }
             else if($thisPattern == "doubleAd" and count($sponsors) > 0 )
             {
                $thisAd = array_shift($sponsors);

                 $thisAd['displayStyle'] = 2;

                 $sorted[] = $thisAd;

                 $allocatedSponsors[] = $thisAd;
             }
             else
             {
                $thisArticle = $articles[$counter];

                $thisArticle['displayStyle'] = $thisPattern;

                $sorted[] = $thisArticle;

                unset($articles[$counter]);

                $counter++;
             }

             $patternCounter++;

             if( $totalPatterns == $patternCounter )
             {
                 $patternCounter = 0;
             }

             if( count($articles) == 0 )
             {
                break;
             }
        }

        $response = new \stdClass();
        $response->articles = $sorted;
        $response->sponsors = $allocatedSponsors;

        return $response;
    }
}