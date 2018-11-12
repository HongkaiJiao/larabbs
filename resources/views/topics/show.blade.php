@extends('layouts.app')

@section('title',$topic->title)
@section('description',$topic->excerpt)

@section('content')

<div class="row">
    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
        <div class="panel panel-default">
            <div class="panel-body">
                <!--左侧头像栏：姓名-->
                <div class="text-center">
                    作者：{{ $topic->user->name }}
                </div>
                <hr>
                <!--左侧头像栏：头像-->
                <div class="media">
                    <div align="center">
                        <a href="{{ route('users.show',$topic->user_id) }}">
                            <img class="thumbnail img-responsive" src="{{ $topic->user->avatar }}" height="300px" width="300px"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
        <div class="panel panel-default">
            <div class="panel-body">
                <!--右侧主话题栏：标题-->
                <h1 class="text-center">
                    {{ $topic->title }}
                </h1>
                <!--右侧主话题栏：中间状态-->
                <div class="article-meta text-center">
                    {{ $topic->created_at->diffForHumans() }}
                    ·
                    <!--此处仅是一个图标，没必要被类似屏幕阅读器的设备访问，因此设置aria-hidden="true"，hidden就是对其隐藏-->
                    <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                    {{ $topic->reply_count }}
                </div>
                <!--右侧主话题栏：话题主体-->
                <div class="topic-body">
                    {!! $topic->body !!}
                </div>
                <!--右侧主话题栏：话题操作按钮-->
                @can('update', $topic)
                <div class="operate">
                    <hr>
                    <a href="{{ route('topics.edit',$topic->id) }}" class="btn btn-default btn-xs pull-left" role="button">
                        <i class="glyphicon glyphicon-edit"></i> 编辑
                    </a>

                    <form action="{{ route('topics.destroy',$topic->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-default btn-xs pull-left" style="margin-left: 6px;">
                            <i class="glyphicon glyphicon-trash"></i> 删除
                        </button>
                    </form>

                    <a href="#"  role="button">

                    </a>
                </div>
                @endcan
            </div>
        </div>

        {{--用户回复列表--}}
        <div class="panel panel-default topic-reply">
            <div class="panel-body">
                @includeWhen(Auth::check(),'topics._reply_box',['topic' => $topic])
                @include('topics._reply_list',['replies' => $topic->replies()->with('user')->get()])
            </div>
        </div>
    </div>
</div>

@endsection
