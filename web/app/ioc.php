<?php

App::singleton('Api', function($app)
{
    return new ApiController();
});

App::bind('AppNavResponseMaker', function($app)
{
    return new Api\Factory\AppNavResponseMaker;
});

App::bind('CategoryResponseMaker', function($app)
{
    return new Api\Factory\CategoryResponseMaker;
});

App::bind('ChannelResponseMaker', function($app)
{
    return new Api\Factory\ChannelResponseMaker;
});

App::bind('HomeResponseMaker', function($app)
{
    return new Api\Factory\HomeResponseMaker;
});

App::bind('SubChannelResponseMaker', function($app)
{
    return new Api\Factory\SubChannelResponseMaker;
});

App::bind('PatternMaker', function($app)
{
    return new Api\Factory\PatternMaker;
});

App::bind('SponsorRepository', function($app)
{
    return new Version1\Sponsors\SponsorRepository;
});

App::bind('SponsorTransformer', function($app)
{
    return new Api\Transformers\SponsorTransformer;
});

App::bind('MapTransformer', function($app)
{
    return new Api\Transformers\MapObjectTransformer;
});

App::bind('ArticleTransformer', function($app)
{
    return new Api\Transformers\ArticleTransformer;
});

App::bind('ChannelTransformer', function($app)
{
    return new Api\Transformers\ChannelTransformer;
});

App::bind('SubChannelTransformer', function($app)
{
    return new Api\Transformers\SubChannelTransformer;
});

App::bind('SponsorResponder', function($app)
{
    return new Api\Responders\SponsorResponder;
});

App::bind('CategoryResponder', function($app)
{
    return new Api\Responders\CategoryResponder;
});

App::bind('ArticleRepository', function($app)
{
    return new Version1\Articles\ArticleRepository;
});

App::bind('ChannelRepository', function($app)
{
    return new Version1\Channels\ChannelRepository;
});

App::bind('ChannelResponder', function($app)
{
    return new Api\Responders\ChannelResponder;
});

App::bind('ChannelArticleResponder', function($app)
{
    return new Api\Responders\ChannelArticleResponder;
});

App::bind('ChannelDirectoryResponder', function($app)
{
    return new Api\Responders\ChannelDirectoryResponder;
});

App::bind('ChannelListingResponder', function($app)
{
    return new Api\Responders\ChannelListingResponder;
});

App::bind('PageMaker', function($app)
{
    return new Api\Factory\PageMaker;
});

App::bind('PatternMaker', function($app)
{
    return new Api\Factory\PatternMaker;
});

App::bind('ListingTransformer', function($app)
{
    return new Api\Transformers\ListingTransformer;
});

App::bind('HomeFeaturedResponder', function($app)
{
    return new Api\Responders\HomeFeaturedResponder;
});

App::bind('PickedResponder', function($app)
{
    return new Api\Responders\PickedResponder;
});

App::bind('FeaturedResponder', function($app)
{
    return new Api\Responders\FeaturedResponder;
});

App::bind('ChannelFeed', function($app)
{
    return new Api\Factory\ChannelFeed;
});

App::bind('HomePickedResponder', function($app)
{
    return new Api\Responders\HomePickedResponder;
});

App::bind('WhatsOnResponder', function($app)
{
    return new Api\Responders\WhatsOnResponder;
});

App::bind('MessageBag', function($app)
{
    return new Illuminate\Support\MessageBag;
});

App::bind('InvalidResponseException', function($app)
{
    return new Api\Exceptions\InvalidResponseException;
});

App::bind('CategoryTransformer', function($app)
{
    return new Api\Transformers\CategoryTransformer;
});

App::bind('EventTransformer', function($app)
{
    return new Api\Transformers\EventTransformer;
});

App::bind('CategoryDirectoryResponder', function($app)
{
    return new Api\Responders\CategoryDirectoryResponder;
});

App::bind('CategoryArticleResponder', function($app)
{
    return new Api\Responders\CategoryArticleResponder;
});

App::bind('CategoryListingResponder', function($app)
{
    return new Api\Responders\CategoryListingResponder;
});

App::bind('CategoryRepository', function($app)
{
    return new Version1\Categories\CategoryRepository;
});

App::bind('ArticleResponseMaker', function($app)
{
    return new Api\Factory\ArticleResponseMaker;
});

App::bind('ApiResponder', function($app)
{
    return new ApiController;
});

App::bind('VenueTransformer', function($app)
{
    return new Api\Transformers\VenueTransformer;
});

App::bind('SearchResponseMaker', function($app)
{
    return new Api\Factory\SearchResponseMaker;
});