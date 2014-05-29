<?php namespace Version1\Models;

class SponsorPlacement extends BaseModel {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sponsor_placement';

    /**
    * The attributes of a user that can be manually set
    *
    * @var array
    */
    protected $fillable = [

        'sponsor_id', 'content_type', 'content_id'

    ];

    public function sponsor()
    {
        return $this->belongsToMany('\Version1\Models\Sponsor', 'sponsor_id', 'id');
    }

    public static function place($contentType, $contentId, $sponsors)
    {
        // firstly remove any current sponsorship associations with the channel - do this regardless

        \DB::table('sponsor_placement')->where('content_type', $contentType)->where('content_id', $contentId)->delete();

        // add the sponsors
        if( is_array($sponsors) )
        {
            $rows = [];

            foreach($sponsors AS $key => $sponsor)
            {
                if( $sponsor > 0 )
                {
                    $rows[] = [
                        'sponsor_id' => $sponsor
                        ,'content_type' => 1
                        ,'content_id' => $contentId
                    ];
                }
            }

            // insert the rows

            if( count($rows) > 0 )
            {
                \DB::table('sponsor_placement')->insert($rows);
            }
        }
        else
        {
            return false;
        }
    }
}
