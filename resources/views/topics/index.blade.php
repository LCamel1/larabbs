@extends('layouts.app')

@section('title', empty($category) ? env('APP_NAME') : $category->name)

@section('content')
<div class="row mb-5">
  <div class="col-lg-9 col-md-9 topic-list">

    @if (!empty($category))
    <div class="alert alert-info" role="alert">
      {{ $category->name }} ：{{ $category->description }}
    </div>
    @endif

    <div class="card ">
      <div class="card-header">
       <ul class="nav nav-pills">
        <li class="nav-item">
          <a class="nav-link {{ (Request::get('order')!=2) ? 'active' : ''}} " href="{{ Request::url() }}?order=1">最后回复</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ (Request::get('order')==2) ? 'active' : ''}} " href="{{ Request::url() }}?order=2">最新发布</a>
        </li>
       </ul>
      </div>

      <div class="card-body">
        {{-- 话题列表 --}}
        @if (count($topics) > 0)
            <ul class="list-unstyled">
              @foreach ($topics as $topic)
                  <li class="d-flex">
                    <div class="" style="float:left;">
                      <a href="{{ route('users.show', [$topic->user_id]) }}">
                        <img class="media-object img-thumbnail mr-3" style="width: 52px; height: 52px;" src="{{ $topic->avatar }}" title="{{ $topic->user_name }}" />
                      </a>
                    </div>

                    <div class="flex-grow-1 ms-2">
                      <div class="mt-0 mb-1">
                        <a href="{{ route('topics.show', $topic->id) }}" title="{{ $topic->title }}">{{ $topic->title }}</a>
                        <a class="float-end" href="{{ route('topics.show', [$topic->id,$topic->slug]) }}">
                          <span class="badge bg-secondary rounded-pill"> {{ $topic->reply_count }} </span>
                        </a>
                      </div>

                      <small class="media-body meta text-secondary">
                        <a class="text-secondary" href="{{ route('topics.list', 'c' ,$topic->category_id)  }}" title="@if (empty($category)){{ $topic->category_name }}@else {{ $category->name }}@endif">
                          <i class="far fa-folder"></i>
                          @if (empty($category)){{ $topic->category_name }}@else {{ $category->name }}@endif
                        </a>
                        <span> • </span>
                        <a class="text-secondary" href="{{ route('users.show', [$topic->user_id]) }}" title="{{ $topic->user_name }}">
                          <i class="far fa-user"></i>{{ $topic->user_name }}
                        </a>
                        <span> • </span>
                        <i class="far fa-clock"></i>
                        <span class="timeago" title="最后活跃于：{{ $topic->updated_at }}">{{ \Carbon\Carbon::parse($topic->updated_at)->diffForHumans() }}</span>
                      </small>
                    </div>
                  </li>
                  @if ( ! $loop->last)<!--$foreach 循环中内置了 $loop 变量-->
                  <hr>
                  @endif
              @endforeach
            </ul>
        @else
        <div class="empty-block">暂无数据！！</div>
        @endif

        {{-- 分页 --}}
        <div class="mt-5">{{ $topics->appends(Request::except('page'))->links() }}</div>
      </div>
    </div>
  </div>

  {{-- right sidebar --}}
  <div class="col-lg-3 col-md-3 sidebar">
    <div class="card">
      <div class="card-body">
        <a href="{{ route('topics.create') }}" class="btn btn-success w-100" aria-label="Left Align">
          <i class="fas fa-pencil-alt mr-2"></i> 新建帖子
        </a>
      </div>
    </div>
  </div>



</div>
@endsection
