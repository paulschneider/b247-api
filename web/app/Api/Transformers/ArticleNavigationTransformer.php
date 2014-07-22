<?php namespace Api\Transformers;

Class ArticleNavigationTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transformCollection( $articles, $options = [] )
    {
        // to do
    }

    /**
     * Transform a single result into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $article, $options = [] )
    {
        if( ! isset($article['location'][0]) )
        {
            return null;
        }

        $articleLocation = $article['location'][0];

        return [
            'article' => [
                'id' => $article['id'],
                'path' => makePath( [  $articleLocation['channelSefName'], $articleLocation['subChannelSefName'], $articleLocation['categorySefName'], $article['sef_name']  ] )
            ],
            'assignment' => [
                    'channel' => [
                        'id' => $articleLocation['channelId'],                        
                        'path' => makePath( [ $articleLocation['channelSefName'] ] )
                    ],
                    'subChannel' => [
                        'id' => $articleLocation['subChannelId'],
                        'path' => makePath( [ $articleLocation['channelSefName'], $articleLocation['subChannelSefName'] ] )
                    ],
                    'category' => [
                        'id' => $articleLocation['categoryId'],
                        'path' => makePath( [ $articleLocation['channelSefName'], $articleLocation['subChannelSefName'], $articleLocation['categorySefName'] ] )
                    ]                    
                ] 
        ];
    }
}