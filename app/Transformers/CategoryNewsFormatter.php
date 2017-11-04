<?php

namespace App\Transformers;

use League\Fractal;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class CategoryNewsFormatter extends TransformerAbstract
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
    protected $defaultIncludes = ['news'];

    /*public function includeNews($resource) {
        $com = $resource->news()->get();
        if(!empty($com))
            return $this->item($com, new NewsFormatter());
        return null;
    }*/

    public function includeNews($resource){
        if(empty($resource)) return NULL;
        $data = $resource->news()->get();
        return $this->collection($data, new NewsFormatter());
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
            'id'     => $resource['id'],
            'name'   => $resource['name'],
        ];
    }
}
