@extends('layouts.app')
@section('title', $user->name.'的个人中心')

@section('content')
<div class="row">
  <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
    <div class="card" >
      @if ( $user->avatar )
           <img src="{{ $user->avatar }}" class="card-img-top" alt="{{ $user->name }}">
      @else
          <i class="fas fa-user-astronaut" style="padding-top:5px;font-size: 10rem; text-align:center;color: cornflowerblue;" ></i>
      @endif

      <div class="card-body">
       <h5 class="card-title">个人简介</h5>
       <p class="card-text">{{ $user->introduction }}</p>
       <hr />
       <h5 class="card-title">注册于</h5>
       <p class="card-text">{{ $user->created_at_str }}</p>
       <hr />
       <h5 class="card-title">最后活跃时间</h5>
       <p class="card-text">{{ $user->create_at }}</p>
      </div>
    </div>
  </div>

  <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    <div class="card">
      <div class="card-body">
        <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
      </div>
    </div>

    <hr />
    <div class="card">
      <div class="card-body">

        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link bg-transparent @if (Request::get('tab')!='replies') active @endif " href="{{ route('users.show', $user->id)}}">Ta的话题</a>
          </li>
          <li class="nav-item">
            <a class="nav-link bg-transparent @if (Request::get('tab')=='replies') active @endif " href="{{ route('users.show', [$user->id, 'tab'=>'replies'])}}">Ta的回复</a>
          </li>
        </ul>

        @if (Request::get('tab')=='replies')
            @include('users._replies',['replies' => $user->replies()->with('topic')->paginate(5)])
        @else
            @include('users._topics', [
              'topics' => $user->topics()->paginate(5)
            ])
        @endif

      </div>
    </div>

  </div>

</div>
@endsection
