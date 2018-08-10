@extends('layouts.app')
@section('title','编辑个人资料')
@section('content')
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h4><i class="glyphicon glyphicon-edit"></i> 编辑个人资料</h4>
        </div>

        @include('common.error')

        <div class="panel-body">
            <form method="post" action="{{ route('users.update',$user->id) }}" accept-charset="UTF-8" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name-field">用户名</label>
                    <input class="form-control" type="text" name="name" id="name-field" value="{{ old('name',$user->name) }}" />
                </div>
                <div class="form-group">
                    <label for="email-field">邮 箱</label>
                    <input class="form-control" type="text" name="email" id="email-field" value="{{ old('email',$user->email) }}" />
                </div>
                <div class="form-group">
                    <label for="introduction-field">个人简介</label>
                    <textarea class="form-control" cols="3" name="introduction" id="introduction-field">{{ old('introduction',$user->introduction) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="" class="avatar-label">用户头像</label>
                    <input type="file" name="avatar">

                    @if($user->avatar)
                        <br>
                        <img class="thumbnail img-responsive" src="{{ $user->avatar }}" width="200" />
                    @endif
                </div>
                <div class="well well-sm">
                    <button class="btn btn-primary" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>
@stop