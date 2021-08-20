<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return "Its working!";
        // $posts = Post::all();
        // $posts = Post::latest()->get();
        // $posts = Post::orderby('id','desc')->get();
        $posts = Post::latestOrder();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return "I am the method that create stuff";
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        /* getting the values from the create form */
        // return $request->all(); // sends all input data
        // return $request->get('title');
        // return $request->title;

        /* validate */
        // $this->validate($request, [
        //     'title' => 'required|max:10',
        //     'content' => 'required|max:50'
        // ]);

        /* saving it to table */
        /* Post::create($request->all());
        return redirect('/posts'); */

        // $input = $request->all();
        // $input['title'] = $request->title;

        // $post = new Post;
        // $post->title = $request->title;
        // $post->save();

        /* with attachment */
        // $file = $request->file('file');
        // echo $file->getFilename()."<br/>";
        // echo $file->getMaxFilesize()."<br/>";
        // echo $file->getClientOriginalName()."<br/>";
        // echo $file->getClientOriginalExtension()."<br/>";

        $input = $request->all();

        if($file = $request->file('file')) {
            $name = $file->getClientOriginalName();

            $file->move('images', $name);
            $input['path'] = $name;
        }

        Post::create($input);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return "This is the Show method!";
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->update($request->all());

        return redirect('/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::whereId($id)->delete();

        return redirect('/posts');
    }

    // customized function 
    public function contact()
    {
        $people = ['mark','kei', 'kym', 'ken'];
        return view('contact', compact('people'));
    }

    public function show_post($id, $name, $nickname)
    {
        // return view('post')->with('id', $id); // Single pass parameter
        return view('post', compact('id', 'name', 'nickname')); // In case multiple pass parameter
    }
}
