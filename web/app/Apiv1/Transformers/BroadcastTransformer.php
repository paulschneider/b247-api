<?php namespace Apiv1\Transformers;

use Config;

class BroadcastTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $broadcast, $user )
    {
        return [    
            "id" => $broadcast->id,
            "title" => $broadcast->title,
            "isEnabled" => in_array($broadcast->id, $user->broadcasts)
        ];
    }

    /**
     * Transform a result set into the API required format
     *
     * @param users
     * @return array
     */
    public function transformCollection( $broadcasts, $user )
    {
        $response = [];

        foreach($broadcasts AS $broadcast)
        {
            $response[] = $this->transform($broadcast, $user);
        }

        return $response;
    }
}