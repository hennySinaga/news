<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return "News API";
});

$app->group(['prefix' => 'api/v1'], function($app)
{
    $app->get('news/list','NewsController@getNewsList');
    $app->get('news/detail/{id}','NewsController@getNewsDetail');
    $app->post('news/post','NewsController@postNews');

    $app->get('category/list','CategoryController@getCategoryList');
    $app->get('category/news/{id}','CategoryController@getNewsByCategory');
    $app->post('news-post','CategoryController@postCategory');

    $app->post('comments/post','CommentsController@postComment');
});