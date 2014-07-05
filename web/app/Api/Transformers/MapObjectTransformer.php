<?php namespace Api\Transformers;

class MapObjectTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $object, $options = [] )
    {
        return [
            'id'  => $object['article_id'],
            'title' => $object['title'],
            'lat' => $object['lat'],
            'lon' => $object['lon'],
        ];
    }

    /**
     * Transform a result set into the API required format
     *
     * @param users
     * @return array
     */
    public function transformCollection( $objects, $options = [] )
    {
        $response = [];

        foreach( $objects AS $object )
        {
            $response[] = $this->transform($object);
        }

        return $response;
    }
}
