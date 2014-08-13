<?php namespace Apiv1\Transformers;

use Config;

class SponsorMediaTransformer extends Transformer {

	/**
     * what type of device has called the API  ( web | mobile | tablet )
     * @var string
     */
    private $platform;

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
    public function transform( $sponsor, $options = [] )
    {
        $asset = $sponsor['asset'];

        // call the define method of this class to determine what kind of imagery to return
        $this->define($sponsor);

        return [
            'filepath' => Config::get('global.cdn_baseurl').'ad-'.$sponsor['id'] . "/{$this->view}/{$this->platform}/" . $asset['filepath']
            ,'alt' => $asset['alt']
            ,'title' => $asset['title']
            ,'width' => $asset['width']
            ,'height' => $asset['height']
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

    private function define($sponsor)
    {
        if($sponsor['sponsor_type'] == Config::get('global.sponsorLETTERBOX')) {
            $this->view = "letterbox";
        }

        if($sponsor['sponsor_type'] == Config::get('global.sponsorMPU')) {
            $this->view = "mpu";
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