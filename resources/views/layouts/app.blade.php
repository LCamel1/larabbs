<!DOCTYPE html>
<html lang="{{ str_replace('_', "-", app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', "Larabbs")</title>
  </head>
  <body>
    <div id="app">
      @include('layouts._header')

      @include('shared._message')

      @yield('content')

       @include('layouts._footer')
    </div>
  </body>
</html>
