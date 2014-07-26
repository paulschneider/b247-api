<?php namespace Api\Transformers;

use App;

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

        // grab the article continued item and store it or it will be removed
        $bodyContinued = $article['body_continued'];

        // we might want to show the article on a map. This helps with that.
        $mapItems = [
            'title' => $article['title'],
            'lat' => $article['lat'],
            'lon' => $article['lon'],
        ];

        // transform the article
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

        // insert a mapItems object into the article at the desired position
        $article = insertInto($article, 'bodyContinued', $mapItems, 'mapItems');

        return $article;
    }

    public function extract($article)
    {
        return [
            'path' => $article['path'],
            'map' => $article['mapItems'],
        ];
    }
}