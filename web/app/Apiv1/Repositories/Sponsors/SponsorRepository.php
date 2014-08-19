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
    public function getChannelSponsors($limit = 3, array $channelList, $subChannel = false, $allocated = [], $type)
    {
        $query = Sponsor::select('sponsor.*')
            ->join('sponsor_location', 'sponsor_location.sponsor_id', '=', 'sponsor.id')
            ->with('location', 'asset');            

        // if we passed a list of channel then only get sponsors for those channels
        if( count($channelList) > 0)
        {            
            if( ! $subChannel) {
                $query->whereIn('sponsor_location.channel_id', $channelList);
            }
            else {
                $query->whereIn('sponsor_location.sub_channel_id', $channelList);   
            }    
        }

        $query->where('sponsor.sponsor_type', $type);
        
        // if a list of sponsors has been passed then only get sponsors thats aren't in that list
        if( is_array($allocated) && count($allocated) > 0 ) {
            $query->whereNotIn('sponsor.id', $allocated);    
        }      

        $result = $query->take($limit)->orderBy(\DB::raw('RAND()'))->active()->get();       

        return $result->toArray();
    }
    /**
     * get a list of sponsors assigned to a specified sub-channel/category combination
     * @param  int $limit
     * @param  int $channelId
     * @param  int $categoryId
     * @param array $allocated
     * @param int $type // from the sponsor_type DB table
     * @return mixed
     */
    public function getCategorySponsors($limit, $channelId, $categoryId, $allocated = [], $type)
    {
        $query = Sponsor::select('sponsor.*')
            ->join('sponsor_location', 'sponsor_location.sponsor_id', '=', 'sponsor.id')
            ->with('location', 'asset')
            ->where('sub_channel_id', $channelId)
            ->where('category_id', $categoryId)
            ->where('sponsor.sponsor_type', $type); 
            
       // if a list of sponsors has been passed then only get sponsors thats aren't in that list
        if( is_array($allocated) && count($allocated) > 0 ) {
            $query->whereNotIn('sponsor_id', $allocated);    
        }

        $result = $query->take($limit)->orderBy(\DB::raw('RAND()'))->active()->get();       

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
