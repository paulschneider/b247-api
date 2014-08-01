<?php namespace Apiv1\Transformers;

Class VenueTransformer {

    /**
     * Transform a result set into the API required format
     *
     * @param $items
     * @return array
     */
    public function transformCollection($venues, $options = [])
    {
        $response = [];

        foreach( $venues AS $venue )
        {
            $response = $this->tranform($venue, $options);
        }
    }

    /**
     * Transform a single result into the API required format
     *
     * @param $item
     * @return array
     */
    public function transform($venue, $options = [])
    {
        return [
            'id' => $venue['id'],
            'name' => $venue['name'],
            'sefName' => $venue['sef_name'],
            'address1' => $venue['address_line_1'],
            'address2' => $venue['address_line_2'],
            'address3' => $venue['address_line_3'],
            'postcode' => $venue['postcode'],
            'email' => $venue['email'],
            'facebook' => $venue['facebook'],
            'twitter' => $venue['twitter'],
            'phone' => $venue['phone'],
        ];
    }
}
