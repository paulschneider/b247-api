<?php namespace Apiv1\Transformers;

use Config;

class SponsorMediaTransformer extends Transformer {	

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $sponsor, $options = [] )
    {
        $asset = $sponsor['asset'];

        return [
            'filepath' => Config::get('global.cdn_baseurl') . 'ad-'. $sponsor['id'] . "/" . $sponsor['type'] . "/" . $sponsor['platform'] . "/" . $asset['filepath'],
            'alt' => $asset['alt'],
            'title' => $asset['title'],
            'width' => $asset['width'],
            'height' => $asset['height'],
        ];
    }

    /**
     * Transform a result set into the API required format
     *
     * @param users
     * @return array
     */
    public function transformCollection( $sponsors, $options = [] )
    {
        $response = [];

        foreach( $sponsors AS $sponsor )
        {
            $response[] = $this->transform($sponsor);          
        }

        return $response;
    }
}