<?php namespace Api\Transformers;

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
            ,'displayStyle' => $sponsor['display_style']
        ];

        if( isset($sponsor['asset']) )
        {
            $tmp['media'] = [
                'filepath' => $sponsor['asset']['filepath']
                ,'alt' => $sponsor['asset']['alt']
                ,'title' => $sponsor['asset']['title']
                ,'width' => $sponsor['asset']['width']
                ,'height' => $sponsor['asset']['height']
            ];
        }

        if( ! isDesktop() )
        {
            unset($tmp['media']['alt']);
            unset($tmp['media']['title']);
            unset($tmp['media']['width']);
            unset($tmp['media']['height']);
        }

        return $tmp;
    }
}
