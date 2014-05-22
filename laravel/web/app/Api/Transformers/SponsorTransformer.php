<?php namespace Api\Transformers;

class SponsorTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param sponsors
     * @return array
     */
    public function transform($sponsors)
    {
        $response = [];

        foreach($sponsors AS $sponsor)
        {
            $tmp = [
                'id' => $sponsor['id']
                ,'title' => $sponsor['title']
                ,'url' => $sponsor['url']
            ];

            if( isset($sponsor['asset']) && isDesktop() )
            {
                $tmp['media'] = [
                    'filepath' => $sponsor['asset']['filepath']
                    ,'alt' => $sponsor['asset']['alt']
                    ,'title' => $sponsor['asset']['title']
                    ,'width' => $sponsor['asset']['width']
                    ,'height' => $sponsor['asset']['height']
                ];
            }

            $response[] = $tmp;
        }

        return $response;
    }
}
