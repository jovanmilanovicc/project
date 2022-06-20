@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm">

    <h1 class="row pl-4">{{$user->name}}</h1>
    <div class=" p-lg-4">

            <img src="{{asset('images/'.$user->photo)}}">
    </div>



    </div>


    <div class="mr-5 pr-5">
        <div class="col-sm m-5">
            @if(session()->get('user')==Auth::user()->id or Auth::user()->role=='admin')
                <form action="{{route('profile.update',$user->slug)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" name="username"value="{{$user->username}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="username">Email:</label>
                        <input type="text" name="email"value="{{$user->email}}" class="form-control">
                    </div>
                    <div class="form-group">
                    <div class="form-group">
                        <label for="username">Password:</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="photo_id">File:</label>
                        <input type="file" name="photo_id" class="form-control">
                    </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </div>
                </form>
                        @if(Auth::user()->role=='admin')
                            <form action="{{route('admin.delete',$user->slug)}}" method="post">
                                @csrf
                                @method('DELETE')
                            <div class="form-group">
                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                            </form>
                            @endif




            @else
                <div class="col-sm-5"></div>
            <form action="">
                <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" disabled value="{{$user->username}}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="username">Email:</label>
                    <input type="text" name="email" disabled value="{{$user->email}}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="username">Role:</label>
                    <input type="text" name="eolw" disabled value="{{$user->role}}" class="form-control">
                </div>

            </form>
        </div>
            @endif


    </div>
    </div>
    </div>
    </div>





@stop
