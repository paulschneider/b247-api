<?php namespace Apiv1\Transformers;

use App;

class SponsorTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param sponsors
     * @return array
     */
    public function transformCollection( $sponsors, $options = [] )
    {
        $response = [];

        foreach($sponsors AS $sponsor)
        {
            $response[] = $this->transform($sponsor);
        }

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
        $tmp = [
            'id' => $sponsor['id']
            ,'title' => $sponsor['title']
            ,'url' => $sponsor['url']
            ,'isAdvert' => true
        ];

        $tmp['media'] = null;

        if( isset($sponsor['asset']) )
        {
            $tmp['media'] = App::make( 'Apiv1\Transformers\SponsorMediaTransformer' )->transform($sponsor);            
        }

        // if( ! isDesktop() )
        // {
        //     unset($tmp['media']['alt']);
        //     unset($tmp['media']['title']);
        //     unset($tmp['media']['width']);
        //     unset($tmp['media']['height']);
        // }

        return $tmp;
    }
}
