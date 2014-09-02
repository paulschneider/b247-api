<?php namespace Apiv1\Transformers;

class StaticArticleTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $article, $options = [] )
    {
        return [
            'id' => $article['id'],
            'title' => $article['title'],
            'sefName' => $article['sef_name'],
            'subHeading' => $article['sub_heading'],
            'body' => $article['body'],
            'bodyContinued' => $article['body_continued']
        ];
    }

    /**
     * Transform a result set into the API required format
     *
     * @param users
     * @return array
     */
    public function transformCollection( $articles, $options = [] )
    {
        //
    }
}
