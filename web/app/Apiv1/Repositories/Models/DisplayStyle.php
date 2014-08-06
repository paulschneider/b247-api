<?php namespace Apiv1\Repositories\Models;

use Apiv1\Repositories\Models\BaseModel;

class DisplayStyle extends BaseModel
{
    protected $table = "display_style";

    protected $fillable = ["type"];

    public static function getSimpleDisplayStyles()
    {
        return static::lists('style', 'id');
    }
}
