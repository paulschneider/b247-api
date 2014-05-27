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
            $tmp = [
                'id' => $article->id
                ,'title' => $article->title
                ,'sefName' => $article->articleSefName
                ,'path' => $article->channelSefName . '/' . $article->subChannelSefName . '/' . $article->categorySefName . '/' . $article->articleSefName
                ,'assignment' => [
                    'channel' => [
                        'id' => $article->channelSefName
                        ,'name' => $article->channelName
                        ,'sefName' => $article->channelSefName
                    ]
                    ,'subChannel' => [
                        'id' => $article->subChannelSefName
                        ,'name' => $article->subChannelName
                        ,'sefName' => $article->subChannelSefName
                    ]
                    ,'category' => [
                        'id' => $article->categoryId
                        ,'name' => $article->categoryName
                        ,'sefName' => $article->categorySefName
                    ]
                ]
                ,'media' => [
                    'filepath' => $article->filepath
                    ,'alt' => $article->alt
                    ,'title' => $article->assetTitle
                    ,'width' => $article->width
                    ,'height' => $article->height
                ]
            ];

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
        return $response = [
            'id' => $article->id
            ,'title' => $article->title
            ,'sefName' => $article->articleSefName
            ,'path' => $article->channelSefName . '/' . $article->subChannelSefName . '/' . $article->categorySefName . '/' . $article->articleSefName
            ,'assignment' => [
                'channel' => [
                    'id' => $article->channelSefName
                    ,'name' => $article->channelName
                    ,'sefName' => $article->channelSefName
                ]
                ,'subChannel' => [
                    'id' => $article->subChannelSefName
                    ,'name' => $article->subChannelName
                    ,'sefName' => $article->subChannelSefName
                ]
                ,'category' => [
                    'id' => $article->categoryId
                    ,'name' => $article->categoryName
                    ,'sefName' => $article->categorySefName
                ]
            ]
            ,'media' => [
                'filepath' => $article->filepath
                ,'alt' => $article->alt
                ,'title' => $article->title
                ,'width' => $article->width
                ,'height' => $article->height
            ]
        ];
    }
}
