@extends('common')

@section('content')
  <div class="about">
    <div class="uk-container uk-container-center">
      <h2>Используйте</h2>
      <div class="uk-grid grid-block">
        <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-2">
          <div class="profile-block form-block">
            <div class="uk-grid grid-no-margin">
              <div class="uk-width-small-1-3 uk-width-medium-1-3 uk-width-large-1-3">
                <div class="img-profile" style="background-image: url({{Auth::user()->avatar}})"></div>
              </div>
              <div class="uk-width-small-2-3 uk-width-medium-2-3 uk-width-large-2-3">
                <h3>{{Auth::user()->name}}</h3>
                <p></p>
                <table class="uk-table">
                  <tbody>
                  <tr>
                    <td>Разблокировок ERc</td>
                    <td>{{\App\Key::where(['user_id'=>Auth::user()->id, 'device_type' => 'erc'])->count()}}</td>
                  </tr>
                  <tr>
                    <td>Разблокировок Clarion</td>
                    <td>{{\App\Key::where(['user_id'=>Auth::user()->id, 'device_type' => 'clarion'])->count()}}</td>
                  </tr> <tr>
                    <td>Дата регистрации:</td>
                    <td>{{$regtime}}</td>
                  </tr>

                  </tbody>
                </table>
              </div>
              <div class="uk-width-1-1">
                <form action="" class="registration-form">
                  <div class="uk-grid grid-no-margin">
                    <div class="uk-width-1-1">
                      <div class="input-block">
                        <input required id="EmailField" type="text" value="{{Auth::user()->email}}">
                        <label for="EmailField">Email / Telegram Id</label>
                        <span></span>
                      </div>
                    </div>
                    <div class="uk-width-1-1">
                      <div class="uk-grid grid-no-margin">
                        <div class="uk-width-2-3 grid-no-margin">
                          <div class="input-block">
                            <input disabled="disabled" id="newPasswor1d" type="text" value="Telegram Username: {{Auth::user()->telegram_username}}">
                            <label for="newPasswor1d"></label>
                            <span></span>
                          </div>
                          <div class="input-block">
                            <input disabled="disabled"  id="confirmPassword1" type="text" value="Telegram id: {{Auth::user()->telegram_id}}">
                            <label for="confirmPassword1"></label>
                            <span></span>
                          </div>
                        </div>
                        <div class="uk-width-1-3 grid-no-margin">
                          <a class="uk-flex uk-flex-center uk-flex-middle uk-flex-column" href="#">
                            <img src="img/telegram-logo.png" alt="">
                            <p>Привязать</p>
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-1-1 grid-no-margin">
                      <div class="input-block">
                        <input required id="NameField" type="text" value="{{Auth::user()->name}}">
                        <label for="NameField">Имя</label>
                        <span></span>
                      </div>
                    </div>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-2">
          <div class="about-block full-height form-block">
            <form action="" class="registration-form">
              <div class="input-block">
                <input required id="defaultPassword" type="password" value="">
                <label for="defaultPassword">Текущий пароль</label>
                <span></span>
              </div>
              <div class="input-block">
                <input required id="newPassword" type="password" value="">
                <label for="newPassword">Новый пароль</label>
                <span></span>
              </div>
              <div class="input-block">
                <input required id="confirmPassword" type="password" value="">
                <label for="confirmPassword">Потвердите пароль</label>
                <span></span>
              </div>
              <div class="submit-div space-between">
                <p>
                  <input type="checkbox" id="use-telegram-for-change-password" />
                  <label data-href="" for="use-telegram-for-change-password">Использовать telegram </label>
                </p>
                <a id="change-password-button">
                  Сменить пароль
                </a>
              </div>
            </form>
            <article>
              <div>
                Для того чтобы сменить пароль заполните поля выше, если Вы регистрировались через telegram - поставьте галочку "Использовать telegram для смены пароля", введите новый пароль и нажмите кнопку "сменить пароль" Вас перекинет на сайт telegram, если Вы используете веб-версию telegram достаточно просто нажать "start" на месте чата бота, если вы используете мобильную или пк-версию telegram браузер предложит запустить приложение, согласитесь, откроется чат с ботом в telegram  где так же нужно нажать "start", на этом процедура смены пароля завершена.
              </div>

            </article>
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

  {{--{{dump($data)}}--}}
  <script>
    $(document).ready(function(){
      $('#use-telegram-for-change-password').change(function () {
        $('#defaultPassword').prop("disabled",$(this).is(':checked')).val('');
      });

      $('#change-password-button').click( function () {

        if ($('#use-telegram-for-change-password').is(':checked')) {

        } else{

        }

      });

      $('#EmailField').change(function () {
        saveField('email',$(this).val(),$(this));
      });

      $('#NameField').change(function () {
        saveField('name',$(this).val(),$(this));
      });

    });

    function saveField(field, value, obj) {
      var data = {'_token': '{{csrf_token()}}'};
      data[field] = value;
      $.ajax({
        url: '/save/'+field,
        type: 'POST',
        data: data,
        dataType: 'json',
        error: function(err) {
          UIkit.notify({
            message : 'Критическая ошибка сети, проверьте соединение с интернетом',
            status  : 'danger',
            timeout : 5000,
            pos     : 'bottom-right'
          });
          obj.focus();
        },
        success: function(result) {
          UIkit.notify({
            message : result.reason,
            status  : result.result,
            timeout : 5000,
            pos     : 'bottom-right'
          });
          if(!result.code){
            obj.focus();
          }

        }
      });
    }
  </script>

@endsection