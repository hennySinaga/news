<?php

namespace App\Transformers;

use League\Fractal;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class NewsDetailFormatter extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = ['comments'];

    public function includeComments($resource) {
        $com = $resource->comments()->get();
        if(!empty($com))
            return $this->item($com, new CommentsFormatter());
        return null;
    }

    /**
     * Transform object into a generic array
     *
     * @var $resource
     * @return array
     */
    public function transform($resource)
    {
        return [
            'id'            => $resource['id'],
            'category_id'   => $resource['category_id'],
            'title'         => $resource['title'],
            'description'   => $resource['description'],
        ];
    }
}
