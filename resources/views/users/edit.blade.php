@extends('layouts.app')

@section('content')
<div class="col-md-8 offset-md-2">
<div class="card">
  <div class="card-header">
    <i class="glyphicon glyphicon-edit"></i> 编辑个人资料
  </div>
  <div class="card-body">
    <form class="" method="POST" action="{{ route('users.update', $user->id) }}" accept-charset="UTF-8" enctype="multipart/form-data">
      <input type="hidden" name="_method" value="PATCH" />
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />

      @include('shared._error')

      <div class="mb-3">
        <label for="name-field">用户名</label>
        <input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $user->name) }}" />
      </div>

      <div class="mb-3">
        <label for="email-field">邮箱</label>
        <input class="form-control" type="text" name="email" id="email-field" value="{{ old('email', $user->email) }}" />
      </div>

      <div class="mb-3">
        <label for="introduction-field">个人简介</label>
        <textarea name="introduction" id="introduction-field" class="form-control" rows="3">{{ old('introduction', $user->introduction) }}</textarea>
      </div>


      <div class="mb-3">
        <label for="avatar-field">用户头像</label>
        <input class="form-control" type="file" name="avatar" id="avatar-field"  />
        @if ($user->avatar)
        <br/>
        <img class="thumbnail img-responsive" src="{{ $user->avatar }}" width="200"/>
        @endif
      </div>

      <div class="well well-sm">
        <button type="submit" class="btn btn-primary">保存</button>
      </div>

    </form>
  </div>
</div>
</div>
@endsection
