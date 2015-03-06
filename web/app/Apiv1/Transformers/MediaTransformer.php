<?php namespace Apiv1\Transformers;

use Config;

class MediaTransformer extends Transformer {

    /**
     * what type of device has called the API  ( web | mobile | tablet )
     * @var string
     */
    private $platform = "web";

    /**
     * what view (i.e size) of the image do we want to provide. This is based on the directory
     * structure on the CDN / image server
     * @var string
     */
    private $view;

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $article, $options = [] )
    {
        $articleAsset = $article['asset'][0];

        // call the define method of this class to determine what kind of imagery to return
        $this->define($article);

        return [
            'filepath' => Config::get('global.cdn_baseurl').$article['id'] . "/{$this->view}/{$this->platform}/" . $articleAsset['filepath']
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
    public function transformCollection( $article, $options = [] )
    {
        $response = [];

        // call the define method of this class to determine what kind of imagery to return
        $this->define($article);

        foreach( $article['gallery'] AS $image )
        {
            // determine the directory path on the server based on the image_type field of the asset
            $path = $image['image_type'] == 2 ? "gallery/top" : "gallery/bottom";

            // just so we can filter them in the response array
            $type = $image['image_type'] == 2 ? "top" : "bottom";

            $response[$type][] = [            
                'filepath' => Config::get('global.cdn_baseurl').$article['id'] . "/{$path}/{$this->platform}/" . $image['filepath']
                ,'alt' => $image['alt']
                ,'title' => $image['title']
                ,'width' => $image['width']
                ,'height' => $image['height']
            ];           
        }

        return $response;
    }

    private function define($article)
    {
        $this->view  = "list";

        if( isMobile() ) {
            $this->platform = "mobile";
        }

        if( isTablet() ) {
            $this->platform = "tablet";
        }

        if( isDesktop() ) {
            // if the article is featured we want to show a larger image
            $this->view = $article['is_featured'] ? "hero" : "list";
            $this->platform = "web";
        }

        // we don't need to return anything
    }
}
