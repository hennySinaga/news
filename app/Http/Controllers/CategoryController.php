<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Transformers\CategoryFormatter;
use App\Transformers\CategoryNewsFormatter;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /*
     * Daftar kategori
     * +filter : name
     */
    public function getCategoryList(Request $request){
        $this->validate($request, [
            'name' => 'sometimes'
        ]);

        $request = $request->all();

        $cat = CategoryModel::orderBy('created_at')->get();

        if(!empty($request['name']) && $request['name'] != ''){
            $cat = $cat->where('name', 'LIKE', '%'.$request['name'].'%');
        }

        if(count($cat) > 0){
            return $this->list_data($cat, new CategoryFormatter());
        }
        return $this->record_not_found();
    }

    /*
     * Daftar berita sesuai kategori
     */
    public function getNewsByCategory($id){

        $cat = CategoryModel::where('id', $id)->first();

        if(count($cat) > 0){
            return $this->detail($cat, new CategoryNewsFormatter());
        }
        return $this->record_not_found();
    }

    /*
     * Buat kategori
     */
    public function postCategory(Request $request){
        $this->validate($request, [
            'name' => 'required'
        ]);

        $request = $request->all();

        $cat = new CategoryModel();
        $cat->name = $request['name'];

        if($cat->save()){
            return $this->created($cat, new CategoryFormatter());
        }
        return $this->unprocessable('Failed to save category!');

    }
}
