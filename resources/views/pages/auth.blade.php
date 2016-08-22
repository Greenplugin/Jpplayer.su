@extends('common')

@section('content')

    <div class="about">
      <div class="uk-container uk-container-center">
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
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aliquid asperiores aut, corporis culpa dolores eos explicabo, harum id iusto laudantium minima odit placeat quos repudiandae similique ut velit voluptatum.
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
                  },1000)
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
                  <article>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aliquid asperiores aut, corporis culpa dolores eos explicabo, harum id iusto laudantium minima odit placeat quos repudiandae similique ut velit voluptatum.
                    <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam consequuntur
                      doloribus mollitia nam voluptates. Adipisci aspernatur assumenda at commodi
                      culpa cumque debitis, itaque magnam nobis non officia similique veniam,
                      voluptatem?</div>
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
                  <form action="{{ url('/register') }}" class="registration-form">
                    {{ csrf_field() }}
                    <div class="input-block {{ $errors->has('email') ? ' has-error' : '' }}">
                      <input required id="regemail" type="text" value="">
                      <label for="regemail">Email</label>
                      <span></span>
                      @if ($errors->has('email'))
                        <p class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </p>
                      @endif
                    </div>
                    <div class="input-block {{ $errors->has('email') ? ' has-error' : '' }}">
                      <input required id="name" type="text" value="">
                      <label for="name">Имя</label>
                      <span></span>
                      @if ($errors->has('name'))
                        <p class="help-block">
                          <strong>{{ $errors->first('name') }}</strong>
                        </p>
                      @endif
                    </div>
                    <div class="input-block {{ $errors->has('password') ? ' has-error' : '' }}">
                      <input required id="password" type="password" value="">
                      <label for="password">Пароль</label>
                      <span></span>
                      @if ($errors->has('password'))
                        <p class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </p>
                      @endif
                    </div>
                    <div class="input-block {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                      <input required id="passwordsecond" type="password" value="">
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
                        Вход
                      </button>
                    </div>
                  </form>
                  <article>
                    <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab cum illum incidunt
                      nesciunt odit ratione voluptates voluptatibus? Blanditiis, porro, sequi. Alias
                      hic laborum optio quaerat quia repudiandae sunt vel voluptates?
                    </div>
                    <div>A delectus deserunt, ex expedita iste, maxime nemo pariatur quae quaerat qui,
                      sunt tenetur vel veritatis. Doloremque minus modi numquam provident suscipit.
                      Animi corporis cupiditate ducimus eaque laboriosam laborum quasi.
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
                    <div class="submit-div">
                      <button>
                        Вход
                      </button>
                    </div>
                  </form>
                  <article>
                    <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab cum illum incidunt
                      nesciunt odit ratione voluptates voluptatibus? Blanditiis, porro, sequi. Alias
                      hic laborum optio quaerat quia repudiandae sunt vel voluptates?
                    </div>
                    <div>A delectus deserunt, ex expedita iste, maxime nemo pariatur quae quaerat qui,
                      sunt tenetur vel veritatis. Doloremque minus modi numquam provident suscipit.
                      Animi corporis cupiditate ducimus eaque laboriosam laborum quasi.
                    </div>
                  </article>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="donat">
      <h2 class="main-title">Поддержите развитие проекта</h2>
      <div class="uk-container uk-container-center">
        <div class="donat-article">
          <article>
            Все наработки сделаны участниками форума. Чтобы вынести <br>
            свою лепту в развитие проекта учавствуйте в обсуждениях, <br>
            делитесь своими наработками.
          </article>
          <article>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum iure minima nihil perferendis possimus quis, ratione voluptatum? Aspernatur dicta id, ipsum laborum magni modi soluta, sunt tempore ut velit, voluptates.
          </article>
        </div>
      </div>
    </div>
@endsection