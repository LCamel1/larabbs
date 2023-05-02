<!DOCTYPE html>
<html lang="{{ str_replace('_', "-", app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title', "Larabbs")</title>

    @vite(['resources/js/app.js'])

  @yield('styles')
  </head>
  <body>
    <div id="app" class="{{ route_class() }}-page">
      @include('layouts._header', ['categories' => app(\App\Models\Category::class)->categories()])

      <div class="container">

        @include('shared._messages')

        @yield('content')
      </div>

       @include('layouts._footer')
    </div>

    @yield('scripts')
  </body>
</html>
