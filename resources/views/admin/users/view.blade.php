<?php

?>
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
<img src="<?php echo $userInfo->avatar ?>">
<form action="{{ URL::route('admin/users/edit') }}" method="POST">
    <input type="text" name="phone">
    <input type="text" name="firstname">
    <input type="text" name="lastname">
    <input type="text" name="address">
    <input type="date" name="birthday">
    <input type="text" name="facebook">
    <input type="text" name="about">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="<?php echo $user->id ?>">
    <input type="submit">
</form>
<form action="{{ URL::route('admin/users/editavatar') }}" enctype="multipart/form-data" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="<?php echo $user->id ?>">
    <input name="avatar" type="file">
    <input type="submit">
</form>