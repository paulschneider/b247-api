<?php namespace Apiv1\Transformers;

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
        // ensure we always get the body and that we always ignore the platform. The platform (mobile, web) determines what is returned. Ignore that in this case
        $options =  ['showBody' => true, 'ignorePlatform' => true];

        $body = $article['body'];

        $articleLocation = $article['location'][0];
        $externalPath = makePath( [ $articleLocation['channelSefName'], $articleLocation['subChannelSefName'], $articleLocation['categorySefName'], $article['sef_name'] ] );

        // grab the author of the article and store it temporarily
        $author = $article['author'][0]['name'];
    
        // grab the article continued item and store it or it will be removed
        $bodyContinued = $article['body_continued'];

        // we might want to show the article on a map. This helps with that.
        $mapItems = [
            'title' => $article['title'],
            'lat' => $article['lat'],
            'lon' => $article['lon'],
        ];

        // if this article has a gallery array then transform it
        if( isset($article['gallery']) )
        {
            $gallery = App::make( 'Apiv1\Transformers\MediaTransformer' )->transformCollection($article);
        }

        // transform the article itself
        $article = ArticleTransformer::transform($article, $options);

        // if there is a video then transfer that too and add it into the article array
        if( isset($article['video'][0]) )
        {
            $video = App::make( 'VideoTransformer' )->transform( $article['video'][0] );                

            $article['video'] = $video;
        }   

        // insert the body into the article after the sub heading
        $article = insertInto($article, 'subHeading', $body, 'body');

        // insert the temp bodyContinued in to the article at the desired position
        $article = insertInto($article, 'body', $bodyContinued, 'bodyContinued');

        // insert the author object into the article at the desired position
        $article = insertInto($article, 'bodyContinued', $author, 'author');

        // insert a mapItems object into the article at the desired position
        $article = insertInto($article, 'author', $mapItems, 'mapItems');                

        // insert a mapItems object into the article at the desired position
        $article = insertInto($article, 'path', $externalPath, 'shareLink');

        $article['gallery'] = $gallery;

        return $article;
    }

    // the apps still want certain bits of data about the article. Grab what they want and return a cut down article array
    public function extract($article)
    {
        return [
            'shareLink' => Config::get('api.baseUrl').$article['shareLink'],
            'map' => $article['mapItems'],
        ];
    }
}