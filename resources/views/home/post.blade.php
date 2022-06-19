@extends('layouts.index')
@section('content')



    <header class="masthead" style="background-image: url('{{asset('images/'.$post->photo)}}')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="post-heading">
                        <h1>{{$post->title}}</h1>
                        <h2 class="subheading"></h2>
                        <span class="meta">
                                Posted by
                                <a href="{{route('user.profile',$post->user->id)}}">{{$post->user->name}}</a>
                                on {{$post->created_at}}
                            </span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <article class="mb-4">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                   {{$post->body}}
            </div>
        </div>
        </div>
    </article>
    <!--COMMENTS-->
    <div class="ol-md-4 col-md-offset-4">


    </div>



    <div class="container mt-5">
        <div class="row  d-flex justify-content-center">
            <div class="col-md-8 my-5">
                {!! Form::open(['route'=>['comment.create',$post->id],'method'=>'POST']) !!}
                @method('POST')
                <div class="form-group">
                {!! Form::label('body','Write an Comment') !!}
                {!! Form::textarea('body',null,['class'=>'center_div','rows'=>6]) !!}
                </div>

                {!! Form::submit('Post',['class'=>'btn btn-primary']) !!}
                {!! Form::close() !!}
                <div class="headings d-flex justify-content-between align-items-center mb-3">
                    @if($comments)
                    @foreach($comments as $comment)

                </div>
                <hr>
                <div class="card p-3 my-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="user d-flex flex-row align-items-center">
                            <img src="{{asset('images/'.$comment->post->photo)}}" width="30" class="user-img rounded-circle mr-2">
                            <span><small class="font-weight-bold text-primary">{{$comment->author}}</small> <small class="font-weight-bold">{{$comment->body}}</small></span>
                        </div>
                        <small>{{$comment->created_at->diffForHumans()}}</small>
                    </div>
                    <div class="action d-flex justify-content-between mt-2 align-items-center">
                        <div class="reply px-4">
                            @if(Auth::user()->role=='admin')
                                {!! Form::open(['route'=>['comment.delete',$comment->id],'method'=>'DELETE']) !!}
                                {!! Form::submit('Delete',['class'=>'btn btn-danger p-1']) !!}
                                {!! Form::close() !!}
                            @endif


                        </div>
                        <div class="icons align-items-center">

                            <i class="fa fa-check-circle check-icon"></i>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif



            </div>

        </div>

    </div>





@stop
