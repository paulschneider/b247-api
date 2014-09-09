<?php namespace Apiv1\Repositories\Search;

use DB;
use Eloquent;
use Event;
use Apiv1\Repositories\Articles\ArticleRepository;

Class SearchRepository extends Eloquent {

    public function keywordSearch($term)
    {          
        # a list of words not to search for
        $ignored = ['the', 'is', 'that', 'there', 'a', 'i', 'as', 'of', 'this'];

        # make the provided term lowercase, URL safe and then explode it on the dash separators.
        $terms = explode('-', safename(strtolower($term)));

        # sanitise the keyword list so we are only left with searchable terms
        foreach($terms AS $term)
        {
            # if its not in the whitelist then we want to search by it
            if( ! in_array($term, $ignored) ) {
                $keywords[] = $term;    
            }           
        }      
        
        $query = DB::table('keyword')
            ->select('article_keyword.article_id', 'keyword.id', 'keyword.keyword')
            ->join('article_keyword', 'article_keyword.keyword_id', '=', 'keyword.id')
            ->whereIn('keyword', $terms)->get();    

        $entries = [];
        $articles = [];

        # work out how many article ID's were returned for this search
        foreach($query AS $term)
        {
            # if the term hasn't been seen before then add it in and init a counter
            if(! array_key_exists($term->keyword, $entries)) {
                $entries[$term->keyword] = 1;
            }
            # if we've seen the term before then increment the count
            else {
                $entries[$term->keyword]++; 
            }

            # and store the article ID so we can retrieve the article later on
            if(!in_array($term->article_id, $articles)) {
                $articles[] = $term->article_id;    
            }            
        }

        # store the search data so we have a record of it
        foreach($entries AS $term => $count)
        {
            Search::record($term, $count);
        }

        return ArticleRepository::getArticlesByIds($articles);
    }   
}
