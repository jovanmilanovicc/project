<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class HomneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function home(){
        $posts=Post::paginate(10);
        return view('home.home',compact('posts'));
    }
    public function index()
    {
        $post=Post::all();
        return view('home.index',['posts'=>$post]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('home.user_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($slug)
    {
        $comment=Comment::all();
        $post=Post::where('slug',$slug)->first();;
        return view('home.post',['post'=>$post,'comments'=>$comment]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showPost($slug){
        $post=Post::where('slug',$slug)->first();;
        return view('home.post',['post'=>$post]);

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function profileUpdate(ProfileUpdateRequest $request, $slug){


        $user=User::where('slug',$slug)->first();

        if(Auth::user()->id ==$user->id or Auth::user()->role=='admin') {
            $pass = $request->password;
            $hashed = Hash::make($pass);

            if ($user->password == $hashed) {
                $inputs = $request->except('password');
            } else {
                $inputs = $request->all();
                $inputs['password'] = $hashed;
            }
            if ($file = $request->file('photo_id')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $inputs['photo_id'] = $name;
            }
            $user->update($inputs);
            Session::flash('user_updated', 'User has been updated');
            return redirect()->back();
        }else{
            return redirect('/home')->with('Acces_denied','You do not have acces for this');
        }



    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function userProfile($slug){
        $user=User::where('slug',$slug)->first();
        if(session()->get('user')) {
            session()->put('user', $user->id);
        }
        return view('home.user_profile',compact('user'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function userPosts(){
        $post=Post::where('user_id',Auth::user()->id)->get();
        return view('home.users-posts',['posts'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post=Post::where('slug',$slug)->first();
        if(Auth::user()->id ==$post->user_id or Auth::user()->role=='admin') {
            return view('home.users-edit', ['post' => $post]);
        }else{
            return redirect('/home')->with('acces_denied','You do not have acces for this');

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(PostUpdateRequest $request, $slug)
    {
        $post=Post::where('slug',$slug)->first();
        $inputs=$request->all();
        if($file=$request->file('photo_id')){
            $name=time().$file->getClientOriginalName();
            $file->move('images',$name);
            $inputs['photo_id']=$name;
        }
        $post->update($inputs);
        Session::flash('post_updated','Post has been updated');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($slug)
    {
        $post=Post::where('slug',$slug)->first();
        if(Auth::user()->id==$post->user_id or Auth::user()->role=='admin') {
            $post->delete();
            return redirect()->back();
        }else{
            return redirect('/home')->with('acces_denied','You do not have acces for this');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteComment($id){
        $comment=Comment::findOrFail($id);
        $comment->delete();
        return redirect()->back()->with('comment_deleted','Comment has been deleted');

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function commentCreate(Request $request,$id){
        $inputs=$request->all();
        $inputs['post_id']=$id;
        $inputs['author']=Auth::user()->username;
        Comment::create($inputs);
        return redirect()->back();

    }
}
