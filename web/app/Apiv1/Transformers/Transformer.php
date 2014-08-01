<?php namespace Apiv1\Transformers;

abstract class Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param $items
     * @return array
     */
    public abstract function transformCollection($items, $options);

    /**
     * Transform a single result into the API required format
     *
     * @param $item
     * @return array
     */
    public abstract function transform($item, $options);
}
