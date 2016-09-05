<!DOCTYPE html>
<html lang="ru" ng-app="jpPlayer">
<head>
  <meta charset="UTF-8">
  <title>JPplayer</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="/css/uikit.min.css">
  <link rel="stylesheet" href="/css/components/notify.min.css">
  <link rel="stylesheet" href="/css/components/notify.almost-flat.min.css">

  <link rel="stylesheet" href="/css/app.css">
  <script src="/js/jquery-3.1.0.min.js"></script>
</head>
<body >

<div id="mobile-menu" class="uk-offcanvas">
  <div class="uk-offcanvas-bar">
    <ul class="uk-nav">
      <li class="uk-active"><a href="/">Главная</a></li>
      <li><a href="/calc">Калькулятор</a></li>
      <li><a href="http://forum.jpplayer.su">Форум</a></li>
      <li><a href="/about">Авторы</a></li>
    </ul>
  </div>
</div>

<header>
  <div class="uk-container uk-container-center uk-flex uk-flex-center uk-flex-middle">
    <a href="/"><img class='logo-header' src="/img/logo.png" alt=""></a>
  </div>

  <a href="#mobile-menu" data-uk-offcanvas class="uk-navbar-toggle mobile-link uk-hidden-large"></a>

  @if (Auth::guest())
    <a href="/login" >
      <div class="register-block">
        <h3>Вход и регистрация</h3>
        <article>
          для использования калькулятора <br>
          необходима регистрация
        </article>
      </div>
    </a>
  @else
    {{--<a href="/profile">--}}
    <div data-uk-dropdown class="user-block-header">
      <div class=" uk-flex uk-flex-middle uk-flex-center">
        @if(Auth::user()->avatar)
        <div class="image-user" style="background-image: url({{ Auth::user()->avatar }});"></div>
        @else
        <div class="image-user" style="background-image: url(/img/small-logo.png);"></div>
        @endif
        <div class="user-caption">
          <h3 class="uk-text-left">{{ Auth::user()->name }}</h3>
          <article  class="uk-text-left">
            @if(Auth::user()->email)
              {{ Auth::user()->email }}
            @elseif(Auth::user()->telegram_username)
              {{ Auth::user()->telegram_username }}
            @elseif(Auth::user()->telegram_id)
              {{ Auth::user()->telegram_id }}
            @endif

          </article>
        </div>
      </div>
      <div class="uk-dropdown">
        <ul class="uk-nav uk-nav-dropdown">
          <li><a href="/profile">Профиль</a></li>
          <li><a href="/logout">Выйти</a></li>
        </ul>
      </div>
    </div>
    {{--</a>--}}

  @endif




</header>

<main>
  <div class="desktop-menu uk-visible-large">
    <div class="uk-container uk-container-center">
      <nav class="uk-navbar">
        <ul class="uk-navbar-nav">
          <li class="uk-active"><a href="/">Главная</a></li>
          <li><a href="/calc">Калькулятор</a></li>
          <li><a href="http://forum.jpplayer.su">Форум</a></li>
          <li><a href="/about">Авторы</a></li>
        </ul>
      </nav>
    </div>
  </div>

@yield('content')

</main>
<footer>
  <div class="uk-container uk-container-center">
    <div class="uk-grid">
      <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-2">
        <h3>Темы форума</h3>
        <ul>
          <li><a href="#">Калькуляторы и разблокировщики</a></li>
          <li><a href="#">Официальные прошивки</a></li>
          <li><a href="#">Разбор прошивок, кастомы</a></li>
          <li><a href="#">Русификация и локализация</a></li>
          <li><a href="#">Создание карт kwi</a></li>
          <li><a href="#">О железе</a></li>
        </ul>
      </div>
      <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-2">
        <h3>Темы форума</h3>
        <ul>
          <li><a href="#">Калькуляторы и разблокировщики</a></li>
          <li><a href="#">Официальные прошивки</a></li>
          <li><a href="#">Разбор прошивок, кастомы</a></li>
          <li><a href="#">Русификация и локализация</a></li>
          <li><a href="#">Создание карт kwi</a></li>
          <li><a href="#">О железе</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>


<script src="/js/angular.min.js"></script>
<script src="js/uikit.min.js"></script>
<script src="js/components/notify.js"></script>
<script src="js/angular_pagination.js"></script>
<script src="js/app.js"></script>


<script>

</script>
</body>
</html>