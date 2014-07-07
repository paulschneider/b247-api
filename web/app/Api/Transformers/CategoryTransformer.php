<?php namespace Api\Transformers;

class CategoryTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $category, $options = [] )
    {
        return [
            'id' => $category['id']
            ,'name' => $category['name']
            ,'sefName' => $category['sef_name']
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
