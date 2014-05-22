<?php namespace Api\Transformers;

class ArticleTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transform($articles)
    {
        $response = [];

        foreach($articles AS $article)
        {
            $tmp = [
                'id' => $article['id']
                ,'title' => $article['title']
                ,'subHeading' => $article['sub_heading']
                ,'body' => $article['body']
                ,'postCode' => $article['postcode']
                ,'lat' => $article['lat']
                ,'lon' => $article['lon']
                ,'area' => $article['area']
                ,'published' => $article['published']
            ];

            $response[] = $tmp;
        }
        return $response;
    }
}
