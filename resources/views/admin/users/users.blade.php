
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-md-9">
                                <h4>Users</h4>
                            </div>
                            <div class="col-md-3">
                                <div class="text-right">
                                    <a href="{{ route('admin/users/create') }}" class="btn btn-primary active">Add user</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($users as $user){ ?>
                                <tr id="tr-<?php echo $user->id ?>">
                                    <th scope="row"><?php echo $user->id ?></th>
                                    <td><?php echo $user->username ?></td>
                                    <td><?php echo $user->email ?></td>
                                    <td><?php echo $user->created_at ?></td>
                                    <td>
                                        <a href="{{ route('admin/users/get', [$user->id]) }}" class="fix-btn btn btn-primary btn-flat m-b-10 m-l-5"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-url="{{ URL::route('admin/users/delete') }}" data-id="<?php echo $user->id ?>" class="delete-record fix-btn btn btn-danger m-b-10 m-l-5"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            {!! $users->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('includeScript')
    <script src="{!! asset('js/lib/sweetalert/sweetalert.min.js') !!}"></script>
    <script src="{!! asset('js/lib/toastr/toastr.min.js') !!}"></script>
@endsection
@section('script')
    <script src="{!! asset('js/admin/users/users.js') !!}"></script>
@endsection