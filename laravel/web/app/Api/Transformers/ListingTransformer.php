<?php namespace Api\Transformers;

class ListingTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param sponsors
     * @return array
     */
    public function transformCollection( $listing, $options = [] )
    {
        $response = [];

        return $response;
    }

    /**
     * Transform a single result into the API required format
     *
     * @param sponsor
     * @return array
     */
    public function transform( $sponsor, $options = [] )
    {
        // do some thing eventually
    }
}
