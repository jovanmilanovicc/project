@extends('layouts.index')

@section('content')
    <header class="masthead" style="background-image: url('{{asset('assets/home-bg.jpg')}}')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="post-heading">
                        <h1>Clean Blog</h1>
                        <span class="subheading">A Blog Theme by Start Bootstrap</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                @foreach($posts as $post)
                <!-- Post preview-->
                <div class="post-preview">
                    <a href="{{route('post.detail',$post->id)}}">
                        <h2 class="post-title">{{$post->title}}</h2>
                        <h3 class="post-subtitle">{{substr($post->title,0,20)}}</h3>
                    </a>
                    <p class="post-meta">
                        Posted by
                        <a href="{{route('user.profile',$post->user->id)}}">{{$post->user->name}}</a>
                        on {{$post->created_at->diffForHumans()}}
                    </p>
                </div>
                <!-- Divider-->
                <hr class="my-4" />
                <!-- Post preview-->
                @endforeach

        </div>
    </div>



@stop
