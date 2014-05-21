<?php namespace Api\Transformers;

abstract class Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param $items
     * @return array
     */
    public function transformCollection(array $items)
    {
        return array_map([$this, 'transform'], $items);
    }

    public abstract function transform($item);
}
