<?php namespace Apiv1\Repositories\Sponsors;

use Apiv1\Repositories\Sponsors\Sponsor;
use Apiv1\Repositories\Models\BaseModel;
use Config;

Class SponsorRepository extends BaseModel {

    /**
    * get a non-specific list of sponsors for the homepage
    *
    * @return array
    */
    public function getChannelSponsors($limit = 3, array $channelList, $subChannel = false, $allocated = [])
    {
        $query = SponsorLocation::with('sponsor', 'sponsor.asset');

        // if we passed a list of channel then only get sponsors for those channels
        if( count($channelList) > 0)
        {            
            if( ! $subChannel) {
                $query->whereIn('channel_id', $channelList);
            }
            else {
                $query->whereIn('sub_channel_id', $channelList);   
            }    
        }
        
        // if a list of sponsors has been passed then only get sponsors thats aren't in that list
        if( is_array($allocated) && count($allocated) > 0 ) {
            $query->whereNotIn('sponsor_id', $allocated);    
        }      

        $result = $query->take($limit)->orderBy(\DB::raw('RAND()'))->get();       

        return $result->toArray();
    }
    /**
     * get a list of sponsors assigned to a specified sub-channel/category combination
     * @param  int $limit
     * @param  int $channelId
     * @param  int $categoryId
     * @param array $allocated
     * @return mixed
     */
    public function getCategorySponsors($limit, $channelId, $categoryId, $allocated = [])
    {
       $query = SponsorLocation::with('sponsor', 'sponsor.asset')->where('sub_channel_id', $channelId)->where('category_id', $categoryId);

       // if a list of sponsors has been passed then only get sponsors thats aren't in that list
        if( is_array($allocated) && count($allocated) > 0 ) {
            $query->whereNotIn('sponsor_id', $allocated);    
        }

        $result = $query->take($limit)->orderBy(\DB::raw('RAND()'))->get();       

        return $result->toArray();
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
}
