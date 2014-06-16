<?php namespace Version1\Models;

use Version1\Models\BaseModel;

class DisplayStyle extends BaseModel
{
    protected $table = "display_style";

    protected $fillable = ["type"];

    public static function getSimpleDisplayStyles()
    {
        return static::lists('style', 'id');
    }
}
