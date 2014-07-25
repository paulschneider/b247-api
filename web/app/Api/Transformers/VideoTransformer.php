<?php namespace Api\Transformers;

Class VideoTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transformCollection( $articles, $options = [] )
    {
        // to do
    }

    /**
     * Transform a single result into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $video, $options = [] )
    {
        return [
            'source' => $video['content_link'],
            'embed' =>  $video['content_embed']
        ];
    }
}