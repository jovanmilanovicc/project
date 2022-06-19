@extends('layouts.admin')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Validation</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
                        <li class="breadcrumb-item active">Validation</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create a user</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="px-3">
                            {!!Form::open(['method'=>'POST','route'=>'admin.posts.store','files'=>'true'])!!}
                            <div class="form-group">
                                {!! Form::label('title','Title:') !!}
                                {!! Form::text('title',null,['class'=>'form-control']) !!}
                                <div class="text-danger">
                                    @error('title')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('body','Body:') !!}
                                {!! Form::text('body',null,['class'=>'form-control']) !!}
                            </div>
                            <div class="text-danger">
                                @error('body')
                                {{$message}}
                                @enderror
                            </div>


                            <div class="form-group">
                                {!! Form::label('photo','File: ') !!}
                                {!! Form::file('photo',null,['class'=>'form-control']) !!}
                            </div>
                            <div class="text-danger">
                                @error('photo')
                                {{$message}}
                                @enderror
                            </div>


                            <div class="form-group">
                                {!! Form::submit('Create a Post',['class'=>'btn btn-primary']) !!}

                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">

                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>


@stop

