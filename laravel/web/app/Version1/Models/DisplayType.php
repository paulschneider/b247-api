<?php namespace Version1\Models;

use Version1\Models\BaseModel;

Class DisplayType extends BaseModel
{
    protected $fillable = [ 'type', 'updated_at' ];

    protected $table = 'display_type';

    public function article()
    {
        return $this->belongsTo('Version1\Articles\Article');
    }

    public function channel()
    {
        return $this->belongsTo('Version1\Channels\Channel');
    }

    public static function getSimpleDisplayTypes()
    {
        return static::lists('type', 'id');
    }
}
