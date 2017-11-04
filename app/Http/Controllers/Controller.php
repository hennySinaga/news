<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;

class Controller extends BaseController
{
    protected function record_not_found()
    {
        return response([
            'status' => 'success',
            'data' => [],
            'message' => 'No record(s) found!'
        ], 200);
    }

    protected function list_data($data, $formatter = null, $message = '')
    {
        if(!empty($formatter))
        {
            $fractal = new Manager;
            $resource = new Collection($data, $formatter);
            $result = $fractal->createData($resource)->toArray();
        }
        else
        {
            $result['data'] = $data;
        }

        return response([
            'status' => 'success',
            'data' => $result['data'],
            'message' => $message
        ], 200);
    }

    protected function pagination_data($obj, $limit, $formatter = null)
    {
        $fractal = new Manager();
        $obj = $obj->paginate($limit);
        $datas = $obj->getCollection();

        $resource = new Collection($datas, $formatter);
        $resource->setPaginator(new IlluminatePaginatorAdapter($obj));
        $result = $fractal->createData($resource)->toArray();


        $pagination = $result['meta']['pagination'];
        if($pagination['total'] == 0){return $this->record_not_found();}

        return response([
            'status' => 'success',
            'data' => $result['data'],
            'message' => 'Success retrieving data',
            'meta' => [
                'pagination' => [
                    'page' => $pagination['current_page'],
                    'limit' => $pagination['per_page'],
                    'total_data' => $pagination['total'],
                    'total_page' => $pagination['total_pages'],
                ]
            ]
        ], 200);
    }

    protected function created($data, $formatter = null)
    {
        $fractal = new Manager;
        $resource = new Collection([$data], $formatter);
        $result = $fractal->createData($resource)->toArray();

        return response([
            'status' => 'success',
            'data' => $result['data'],
            'message' => 'Success inserting new value'
        ], 201);
    }

    protected function updated($data = null, $formatter = null, $message = 'Success updating value')
    {
        if(!empty($data))
        {
            $fractal = new Manager;
            $resource = new Collection([$data], $formatter);
            $result = $fractal->createData($resource)->toArray();
            $data = $result['data'];
        }
        else
        {
            $data = [];
        }

        return response([
            'status' => 'success',
            'data' => $data,
            'message' => $message
        ], 200);
    }

    protected function deleted($message = 'Success delete data')
    {
        return response([
            'status' => 'success',
            'data' => [],
            'message' => $message
        ], 200);
    }

    protected function lazy_load($data, $formatter, $message = '')
    {
        foreach($data as $row)
        {
            $result[$row->serial] = $formatter->transform($row);
        }

        return response([
            'status' => 'success',
            'data' => $result,
            'message' => $message
        ], 200);
    }

    protected function detail($data, $formatter = null)
    {
        $fractal = new Manager;
        $resource = new Collection([$data], $formatter);
        $result = $fractal->createData($resource)->toArray();

        return response([
            'status' => 'success',
            'data' => $result['data'],
            'message' => 'Detail Data'
        ], 200);
    }

    protected function unprocessable($message=null)
    {
        return response([
            'status' => 'validation fail',
            'data' => [],
            'message' => $message
        ], 422);
    }
}
