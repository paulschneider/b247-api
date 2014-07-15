<?php namespace Version1\Search;

Class Search extends \Eloquent {

    protected $table = 'search';

    protected $rules = [];

    public static function record($term, $resultCount)
    {
        $result = Search::where('term', $term)->get();

        if( $result->isEmpty() )
        {
            $search = new Search;

            $search->term = $term;
            $search->count = 1;
            $search->max_results = $resultCount;

            $search->save();
        }
        else
        {
            $search = $result->first();

            $search->count = $search->count + 1;

            if($search->max_results <  $resultCount)
            {
                $search->max_results = $resultCount;   
            }

            $search->save();
        }
    }
}
