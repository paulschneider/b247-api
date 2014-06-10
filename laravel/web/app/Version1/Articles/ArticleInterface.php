<?php namespace Version1\Articles;

Interface ArticleInterface {

    public function getArticles($type, $limit, $channel);

    public function getArticle($identifier);

    public function storeArticle($form);
}
