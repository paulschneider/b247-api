<?php namespace Apiv1\Transformers;

Class DistrictPreferenceTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param sponsors
     * @return array
     */
    public function transformCollection( $districts, $user )
    {
        $response = [];

        foreach($districts AS $district)
        {
            $response[] = $this->transform($district, $user);
        }

        return $response;
    }

    /**
     * Transform a single result into the API required format
     *
     * @param sponsor
     * @return array
     */
    public function transform( $district, $user )
    {   
        return [
            "id" => $district['id'],
            "name" => $district['name'],
            'isPromoted' => in_array($district['id'], $user->districts)
        ];
    }
}
