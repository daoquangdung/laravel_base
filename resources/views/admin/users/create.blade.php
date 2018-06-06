
@extends('admin.layouts.master')

@section('includeCss')
    <link href="{!! asset('css/lib/sweetalert/sweetalert.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/lib/toastr/toastr.min.css') !!}" rel="stylesheet">

@endsection



@section('style')
    <link href="{!! asset('css/style/style.css') !!}" rel="stylesheet">
@endsection


@section('breadcrumb')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Users</h3> </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </div>
    </div>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-title">
                        <h4>Input Style</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ URL::route('admin/users/create') }}" method="POST">
                                @if (Session::has('success'))
                                    <div class="alert alert-info">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        {{ Session::get('success') }}
                                    </div>
                                @endif
                                @if(Session::has('errors'))
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <strong>Error!</strong>
                                        <br/>
                                        <ul>
                                            @foreach(Session::get('errors') as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach

                                        </ul>

                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="control-label">Username</label>
                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-user"></i></div>
                                        </div>
                                        <input type="text" name="name" class="form-control" value="" placeholder="Username">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                                        </div>
                                        <input type="text" name="email" class="form-control" value="" placeholder="Email">
                                    </div>
                                </div>
                                    <div class="form-group">
                                        <label class="control-label">Password</label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></div>
                                            </div>
                                            <input type="password" name="password" class="form-control" value="" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Password confirm</label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></div>
                                            </div>
                                            <input type="password" name="password_confirm" class="form-control" value="" placeholder="Enter password">
                                        </div>
                                    </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-default">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('includeScript')
    <script src="{!! asset('js/lib/toastr/toastr.min.js') !!}"></script>
@endsection
@section('script')
    <script>
        $(document).ready(function () {

        });


    </script>
@endsection