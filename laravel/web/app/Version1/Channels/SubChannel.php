<?php namespace Version1\Channels;

use Version1\Channels\Category;
use Version1\Channels\Channel;
use Version1\Articles\Article;
use Version1\Models\BaseModel;

Class SubChannel extends BaseModel
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'channel';

    /**
    * Array of white listed items
    *
    * @var string
    */
    protected $fillable = [ 'icon_img_id', 'name', 'sef_name', 'colour', 'created_at', 'updated_at' ];

    /**
    * Array of items not to be returned
    *
    * @var string
    */
    protected $hidden = [ 'is_active', 'is_deleted', 'created_at', 'updated_at' ];

    /**
     * Relate categories to their parent sub-channels
     *
     * @return ???
     */
    public function category()
    {
        return $this->belongsToMany('Version1\Categories\Category', 'channel_category', 'channel_id');
    }

    /**
     * Relate sub-channel to parent channel
     *
     * @return ???
     */
    public function channel()
    {
        return $this->belongsToMany('Channel', 'parent_id', 'id');
    }

    public function articles()
    {
        return $this->belongsToMany('Article', 'article_location', 'sub_channel_id')->alive()->active();
    }

    public static function getWithArticles($channel)
    {
        $channels = static::with('articles.location')->with('articles.asset')->where('parent_channel', $channel)->get()->toArray();

        foreach($channels AS $key => $channel)
        {
            if( isset($channel['articles']) )
            {
                $articles = [];

                foreach($channel['articles'] AS $article)
                {
                    if( ! $article['is_featured'] and ! $article['is_picked'] )
                    {
                        $articles[] = $article;
                    }
                }

                $channels[$key]['articles'] = $articles;
            }
        }

        return $channels;
    }
}
