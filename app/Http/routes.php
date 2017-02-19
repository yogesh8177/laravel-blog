<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// Authentication Routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration Routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/post','PostsController@index');
Route::post('/post','PostsController@index');
Route::get('/search','PostsController@search');
Route::post('/search','PostsController@search');
Route::get('/postview/{id}/{slug?}','PostsController@getPost');
Route::get('/postmeta/{id}','PostsMetaController@index');
Route::get('/comments/{id}','CommentsController@index');
Route::get('/authors','AuthorsController@index');
Route::get('/authors/{id}','AuthorsController@getAuthor');
Route::get('/category','CategoryController@index');
Route::get('/tags','TagsController@index');


Route::get('/post/create',['middleware' => 'auth','uses' => 'PostsController@createview']);
Route::post('/post/create',['middleware' => 'auth','uses' => 'PostsController@create']); //check f authenticated
Route::get('/post/edit/{id}',['middleware' => 'auth','uses' => 'PostsController@editView']);
Route::post('/post/edit',['middleware' => 'auth','uses' => 'PostsController@editPost']);
Route::post('/post/delete',['middleware' => 'auth', 'uses' => 'PostsController@deletePost']);
Route::post('/post/tags/delete',['middleware' => 'auth','uses' => 'PostsController@deleteTag']);

//postmeta
Route::get('/post/postmeta/{id}','PostMetaController@create');
Route::post('/post/postmeta/edit','PostMetaController@edit');
Route::post('/post/postmeta/featuredimage/remove','PostMetaController@deleteFeaturedImage');
Route::post('/post/postmeta/featuredimage/update','PostMetaController@updateFeaturedImage');
Route::post('/postmeta/author/update',['middleware' => 'auth', 'uses' => 'PostMetaController@updateAuthor']);

//category
Route::get('/category/{id}/{slug?}','CategoryController@searchById');
Route::post('/category/{id}/{slug?}','CategoryController@searchById');
Route::get('/new/create/',['middleware' => 'auth', 'uses' => 'CategoryController@createview']);
Route::post('/new/create/',['middleware' => 'auth', 'uses' => 'CategoryController@create']);

//tag
Route::get('/tag/{id}/{slug?}','TagsController@searchById');
Route::post('/tag/{id}/{slug?}','TagsController@searchById');

//comments
Route::get('comment/edit/{id}','CommentsController@edit');
Route::post('comment/create','CommentsController@create');
Route::post('comment/approve','CommentsController@approve');
Route::post('comment/delete','CommentsController@remove');

Route::auth();

Route::get('/home', 'HomeController@index');

//Admin
Route::get('/admin',['middleware' => 'auth', 'uses' => 'AdminController@index']);
Route::get('/admin/view',['middleware' => 'auth', 'uses' => 'AdminController@view']);
Route::post('/admin/view',['middleware' => 'auth', 'uses' => 'AdminController@view']);

//Author
Route::get('/author/create',['middleware' => 'auth', 'uses' => 'AuthorsController@createview']);
Route::post('/author/create',['middleware' => 'auth', 'uses' => 'AuthorsController@create']);

