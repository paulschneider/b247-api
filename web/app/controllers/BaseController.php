<?php    

use Version1\Articles\ArticleRepository;
use Version1\Channels\ChannelRepository;
use Version1\Categories\CategoryRepository;

class BaseController Extends Controller {

    /**
    *
    * @var Version1\Articles\ArticleRepository
    */
    protected $articleRepository;

    /**
    *
    * @var Version1\Channels\ChannelRepository
    */
    protected $channelRepository;

    /**
    *
    * @var Version1\Categories\CategoryRepository
    */
    protected $categoryRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
        $this->categoryRepository = $categoryRepository;
        $this->channelRepository = $channelRepository;
    }
}
