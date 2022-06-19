<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersEditRequest;
use App\Http\Requests\UsersRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
    }
    public function allUsers(){
        $users=User::paginate(10);
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(UsersRequest $request)
    {
        if(trim($request->password=='')){
            $inputs=$request->except('password');
        }else{
            $inputs=$request->all();
            $inputs['password']=bcrypt($request->password);
        }

        $inputs=$request->all();
        if($file=$request->file('photo')){
            $name=time().$file->getClientOriginalName();
            $file->move('images',$name);
            $inputs['photo']=$name;
        }

        User::create($inputs);
        Session::flash('user_created','User has been created');
        return redirect('/admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $user=User::where('slug',$slug)->first();
        return view('admin.users.edit',['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(UsersEditRequest $request,$slug)
    {
        $user=User::where('slug',$slug)->first();
        $pass = $request->password;
        $hashed = Hash::make($pass);

        if ($user->password == $hashed) {
            $inputs = $request->except('password');
        } else {
            $inputs = $request->all();
            $inputs['password'] = $hashed;
        }

        if($file=$request->file('photo_id')){
            $name=time().$file->getClientOriginalName();
            $file->move(public_path('images',$name));
            $inputs['photo_id']=$name;
        }
        $user->update($inputs);
        Session::flash('user_updated','User has been updated');
        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy($slug)
    {
        $user=User::where('slug',$slug)->first();
        $post=Post::where('user_id',$user->id);
        $post->update(['user_id'=>Auth::user()->id]);
        $user->delete();
        Session::flash('deleted_user','User has been deleted');
        return redirect('admin/users');
    }
}
