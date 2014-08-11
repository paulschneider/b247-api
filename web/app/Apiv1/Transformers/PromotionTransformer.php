<?php namespace Apiv1\Transformers;

use Config;
use Carbon\Carbon;

class PromotionTransformer extends Transformer {

    /**
     * Flag to indicate whether the promotion is still valid
     * 
     * @var boolean
     */
    private $is_valid;

    /**
     * code to be returned as part of the response
     * @var [type]
     */
    private $code;

    /**
     * the status of the promotion
     * @var string
     */
    private $status;

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $promotion, $options = [] )
    {
        $from = explode(' ', $promotion['valid_from']);
        $to = explode(' ', $promotion['valid_to']);

        return [
            'code' => $this->getPromotionCode($promotion),
            'isValid' => $this->is_valid,
            'details' => $promotion['details'],
            'terms' => $promotion['terms'],
            'meta' => [
                'status' => $this->status,
                'validFrom' => [
                    'epoch' => (int) strtotime($promotion['valid_from']),
                    'readable' => $promotion['valid_from'],
                    'day' => date('Y-m-d', strtotime($from[0])),
                    'time' => date('H:i', strtotime($from[1]))
                ],
                'validTo' => [
                    'epoch' => (int) strtotime($promotion['valid_to']),
                    'readable' => $promotion['valid_to'],
                    'day' => date('Y-m-d', strtotime($to[0])),
                    'time' => date('H:i', strtotime($to[1]))
                ]
            ]
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

        foreach( $article['promotion'] AS $promotion )
        {
            $response[] = $this->transform($promotion);
        }

        return $response;
    }

    /**
     * Determine and return the status of a promotion
     * 
     * @param  array $promotion [a promotion row from the database, unformatted]
     * @return mixed
     */
    public function getPromotionCode($promotion)
    {
        $validFrom = strtotime($promotion['valid_from']);
        $validTo = strtotime($promotion['valid_to']);

        $today = time();

        # if the promotion is still within the valid from/to range
        if($validFrom < $today && $validTo > $today)
        {
            $this->is_valid = true;
            $this->status = "Active promotion";
            return $promotion['code'];
        }

        // if the promotion hasn't yet begun
        if($validFrom > $today)
        {
            $this->is_valid = false;
            $this->status = "Promotion not valid until " . $promotion['valid_from'];
           return null; 
        }

        # if the promotion has expired
        if($validTo < $today)
        {
            $this->is_valid = false;
            $this->status = "Promotion expired on " . $promotion['valid_to'];
            return null;    
        }
    }
}
