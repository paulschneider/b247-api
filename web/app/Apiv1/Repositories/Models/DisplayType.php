<?php namespace Apiv1\Repositories\Models;

use Apiv1\Repositories\Models\BaseModel;

Class DisplayType extends BaseModel
{
    protected $fillable = [ 'type', 'updated_at' ];

    protected $table = 'display_type';

    public function article()
    {
        return $this->belongsTo('Apiv1\Repositories\Articles\Article');
    }

    public function channel()
    {
        return $this->belongsTo('Apiv1\Repositories\Channels\Channel');
    }

    public static function getSimpleDisplayTypes()
    {
        return static::lists('type', 'id');
    }
}
