<?php namespace Apiv1\Transformers;

use Config;

class MediaTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $article, $options = [] )
    {
        $articleAsset = $article['asset'][0];

        $view  = "list";

        if( isMobile() ) {
            $platform = "mobile";
        }

        if( isTablet() ) {
            $platform = "tablet";
        }

        if( isDesktop() ) {
            // if the article is featured we want to show a larger image
            $view = $article['is_featured'] ? "hero" : "list";
            $platform = "web";
        }

        return [
            'filepath' => Config::get('global.cdn_baseurl').$article['id'] . "/{$view}/{$platform}/" . $articleAsset['filepath']
            ,'alt' => $articleAsset['alt']
            ,'title' => $articleAsset['title']
            ,'width' => $articleAsset['width']
            ,'height' => $articleAsset['height']
        ];
    }

    /**
     * Transform a result set into the API required format
     *
     * @param users
     * @return array
     */
    public function transformCollection( $objects, $options = [] )
    {
        $response = [];

        foreach( $objects AS $object )
        {
            $response[] = $this->transform($object);
        }

        return $response;
    }
}
