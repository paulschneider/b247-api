<?php

use Version1\Models\DisplayType;
use Version1\Channels\Channel;

Class ChannelController extends ApiController {

    var $responseMaker;

    /**
    * display a html list of channels
    *
    * @return View
    */
    public function index()
    {
        $channels = $this->channelRepository->getChannelList();

        return View::make('channel.show', compact('channels'));
    }

    /**
    * display a form to create a new channel
    *
    * @return View
    */
    public function create()
    {
        $channels = $this->channelRepository->getSimpleChannels();
        $sponsors = $this->sponsorRepository->getSimpleSponsors();
        $types = DisplayType::getSimpleDisplayTypes();
        $channel = new Channel();

        return View::make('channel.create', compact('channel', 'channels', 'sponsors', 'types'));
    }

    /**
    * display a form to edit an existing channel
    *
    * @return View
    */
    public function edit($channelId = null)
    {
        if( is_numeric($channelId) )
        {
            $channel = $this->channelRepository->getChannel($channelId);
        }
        else
        {
            return $this->respondNotValid('Invalid channel identifier supplied.');
        }

        $channels = $this->channelRepository->getSimpleChannels($channel->id);
        $categories = $this->categoryRepository->getAll();
        $sponsors = $this->sponsorRepository->getSimpleSponsors();
        $channelCategory = array_flatten($channel->category->toArray());
        $channelSponsors = $channel->sponsors->lists('id');
        $types = DisplayType::getSimpleDisplayTypes();

        return View::make('channel.create', compact('channel', 'channels', 'sponsors', 'channelCategory', 'channelSponsors', 'categories', 'types'));
    }

    /**
    * get the details of a channel
    *
    * @return Response
    */
    public function getChannel($identifier)
    {
        if( is_null($identifier) )
        {
            return $this->respondWithInsufficientParameters();
        }

        $this->responseMaker = App::make('ChannelResponseMaker');

        if( ! $channel = $this->responseMaker->getChannel( $identifier ))
        {
            return $this->respondNoDataFound( Lang::get('api.channelNotFound') );
        } 

        $this->response = $this->responseMaker->make( $channel );

        return $this->respondFound( Lang::get('api.channelFound'), $this->response );
    }

    /**
    * get the details of a sub-channel
    *
    * @return *
    */
    public function getSubChannel( $identifier, $type )
    {   
        if( is_null($identifier) )
        {
            return $this->respondWithInsufficientParameters();
        }

        $this->responseMaker = App::make('SubChannelResponseMaker');
 
        if( ! $channel = $this->responseMaker->getChannel( $identifier ))
        {
            return $this->respondNoDataFound( Lang::get('api.channelNotFound') );
        }        
       
        $this->response = $this->responseMaker->make( $channel );

        return $this->respondFound( Lang::get('api.subChannelFound'), $this->response );
    }

    /**
    * store the details of a new channel
    *
    * @return Redirect
    */
    public function store()
    {
        if( ! $channel = $this->channelRepository->storeChannel(Input::all()) )
        {
            return $this->respondNotValid($channel->errors);
        }
        else
        {
            // associate any sponsors with the channel
            $this->sponsorRepository->assignChannelSponsors($channel, Input::get('sponsor'));
            return Redirect::to('channel');
        }
    }

    /**
    * action on an UPDATE call to the resource
    *
    * @return ApiController Response
    */
    public function update()
    {
        return ApiController::respondNotAllowed();
    }

    /**
    * action on an UPDATE call to the resource
    *
    * @return ApiController Response
    */
    public function destroy()
    {
        return ApiController::respondNotAllowed();
    }
}
