<?php namespace Apiv1\Transformers;

/**
 * The following transformer, in addition to transforming the usual article data
 * also adds in a load of data that the article templates need. If this isn't done here
 * anything that was retrieved by the DB call that isn't transformed by ArticleTransformer
 * will be lost.
 */

use App;
use Config;

Class ArticleTemplateTransformer extends ArticleTransformer {

    /**
     * Transform a single result into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $article, $options = [] )
    {
        $video = null;

        # listings article content varies dependent on the day it is being viewed.
        # For these a timestamp is provided which is used to determine what to show
        if(isset($options['eventDay'])) {
            $day = $options['eventDay'];
        }
        # if we don't have it then its just a normal article and we don't care about the day
        else {
            $day = null;
        }

        # ensure we always get the body and that we always ignore the platform. The platform (mobile, web) determines what is returned. Ignore that in this case
        $options =  ['showBody' => true, 'ignorePlatform' => true, 'eventDay' => $day];

        $body = $article['body'];

        $articleLocation = $article['location'][0];
        $externalPath = makePath( [ $articleLocation['channelSefName'], $articleLocation['subChannelSefName'], $articleLocation['categorySefName'], $article['sef_name'] ] );

        # grab the author of the article and store it temporarily
        if(isset($article['author'][0])) {
            $author = $article['author'][0]['name'];    
        }
        else {
            $author = null;
        }

        # gather up the articles category assignments
        $categoryAssignment = App::make('Apiv1\Transformers\CategoryLocationTransformer')->transformCollection($article['location']);
    
        # grab the article continued item and store it or it will be removed
        $bodyContinued = $article['body_continued'];

        # we might want to show the article on a map. This helps with that.
        $mapItems = [
            'title' => $article['title'],
            'lat' => $article['lat'],
            'lon' => $article['lon'],
        ];

        # if this article has a gallery array then transform it
        if( isset($article['gallery']) ) {
            $gallery = App::make( 'Apiv1\Transformers\MediaTransformer' )->transformCollection($article);
        }   

        # if there's a video grab it before its over-written
        if( isset($article['video'][0]) ) {
            $video = $article['video'][0];
        }

        # transform the article itself
        $article = ArticleTransformer::transform($article, $options);

        # if there is a video then transfer that too and add it into the article array
        if( ! is_null($video) )
        {
            $video = App::make( 'VideoTransformer' )->transform( $video );                

            // assign the video to the article
            $article['video'] = $video;
        }   

        # insert the body into the article after the sub heading
        $article = insertInto($article, 'subHeading', $body, 'body');

        # insert the temp bodyContinued in to the article at the desired position
        $article = insertInto($article, 'body', $bodyContinued, 'bodyContinued');

        # insert the author object into the article at the desired position
        $article = insertInto($article, 'bodyContinued', $author, 'author');

        # insert a mapItems object into the article at the desired position
        $article = insertInto($article, 'author', $mapItems, 'mapItems');                

        # insert a mapItems object into the article at the desired position
        $article = insertInto($article, 'path', $externalPath, 'shareLink');

        # insert a list of categories against which this article has been assigned
        $article = insertInto($article, 'shareLink', $categoryAssignment, 'categoryAssignment');

        # and finally add the gallery images array to the article
        $article['gallery'] = $gallery;

        # .... and send it back
        return $article;
    }

    # the apps still want certain bits of data about the article. Grab what they want 
    # and return a cut down article array
    public function extract($article)
    {
        return [
            'shareLink' => Config::get('api.baseUrl').$article['shareLink'],
            'map' => $article['mapItems'],
        ];
    }
}