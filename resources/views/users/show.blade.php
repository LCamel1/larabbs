@extends('layouts.app')
@section('title', $user->name.'的个人中心')

@section('content')
<div class="row">
  <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
    <div class="card">
      <img src="#" class="card-img-top" alt="{{ $user->name }}">
      <div class="card-body">
       <h5 class="card-title">个人中心</h5>
       <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
       <hr />
       <h5 class="card-title">注册于</h5>
       <p class="card-text">{{ $user->create_at }}</p>
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
        暂无数据！
      </div>
    </div>

  </div>

</div>
@endsection
