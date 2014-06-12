<?php namespace Api\Transformers;

class ArticleTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transformCollection($articles)
    {
        $response = [];

        foreach($articles AS $article)
        {
            $tmp = $this->transform($article);

            $response[] = $tmp;
        }
        return $response;
    }

    /**
     * Transform a single result into the API required format
     *
     * @param user
     * @return array
     */
    public function transform($article)
    {
        if( isset($article['location'][0]) and isset($article['asset'][0]) )
        {
            $articleLocation = $article['location'][0];
            $articleAsset = $article['asset'][0];

            $response = [
                'id' => $article['id']
                ,'title' => $article['title']
                ,'sefName' => $article['sef_name']
                ,'subHeading' => $article['sub_heading']
                ,'body' => $article['body']
                ,'path' => $articleLocation['channelSefName'] . '/' . $articleLocation['subChannelSefName'] . '/' . $articleLocation['categorySefName'] . '/' . $article['sef_name']
                ,'isPromo' => $article['is_promo'] ? true : false
                ,'assignment' => [
                    'channel' => [
                        'id' => $articleLocation['channelId']
                        ,'name' => $articleLocation['channelName']
                        ,'sefName' => $articleLocation['channelSefName']
                    ]
                    ,'subChannel' => [
                        'id' => $articleLocation['subChannelId']
                        ,'name' => $articleLocation['subChannelName']
                        ,'sefName' => $articleLocation['subChannelSefName']
                    ]
                    ,'category' => [
                        'id' => $articleLocation['categoryId']
                        ,'name' => $articleLocation['categoryName']
                        ,'sefName' => $articleLocation['categorySefName']
                    ]
                ]
                ,'media' => [
                    'filepath' => $articleAsset['filepath']
                    ,'alt' => $articleAsset['alt']
                    ,'title' => $articleAsset['title']
                    ,'width' => $articleAsset['width']
                    ,'height' => $articleAsset['height']
                ]
            ];

            if( isset($article['event']) )
            {
                $venue = $article['event']['venue'];
                $event = $article['event']['details'];

                $response['event'] = [
                    'venue' => [
                        'name' => $venue['name']
                        ,'sefName' => $venue['sef_name']
                        ,'facebook' => $venue['facebook']
                        ,'twitter' => $venue['twitter']
                    ]
                    ,'detail' => [
                        'title' => $event['title']
                        ,'sefName' => $event['sef_name']
                        ,'date' => $event['show_date']
                        ,'time' => $event['show_time']
                        ,'price' => $event['price']
                        ,'url' => $event['url']
                    ]
                ];
            }

            return $response;
        }
    }
}
