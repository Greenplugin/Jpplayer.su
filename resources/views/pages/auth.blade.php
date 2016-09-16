@extends('common')

@section('content')

    <div class="about">
      <div class="uk-container uk-container-center">
        <h2>Вход и регистрация</h2>
        <div class="uk-grid grid-block">
          <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-2">
            <a id="tgButton" href="https://telegram.me/jpllayer_bot?start={{$telegram_key}}" target="_blank">
              <div class="about-block">
                <div class="uk-grid">
                  <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-3 uk-flex uk-flex-center uk-flex-middle">
                    <img src="img/telegram-logo.png" alt="">
                  </div>
                  <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-2-3">

                      <article>
                        <h3>В Telegram</h3>
                        Просто перейдите по ссылке, добавьте Telegram бота и Вы автоматически будете зарегистрированы на сайте, а так же сможете пользоваться калькулятором прямо в Telegram.
                      </article>

                  </div>
                </div>
              </div>
            </a>

            <script>
              $(document).ready(function () {
                var tgKey = '{{$telegram_key}}';

                //if(!localStorage.getItem('tgKey')) {
                  //localStorage.setItem('tgKey', '{{$telegram_key}}');
                  //tgKey = '{{$telegram_key}}';
                //} else {
                  //tgKey = localStorage.getItem('tgKey')
                //}
                getAuth(tgKey);

                $('#tgButton').click(function () {
                  //localStorage.setItem('tgKey', '{{$telegram_key}}');
                  tgKey = '{{$telegram_key}}';
                  var recounter = setInterval(function (e) {
                    getAuth(tgKey);
                  },1000);
                });
                });

              function getAuth(tgKey){
                $.ajax({
                  url: '/shadow/auth',
                  type: 'POST',
                  data: {'auth_token': tgKey, '_token': '{{csrf_token()}}'},
                  dataType: 'text',
                  error: function(err) {
                    console.info(err);
                  },
                  success: function(result) {
                    //console.info(result);
                    console.info(result);
                    if(result == tgKey) {
                      location.reload();
                    }
                  }
                });
              }
            </script>

            <div class="about-block second-about">
              <div class="uk-grid">
                <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-1">
                  <article style="text-align: justify;">
                    Используя Telegram для регистрации Вы обеспечиваете себе удобный способ получать ключи прямо в mesenger, а так же увеличивается лимит на получение кодов для clarion до 5.
                    Аккаунты зарегистрированные с помощью Telegram полностью соответствуют обычной регистрации. <br>
                    История получения ключей сохраняется в обоих видах аккаунтов. <br>
                    После регистрации Вы можете установить E-mail и входить на сайт обычным образом. <br>
                  </article>
                </div>
              </div>
            </div>
          </div>
          <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-2">
            <div class="about-block full-height form-block">
              <ul class="form-switcher" data-uk-switcher="{connect:'#forms',active:{{$active}}}">
                <li><a href="">Зарегистрироваться</a></li>
                <li><a href="">Войти</a></li>
              </ul>
              <ul id="forms" class="uk-switcher">
                <li>
                  <form action="{{ url('/register') }}" method="POST" class="registration-form">
                    {{ csrf_field() }}
                    <div class="input-block {{ $errors->has('email') ? ' has-error' : '' }}">
                      <input required id="regemail" name="email" type="text" value="{{ old('email') }}">
                      <label for="regemail">Email</label>
                      <span></span>
                      @if ($errors->has('email'))
                        <p class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </p>
                      @endif
                    </div>
                    <div class="input-block {{ $errors->has('email') ? ' has-error' : '' }}">
                      <input required id="name" name="name" type="text" value="{{ old('name') }}">
                      <label for="name">Имя</label>
                      <span></span>
                      @if ($errors->has('name'))
                        <p class="help-block">
                          <strong>{{ $errors->first('name') }}</strong>
                        </p>
                      @endif
                    </div>
                    <div class="input-block {{ $errors->has('password') ? ' has-error' : '' }}">
                      <input required id="password" name="password" type="password" value="{{ old('password') }}">
                      <label for="password">Пароль</label>
                      <span></span>
                      @if ($errors->has('password'))
                        <p class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </p>
                      @endif
                    </div>
                    <div class="input-block {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                      <input required id="passwordsecond" name="password_confirmation" type="password" value="{{ old('password_confirmation') }}">
                      <label for="passwordsecond">Повторите пароль</label>
                      <span></span>
                      @if ($errors->has('password_confirmation'))
                        <p class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </p>
                      @endif
                    </div>
                    <div class="submit-div">
                      <button id="submit">
                        Зарегистрироваться
                      </button>
                    </div>
                  </form>
                  <article>
                    <div style="text-align: justify">Используя сайт Вы даете согласие на сбор статистики и хранение истории сгенерированных ключей.
                      <br>
                      А так же подтверждаете, что администрация сайта не несет ответсвенности за испорченные вашими дествиями устройства, истраченные нервы и
                      <span style="text-decoration: line-through">загубленные жизни</span>.
                    </div>
                  </article>
                </li>
                <li>
                  <form method="POST" action="{{ url('/login') }}" class="registration-form">
                    {{ csrf_field() }}
                    <div class="input-block {{ $errors->has('email') ? ' has-error' : '' }}">
                      <input required id="emailEnter" type="text" name="email" value="{{ old('email') }}">
                      <label for="emailEnter">Email</label>
                      <span></span>
                      @if ($errors->has('email'))
                        <p class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </p>
                      @endif
                    </div>
                    <div class="input-block {{ $errors->has('password') ? ' has-error' : '' }}">
                      <input required id="passwordEnter" type="password" name="password" value="">
                      <label for="passwordEnter">Пароль</label>
                      <span></span>
                      @if ($errors->has('password'))
                        <p class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </p>
                      @endif
                    </div>
                    <div class="uk-grid uk-grid-width-medium-1-2 no-margin-grid">
                      <div>
                        <p>
                          @if(old('remember'))
                            <input type="checkbox" id="remember" checked name="remember" />
                          @else
                            <input type="checkbox" id="remember" name="remember" />
                          @endif
                          <label  for="remember">Запомнить меня</label>
                        </p>
                        <a class="btn btn-link" href="{{ url('/password/reset') }}">Забыли пароль?</a>
                      </div>
                      <div class="submit-div">

                        <button>
                          Вход
                        </button>
                      </div>
                    </div>

                  </form>
                  <article>
                    <div style="text-align: justify">Используя сайт Вы даете согласие на сбор статистики и хранение истории сгенерированных ключей.
                      <br>
                      А так же подтверждаете, что администрация сайта не несет ответсвенности за испорченные вашими дествиями устройства, истраченные нервы и
                      <span style="text-decoration: line-through">загубленные жизни</span>.
                    </div>
                  </article>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>


    @include('partials.donate');
@endsection