<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">学习论坛</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarText">
      <ul class="navbar-nav mr-auto">
       <li class="nav-item">
        <a class="nav-link {{ empty($category) ? 'active' : '' }}" href="{{ route('topics.list', ['i']) }}">话题</a>
       </li>

       @foreach ($categories as $item)
          <li class="nav-item">
        <a class="nav-link {{(!empty($category) && ($category->id ==$item->id)) ? 'active' : ''}}" href="{{ route('topics.list', ['c' ,$item->id]) }}">{{ $item->name }}</a>
       </li>
       @endforeach


      </ul>

      <ul class="navbar-nav narbar-right">
        @guest
         <li class="nav-item">
         <a class="nav-link" href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket"></i> 登录</a>
        </li>
        <li class="nav-item">
         <a class="nav-link" href="{{ route('register') }}"><i class="fa-solid fa-user-plus"></i> 注册</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link mt-1 mr-3" href="{{ route('topics.create')}}">
            <i class="fa-solid fa-plus"></i>
          </a>
        </li>

        <li class="nav-item notification-badge">
          <a class="nav-link ms-3 me-3 badge bg-secondary rounded-pill badge-{{ (Auth::user()->notification_count > 0) ? 'hint' : 'secondary' }}  text-white" href="{{ route('notifications.index') }}">
            {{ Auth::user()->notification_count }}
          </a>
        </li>

         <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

            @if (Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar }}" class="img-responsive img-circle" style="border-radius: 500rem;" width="30px" height="30px">
            @else
                <i class="fas fa-user-astronaut" style="font-size: 1.2rem; color: cornflowerblue;" ></i>
            @endif

            {{ Auth::user()->name }}
          </a>
          <ul class="dropdown-menu">
             @can('manage_contents')
                <li><a class="dropdown-item" href="{{ url(config('administrator.uri')) }}">
                  <i class="fas fa-tachometer-alt mr-2"></i>
                  管理后台
                </a></li>
                <hr class="dropdown-divider">
              @endcan
            <li><a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">个人中心</a></li>
            <li><a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }}">编辑资料</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item" href="#">
                <form action="{{ route('logout') }}"  method="post">
                  {{ csrf_field() }}
                  <button type="submit" class="btn  btn-danger">退出</button>
                </form>
              </a>
            </li>
          </ul>
        </li>


        @endguest
      </ul>

    </div>

  </div>
</nav>
