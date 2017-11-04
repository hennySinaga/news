<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\CommentsModel;
use App\Transformers\CategoryFormatter;
use App\Transformers\CategoryNewsFormatter;
use App\Transformers\CommentsFormatter;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /*
     * Submit komentar
     */
    public function postComment(Request $request){
        $this->validate($request, [
            'news_id' => 'required|exists:news,id',
            'content'   => 'required'
        ]);

        $comm = new CommentsModel();
        $comm->news_id = $request['news_id'];
        $comm->content = $request['content'];

        if($comm->save()){
            return $this->created($comm, new CommentsFormatter());
        }
        return $this->unprocessable('Failed to save comment!');
    }
}
