<?php

use App\Http\Controllers\PostsController;
use App\Models\Post;
use App\Models\User;
use App\Models\Country;
use App\Models\Photo;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome'); // default
});

/*
|--------------------------------------------------------------------------
| Basics
|--------------------------------------------------------------------------
*/
/* Route::get('/about', function() {
    return "Hi! This is About Page";
});

Route::get('/contact', function() {
    return "Hi! This is Contact Page";
});

Route::get('/post/{id}/{name}', function($id, $name) {
    return "Hi! This is post number " . $id . " - " . $name;
}); */

Route::get('/post',[PostsController::class, 'index']); //without parameters
Route::get('/post/{id}',[PostsController::class, 'index']); //with parameters

/*
|--------------------------------------------------------------------------
| Resource & Controllers
|--------------------------------------------------------------------------
*/
// Route::resource('posts', PostsController::class); // this calls the CRUD method

/*
|--------------------------------------------------------------------------
| Custom Methods
|--------------------------------------------------------------------------
| Get views from controller
*/

Route::get('/contact', [PostsController::class, 'contact']);

Route::get('/post/{id}/{name}/{nickname}', [PostsController::class, 'show_post']);

/*
|--------------------------------------------------------------------------
| intro to Raw SQL queries
|--------------------------------------------------------------------------
*/
Route::get('/insert', function(){
    DB::insert('insert into posts (title, content) values (?, ?)', ['Intro to Laravel', 'Now its eloquent']);
});

Route::get('/read', function(){
    $results = DB::select('select * from posts where id = ?', [1]);

    foreach($results as $post) {
        return $post->title;
    }
});

Route::get('/update', function() {
    $updated = DB::update('update posts set title = "Updated title" where id = ?', [1]);

    return $updated;
});

Route::get('/delete', function() {
    $result = DB::delete('delete from posts where id = ?', [1]);

    return $result;
});

/*
|--------------------------------------------------------------------------
| ELOQUENT ORM
|--------------------------------------------------------------------------
*/

Route::get('/find', function() {
    $posts = Post::find(2);

    return $posts;
    // foreach($posts as $post) {
    //     return $post->title;
    // }
});

Route::get('/findwhere', function() {
    // $posts = Post::where('id', 3)->orderBy('id', 'desc')->get();
    // return $posts;

    $post = Post::findOrFail(3);
    return $post;
});

Route::get('/basicinsert', function() {
    $post = new Post();

    $post->title = "Save info via eloquent";
    $post->content = "This should be the practice";

    return $post->save();
});

Route::get('/basicinsert2', function() {
    $post = Post::findOrFail(2);

    $post->title = "Its database (updated)";
    $post->content = "This should be the practice";

    return $post->save();
});

Route::get('/create', function() {
    return Post::create(['title' => 'The Create Method', 'content' => 'Wow! I\'m learning a lot']);
});

Route::get('/basicupdate', function(){ 
    return Post::where('id', 2)->update(['title'=>'I just updated it again']);
});

Route::get('/delete1', function() {
    // $post = Post::findOrFail(2);
    // $post->delete();

    // return Post::destroy(3);

    return Post::where('id', 4)->delete();
});

Route::get('/softdelete', function() {
    return Post::find(6)->delete();
});

Route::get('/readsoftdelete', function() {
    // return Post::withTrashed()->where('id', 7)->get();
    return Post::onlyTrashed()->get();
});

route::get('/restore', function() {
    return Post::withTrashed()->where('is_admin', 0)->restore();
});

route::get('/forcedelete', function() {
    // return Post::withTrashed()->where('id', 5)->forceDelete();
    return Post::onlyTrashed()->forceDelete();
});

/*
|--------------------------------------------------------------------------
| Eloquent Relationships
|--------------------------------------------------------------------------
*/

Route::get('/user/{id}/post', function($id){ // one to one
    // return User::find($id)->post;
    return User::find($id)->post->title;
});

Route::get('/post/{id}/user', function($id) { // inverse relation
    // return Post::find($id)->user;
    return Post::find($id)->user->name;
}); 

Route::get('/posts', function() { // one to many
    $user = User::find(1);

    foreach($user->posts as $post){
        echo $post->title;
    }
});

Route::get('/user/{id}/role', function($id) {
    /* $user = User::find(1);

    foreach($user->roles as $role) {
        echo $role->name;
    } */

    return User::find(1)->roles;
});

// Accessing intermediate table / pivot
Route::get('/user/pivot', function(){
    $user = User::find(1);

    foreach($user->roles as $role) {
        echo $role->pivot->created_at;
    }
});

// hasmanythrough
Route::get('/user/country', function() {
    $country = Country::find(6);

    foreach($country->posts as $post) {
        echo $post->title;
    }
});

// polymorphic Relation

Route::get('/user/{id}/photos', function($id) {
    $user = User::find($id);

    foreach($user->photos as $photo) {
        return $photo;
    }
});

Route::get('/photo/{id}/post', function($id) {
    $photo = Photo::findOrFail($id);
    return $photo->imageable;
});

// polymorphic many to many
Route::get('/post/{id}/tag', function($id) {
    $post = Post::find($id);
    foreach($post->tags as $tag) {
        echo $tag->name;
    }
});

Route::get('/tag/{id}/post', function($id) {
    $tag = Tag::find($id);

    foreach($tag->posts as $post) {
        echo $post->title;
    }
});

/*
|--------------------------------------------------------------------------
| CRUD Application
|--------------------------------------------------------------------------
*/

// Route::resource('/posts', PostsController::class);

Route::middleware(['web'])->group(function () {
    Route::resource('/posts', PostsController::class);

    Route::get('/dates', function () {
        $date = new DateTime('+1 week');
        echo $date->format('m-d-Y')."<br />";
        echo Carbon::now()->addDays(10)->diffForHumans()."<br />";
        echo Carbon::now()->subMonth(5)->diffForHumans()."<br />";
        echo Carbon::now()->yesterday()->diffForHumans()."<br />";
    });

    Route::get('/getname', function() { // accessor makes db value changed before it displays data
        $user = User::find(1);
        return $user->name;
    });

    Route::get('/setname', function() { // mutator changes the value before saving to db
        $user = User::find(1);
        $user->name = "kei";
        $user->save();
    });
});