<?php namespace Version1\Sponsors;

use \Version1\Sponsors\SponsorInterface;
use \Version1\Sponsors\SponsorPlacement;
use \Version1\Sponsors\Sponsor;
use \Version1\Channels\Channel;
use \Version1\Models\BaseModel;

Class SponsorRepository extends BaseModel implements SponsorInterface {

    /**
    * get a non-specific list of sponsors for the homepage
    *
    * @return array
    */
    public function getSponsors($list = [], $limit = 3)
    {
        $query = Sponsor::with('asset')->alive()->take($limit);

        //check to see if there are any ID's we don't want to return
        if( count($list) > 0 )
        {
            $query->whereNotIn('id', $list);
        }

        return $query->orderBy(\DB::raw('RAND()'))->get();
    }

    public function getRandomSponsors($limit = 999)
    {
        return Sponsor::with('asset')->alive()->take($limit)->orderBy(\DB::raw('RAND()'))->get();
    }

    /**
    * get a list of sponsors that aren't in a provided collection
    *
    * @return array
    */
    public function getWhereNotInCollection($listOfAllocatedSponsorIds, $limit = 3)
    {
        return static::getSponsors($listOfAllocatedSponsorIds, $limit);
    }

    /**
    * get a specified sponsors by their ID
    *
    * @return array
    */
    public function getSponsorById($id)
    {
        return Sponsor::findOrFail($id);
    }

    /**
    * get a full list of sponsor records
    *
    * @return array
    */
    public function getAscendingList()
    {
        return Sponsor::createdDescending()->get();
    }

    /**
    * get a key value list of sponsors
    *
    * @return array
    */
    public function getSimpleSponsors()
    {
        return Sponsor::active()->alive()->createdDescending()->lists('title', 'id');
    }

    /**
    * create or update a sponsor record
    *
    * @return Sponsor
    */
    public function storeSponsor($form)
    {
        if( !empty($form['id']) )
        {
            $sponsor = Sponsor::find($form['id']);
        }
        else
        {
            $sponsor = new Sponsor();
        }

        $sponsor->title = $form['title'];
        $sponsor->url = $form['url'];
        $sponsor->is_active = isset($form['is_active']) ? $form['is_active'] : false;

        $sponsor->save();

        return $sponsor;
    }

    public function assignChannelSponsors($channel, $sponsors)
    {
        // 1 - content_type::type = channel

        return SponsorPlacement::place(1, $channel->id, $sponsors);
    }

}
