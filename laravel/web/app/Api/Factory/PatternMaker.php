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
            , 3 => 2
        //  [1, 1, 1]
            ,4 => 1
            , 5 => "doubleAd"
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

    public function getPattern()
    {
        return $this->activePattern;
    }

    public function make(array $transformers, array $content)
    {
        $counter = 0;
        $patternCounter = 0;
        $totalPatterns = count($this->pattern);
        $sorted = [];

        $articles = $content['articles'];
        $sponsors = $content['sponsors'];

        $sponsorTransformer = $transformers['sponsor'];
        $articleTransformer = $transformers['article'];

        while (count($articles) > 0)
        {
             $thisPattern = $this->pattern[$patternCounter];

             if( $thisPattern == "singleAd" )
             {
                 $thisAd = $sponsors->shift();

                 $thisAd = $thisAd->toArray();

                 $thisAd['display_style'] = 1;

                 $sorted[] = $sponsorTransformer->transform( $thisAd, [ 'showBody' => false] );
             }
             else if($thisPattern == "doubleAd")
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

                    $sorted[] = $articleTransformer->transform( $thisArticle, [ 'showBody' => false] );

                    unset($articles[$counter]);

                    $counter++;
             }

            $patternCounter++;

             if( $totalPatterns == $patternCounter )
             {
                 $patternCounter = 0;
             }
        }

        return $sorted;
    }
}
