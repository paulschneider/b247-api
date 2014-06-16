<?php namespace Version1\Sponsors;

Interface SponsorInterface {

    public function getSponsors($list, $limit);

    public function getSponsorById($id);

    public function getAscendingList();

    public function getSimpleSponsors();

    public function storeSponsor($form);

    public function assignChannelSponsors($channel, $sponsors);

}
