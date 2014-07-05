<?php namespace Api\Factory;

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

    public $articleTransformer;
    public $sponsorTransformer;

    public function __construct($activePattern = 1, $limit = null, $maxPages = 5 )
    {
        $this->articleTransformer = \App::make('ArticleTransformer');
        $this->sponsorTransformer = \App::make('SponsorTransformer');

        $this->activePattern = $activePattern;
        $this->pattern = $this->patterns[ $this->activePattern ];
        $this->limit = $limit;
        $this->pages = $maxPages;
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
        $iterationCounter = 1;
        $totalPatterns = count($this->pattern);
        $sorted = [];
        $pageCount = 1;
        $spaceCount = 0;
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

                 $spaceCount = $spaceCount + 1;

                 $sorted[] = $thisAd;

                 $allocatedSponsors[] = $thisAd;
             }
             else if($thisPattern == "doubleAd" and count($sponsors) > 0 )
             {
                $thisAd = array_shift($sponsors);

                 $thisAd['displayStyle'] = 2;

                 $spaceCount = $spaceCount + 2;

                 $sorted[] = $thisAd;

                 $allocatedSponsors[] = $thisAd;
             }
             else
             {
                $thisArticle = $articles[$counter];

                $thisArticle['displayStyle'] = $thisPattern;

                $spaceCount = $spaceCount + $thisPattern;

                $sorted[] = $thisArticle;

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
            
                if( $pageCount == $this->maxPages )
                {
                    break;
                }

                $pageCount++;
             }  

             if( $iterationCounter == $this->limit )
             {
                break;
             }
             
            $iterationCounter++;
        }

        $response = new \stdClass();
        $response->articles = $sorted;
        $response->sponsors = $allocatedSponsors;

        return $response;
    }
}
