<?php

namespace App\Http\Controllers;

use App\Models\NewsModel;
use App\Transformers\NewsDetailFormatter;
use App\Transformers\NewsFormatter;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /*
     * Daftar semua berita (title dan kategori)
     * +pagination
     * +filter : title, description
     */
    public function getNewsList(Request $request){
        $this->validate($request, [
            'limit' => 'sometimes',
            'title' => 'sometimes',
            'description' => 'sometimes'
        ]);

        isset($request['limit']) ? $limit = $request['limit'] : $limit = 10;

        $news = NewsModel::orderBy('created_at')->get();

        if(!empty($request['title']) && $request['title'] != ''){
            $news = $news->where('title', 'LIKE', '%'.$request['title'].'%');
        }
        if(!empty($request['description']) && $request['description'] != ''){
            $news = $news->where('description', 'LIKE', '%'.$request['description'].'%');
        }

        if(count($news) > 0){
            return $this->pagination_data($news, $limit, new NewsFormatter());
        }
        return $this->record_not_found();
    }

    /*
     * Detail berita dengan komentar
     */
    public function getNewsDetail(Request $request){
        $this->validate($request, [
            'id' => 'required'
        ]);

        $news = NewsModel::where('id', $request['id'])->first();

        if(count($news) > 0){
            return $this->detail($news, new NewsDetailFormatter());
        }
        return $this->record_not_found();
    }

    /*
     * Submit berita
     */
    public function postNews(Request $request){
        $this->validate($request, [
            'category_id'   => 'required|exists:category,id',
            'title'         => 'required',
            'description'   => 'required'
        ]);

        $news = new NewsModel();
        $news->category_id  = $request['category_id'];
        $news->title        = $request['title'];
        $news->description  = $request['description'];
        if($news->save()) {
            return $this->created($news, new NewsFormatter());
        }
        return $this->unprocessable("Failed to save news!");
    }
}
