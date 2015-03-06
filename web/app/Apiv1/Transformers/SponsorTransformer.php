<?php namespace Apiv1\Transformers;

use App;
use Config;

class SponsorTransformer extends Transformer {

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
        # call the define method of this class to determine what kind of sponsor we're processing
        $this->define($sponsor);

        $sponsor['type'] = $this->view;
        $sponsor['platform'] = $this->platform;

        $tmp = [
            'id' => $sponsor['id'],
            'title' => $sponsor['title'],
            'url' => $sponsor['url'],
            'isAdvert' => true,
            'type' => $sponsor['type'],
            'platform' => $sponsor['platform']
        ];

        $tmp['media'] = null;

        if( isset($sponsor['asset']) )
        {
            $tmp['media'] = App::make( 'Apiv1\Transformers\SponsorMediaTransformer' )->transform($sponsor);            
        }

        return $tmp;
    }

    private function define($sponsor)
    {
        if($sponsor['sponsor_type'] == Config::get('global.sponsorLETTERBOX')) {
            $this->view = "letterbox";
        }

        if($sponsor['sponsor_type'] == Config::get('global.sponsorMPU')) {
            $this->view = "mpu";
        }

        if($sponsor['sponsor_type'] == Config::get('global.sponsorFULLPAGE')) {
            $this->view = "fullpage";
        }
        
        if( isMobile() ) {
            $this->platform = "mobile";
        }

        if( isTablet() ) {
            $this->platform = "tablet";
        }

        if( isDesktop() ) {            
            $this->platform = "web";
        }

        // we don't need to return anything
    }
}
