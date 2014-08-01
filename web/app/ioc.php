<?php

App::singleton('Api', function($app)
{
    return new ApiController();
});

App::bind('AppNavResponseMaker', function($app)
{
    return new Apiv1\Factory\AppNavResponseMaker;
});

App::bind('CategoryResponseMaker', function($app)
{
    return new Apiv1\Factory\CategoryResponseMaker;
});

App::bind('ChannelResponseMaker', function($app)
{
    return new Apiv1\Factory\ChannelResponseMaker;
});

App::bind('HomeResponseMaker', function($app)
{
    return new Apiv1\Factory\HomeResponseMaker;
});

App::bind('SubChannelResponseMaker', function($app)
{
    return new Apiv1\Factory\SubChannelResponseMaker;
});

App::bind('PatternMaker', function($app)
{
    return new Apiv1\Factory\PatternMaker;
});

App::bind('SponsorRepository', function($app)
{
    return new Apiv1\Repositories\Sponsors\SponsorRepository;
});

App::bind('SponsorTransformer', function($app)
{
    return new Apiv1\Transformers\SponsorTransformer;
});

App::bind('MapTransformer', function($app)
{
    return new Apiv1\Transformers\MapObjectTransformer;
});

App::bind('ArticleTransformer', function($app)
{
    return new Apiv1\Transformers\ArticleTransformer;
});

App::bind('ChannelTransformer', function($app)
{
    return new Apiv1\Transformers\ChannelTransformer;
});

App::bind('SubChannelTransformer', function($app)
{
    return new Apiv1\Transformers\SubChannelTransformer;
});

App::bind('SponsorResponder', function($app)
{
    return new Apiv1\Responders\SponsorResponder;
});

App::bind('CategoryResponder', function($app)
{
    return new Apiv1\Responders\CategoryResponder;
});

App::bind('ArticleRepository', function($app)
{
    return new Apiv1\Repositories\Articles\ArticleRepository;
});

App::bind('ChannelRepository', function($app)
{
    return new Apiv1\Repositories\Channels\ChannelRepository;
});

App::bind('ChannelResponder', function($app)
{
    return new Apiv1\Responders\ChannelResponder;
});

App::bind('ChannelArticleResponder', function($app)
{
    return new Apiv1\Responders\ChannelArticleResponder;
});

App::bind('ChannelDirectoryResponder', function($app)
{
    return new Apiv1\Responders\ChannelDirectoryResponder;
});

App::bind('ChannelListingResponder', function($app)
{
    return new Apiv1\Responders\ChannelListingResponder;
});

App::bind('PageMaker', function($app)
{
    return new Apiv1\Factory\PageMaker;
});

App::bind('PatternMaker', function($app)
{
    return new Apiv1\Factory\PatternMaker;
});

App::bind('ListingTransformer', function($app)
{
    return new Apiv1\Transformers\ListingTransformer;
});

App::bind('HomeFeaturedResponder', function($app)
{
    return new Apiv1\Responders\HomeFeaturedResponder;
});

App::bind('PickedResponder', function($app)
{
    return new Apiv1\Responders\PickedResponder;
});

App::bind('FeaturedResponder', function($app)
{
    return new Apiv1\Responders\FeaturedResponder;
});

App::bind('ChannelFeed', function($app)
{
    return new Apiv1\Factory\ChannelFeed;
});

App::bind('HomePickedResponder', function($app)
{
    return new Apiv1\Responders\HomePickedResponder;
});

App::bind('WhatsOnResponder', function($app)
{
    return new Apiv1\Responders\WhatsOnResponder;
});

App::bind('MessageBag', function($app)
{
    return new Illuminate\Support\MessageBag;
});

App::bind('InvalidResponseException', function($app)
{
    return new Apiv1\Exceptions\InvalidResponseException;
});

App::bind('CategoryTransformer', function($app)
{
    return new Apiv1\Transformers\CategoryTransformer;
});

App::bind('EventTransformer', function($app)
{
    return new Apiv1\Transformers\EventTransformer;
});

App::bind('CategoryDirectoryResponder', function($app)
{
    return new Apiv1\Responders\CategoryDirectoryResponder;
});

App::bind('CategoryArticleResponder', function($app)
{
    return new Apiv1\Responders\CategoryArticleResponder;
});

App::bind('CategoryListingResponder', function($app)
{
    return new Apiv1\Responders\CategoryListingResponder;
});

App::bind('CategoryRepository', function($app)
{
    return new Apiv1\Repositories\Categories\CategoryRepository;
});

App::bind('ArticleResponseMaker', function($app)
{
    return new Apiv1\Factory\ArticleResponseMaker;
});

App::bind('ApiResponder', function($app)
{
    return new ApiController;
});

App::bind('VenueTransformer', function($app)
{
    return new Apiv1\Transformers\VenueTransformer;
});

App::bind('SearchResponseMaker', function($app)
{
    return new Apiv1\Factory\SearchResponseMaker;
});

App::bind('UserRepository', function($app)
{
    return new Apiv1\Repositories\Users\UserRepository;
});

App::bind('UserTransformer', function($app)
{
    return new Apiv1\Transformers\UserTransformer;
});

App::bind('SessionsResponseMaker', function($app)
{
    return new Apiv1\Factory\SessionsResponseMaker;
});

App::bind('SessionsValidator', function($app)
{
    return new Apiv1\Validators\SessionsValidator;
});

App::bind('PasswordValidator', function($app)
{
    return new Apiv1\Validators\PasswordValidator;
});

App::bind('EmailValidator', function($app)
{
    return new Apiv1\Validators\EmailValidator;
});

App::bind('UserResponder', function($app)
{
    return new Apiv1\Responders\UserResponder;
});

App::bind('PasswordChangeResponseMaker', function($app)
{
    return new Apiv1\Factory\PasswordChangeResponseMaker;
});

App::bind('ForgottenPasswordResponseMaker', function($app)
{
    return new Apiv1\Factory\ForgottenPasswordResponseMaker;
});

App::bind('UserProfileResponseMaker', function($app)
{
    return new Apiv1\Factory\UserProfileResponseMaker;
});

App::bind('UserProfileValidator', function($app)
{
    return new Apiv1\Validators\UserProfileValidator;
});

App::bind('UserProfileMaker', function($app)
{
    return new Apiv1\Factory\UserProfileMaker;
});

App::bind('GoogleMapsMaker', function($app)
{
    return new Apiv1\Factory\GoogleMapsMaker;
});

App::bind('UserPreferencesResponseMaker', function($app)
{
    return new Apiv1\Factory\UserPreferencesResponseMaker;
});

App::bind('UserPreferenceOrganiser', function($app)
{
    return new Apiv1\Tools\UserPreferenceOrganiser;
});

App::bind('ArticleNavigationTransformer', function($app)
{
    return new Apiv1\Transformers\ArticleNavigationTransformer;
});

App::bind('VideoTransformer', function($app)
{
    return new Apiv1\Transformers\VideoTransformer;
});

App::bind('ArticleTemplateTransformer', function($app)
{
    return new Apiv1\Transformers\ArticleTemplateTransformer;
});

App::bind('ApiClient', function($app)
{
    return new Apiv1\Client\Caller;
});

App::bind('MailClient', function($app)
{
    return new Apiv1\Mail\Client;
});