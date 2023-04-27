<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">学习论坛</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarText">
      <ul class="navbar-nav mr-auto">
       <li class="nav-item">
        <a class="nav-link" href="#">话题</a>
       </li>
       <li class="nav-item">
        <a class="nav-link" href="#">分享</a>
       </li>
       <li class="nav-item">
        <a class="nav-link" href="#">教程</a>
       </li>
       <li class="nav-item">
        <a class="nav-link" href="#">问答</a>
       </li>
       <li class="nav-item">
        <a class="nav-link" href="#">公告</a>
       </li>
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
         <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

            @if (Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar }}" class="img-responsive img-circle" width="20px" height="20px">
            @else
                <i class="fas fa-user-astronaut" style="font-size: 1.2rem; color: cornflowerblue;" ></i>
            @endif

            {{ Auth::user()->name }}
          </a>
          <ul class="dropdown-menu">
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
