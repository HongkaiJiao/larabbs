@if (count($topics))

    <ul class="media-list">
        @foreach($topics as $topic)
            <li class="media">
                {{--左侧栏头像--}}
                <div class="media-left">
                  <a href="{{ route('users.show',[$topic->user_id]) }}">
                      <img class="media-object img-thumbnail" src="{{ $topic->user->avatar }}" title="{{ $topic->user->name }}" style="width:52px;height:52px;"/>
                  </a>
                </div>

                {{--左侧栏内容主体--}}
                <div class="media-body">

                    {{--话题标题--}}
                    <div class="media-heading">
                        <a href="{{ $topic->link() }}" title="{{ $topic->title }}">
                            {{ $topic->title }}
                        </a>
                        <a class="pull-right" href="{{ $topic->link() }}">
                            <span class="badge">{{ $topic->reply_count }}</span>
                        </a>
                    </div>

                    {{--话题主体:分类·作者·时间--}}
                    <div class="media-body meta">
                        <a href="{{ route('categories.show',[$topic->category->id]) }}" title="{{ $topic->category->name }}">
                            <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                            {{ $topic->category->name }}
                        </a>
                        <span>·</span>
                        <a href="{{ route('users.show',[$topic->user_id]) }}" title="{{ $topic->user->name }}">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            {{ $topic->user->name }}
                        </a>
                        <span>·</span>
                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        <span class="timeago" title="最后活跃于">{{ $topic->updated_at->diffForHumans() }}</span>
                    </div>

                </div>

            </li>
            @if (! $loop->last)
                <hr>
            @endif
        @endforeach
    </ul>

@else
    <div class="empty-block">暂无数据~_~</div>
@endif