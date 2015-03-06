<?php namespace Apiv1\Transformers;

class CategoryLocationTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param $items
     * @return array
     */
    public function transformCollection($locations, $options = [])
    {
        $response = [];

        foreach($locations AS $location)
        {
            $response[] = [
                'name' => $location['categoryName'],
                'path' => isDesktop() ? makePath( [ $location['channelSefName'], $location['subChannelSefName'], $location['categorySefName'] ] ) : makeCategoryPath($location['categoryId'], $location['displayType'], $location['subChannelId'])
            ];
        }

        return $response;
    }

    /**
     * Transform a single result into the API required format
     *
     * @param $item
     * @return array
     */
    public function transform($item, $options = [])
    {

    }
}
