<?php namespace Apiv1\Repositories\Channels;

use Apiv1\Repositories\Models\BaseModel;

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
    protected $hidden = [ 'created_at', 'updated_at' ];

    /**
     * Relate categories to their parent sub-channels
     *
     * @return ???
     */
    public function category()
    {
        return $this->belongsToMany('Apiv1\Repositories\Categories\Category', 'channel_category', 'channel_id')->alive()->active();
    }

    /**
     * Relate sub-channel to parent channel
     *
     * @return ???
     */
    public function channel()
    {
        return $this->belongsToMany('Apiv1\Repositories\Channels\Channel', 'parent_id', 'id');
    }

    public function articles()
    {
        return $this->belongsToMany('Apiv1\Repositories\Articles\Article', 'article_location', 'sub_channel_id')->alive()->active();
    }
        
    /**
    * create the relationship with display_type
    *
    * @var array
    */
    public function display()
    {
        return $this->belongsTo('Apiv1\Repositories\Models\DisplayType', 'display_type');
    }
}