
@if (count($errors)>0)
<div class="alert alert-danger">
  <div class="mt-2">有错误发生：</div>
  <ul class="mt-2 mb-2">
    @foreach ($errors->all() as $error)
      <li><i class="glyphicon glyphicon-remove"></i>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
