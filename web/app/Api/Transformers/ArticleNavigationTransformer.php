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
                'path' => isDesktop() ? makePath( [  $articleLocation['channelSefName'], $articleLocation['subChannelSefName'], $articleLocation['categorySefName'], $article['sef_name']  ] ) : makeArticleLink($articleLocation['subChannelId'], $articleLocation['categoryId'], $article['id'])
            ],
            'assignment' => [
                    'channel' => [
                        'id' => $articleLocation['channelId'],                        
                        'path' => isDesktop() ? makePath( [ $articleLocation['channelSefName'] ] ) : makeChannelLink($articleLocation['channelId'])
                    ],
                    'subChannel' => [
                        'id' => $articleLocation['subChannelId'],
                        'path' => isDesktop() ? makePath( [ $articleLocation['channelSefName'], $articleLocation['subChannelSefName'] ] ) : makeSubChannelPath($articleLocation['subChannelId'], $articleLocation['displayType'])
                    ],
                    'category' => [
                        'id' => $articleLocation['categoryId'],
                        'path' => isDesktop() ? makePath( [ $articleLocation['channelSefName'], $articleLocation['subChannelSefName'], $articleLocation['categorySefName'] ] ) : makeCategoryPath($articleLocation['categoryId'], $articleLocation['displayType'], $articleLocation['subChannelId'])
                    ]                    
                ] 
        ];
    }
}