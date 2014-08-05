<?php namespace Apiv1\Factory;

use stdClass;

Class PatternMaker
{
    private $patterns = [
        1 => [
                        //  [2 , 1]
            0 => 2,
            1 => 1,
                        //  [1 , 2]
            2 => 1,
            3 => 2,
                        //  [advert, 1]
            4 => "doubleAd",
            5 => 1,

            6 => 1,     // [1, 1, 1]
            7 => 1,
            8 => 1,

            9 => 1,     // [1, 1, 1]
            10 => 1,
            11 => 1,

            12 => 1,     // [1, advert]
            13 => "doubleAd",
        ]
    ];

    public $activePattern;
    public $size;
    private $pattern;

    public function __construct($activePattern = 1, $limit = null )
    {
        $this->activePattern = $activePattern;
        $this->pattern = $this->patterns[ $this->activePattern ];
    }

    public function setPattern($pattern)
    {
        $this->activePattern = $pattern;

        return $this;
    }

    public function limit($limit)
    {
        $this->size = $limit;

        return $this;
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
        $index = 0;
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

                 // we've added another item so increment the counter
                 $counter++;
             }
             else if($thisPattern == "doubleAd" and count($sponsors) > 0 )
             {
                $thisAd = array_shift($sponsors);

                 $thisAd['displayStyle'] = 2;

                 $sorted[] = $thisAd;

                 $allocatedSponsors[] = $thisAd;

                 // we've added another item so increment the counter
                 $counter++;
             }
             else
             {
                $thisArticle = $articles[$index];

                $thisArticle['displayStyle'] = $thisPattern;

                $sorted[] = $thisArticle;

                unset($articles[$index]);

                // we've added another item so increment the counter
                $counter++;
                $index++;
             }

             $patternCounter++;

             if( $totalPatterns == $patternCounter )
             {
                 $patternCounter = 0;
             }

             // if we've run out of articles or reached the required limit then stop doing what we're doing!
             if( count($articles) == 0 || $counter == $this->size )
             {
                break;
             }
        }

        // return something
        $response = new stdClass();
        $response->articles = $sorted;
        $response->sponsors = $allocatedSponsors;

        return $response;
    }
}