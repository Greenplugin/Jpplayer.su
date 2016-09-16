@extends('common')

@section('content')
  <div class="about">
    <div class="uk-container uk-container-center">
      <h2>Профиль</h2>
      <div class="uk-grid grid-block">
        <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-2">
          <div class="profile-block form-block">
            <div class="uk-grid grid-no-margin">
              <div class="uk-width-small-1-3 uk-width-medium-1-3 uk-width-large-1-3">
                  <form name="uploadForm">
                      @if(Auth::user()->avatar)
                          <div class="img-profile" style="background-image: url({{Auth::user()->avatar}})"><label for="uploadInput" class="edit-avatar" id="editAvatar"><i class="uk-icon-cloud-upload"></i></label></div>
                      @else
                          <div class="img-profile" style="background-image: url(/img/small-logo.png);"><label for="uploadInput" class="edit-avatar" id="editAvatar"><i class="uk-icon-cloud-upload"></i></label></div>
                      @endif
                      <input  hidden id="uploadInput" type="file" name="myFiles" onchange="uploadImages(this.files);" multiple>
                  </form>

              </div>
              <div class="uk-width-small-2-3 uk-width-medium-2-3 uk-width-large-2-3">
                  @if($child_user)
                    <h3>{{Auth::user()->name}} <i class="uk-icon-users"></i></h3>
                  @else
                    <h3>{{Auth::user()->name}}</h3>
                  @endif
                <p></p>
                <table class="uk-table">
                  <tbody>
                  <tr>
                    <td>Разблокировок ERc</td>
                    <td>{{\App\Key::where(['user_id'=>Auth::user()->id, 'device_type' => 'erc'])->count()}} / ∞</td>
                  </tr>
                  <tr>
                    <td>Разблокировок Clarion</td>
                    <td>{{\App\Key::where(['user_id'=>Auth::user()->id, 'device_type' => 'clarion'])->count()}} / {{Auth::user()->unlocks}}</td>
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
                        @if(Auth::user()->telegram_id)
                        <div class="uk-width-1-1 grid-no-margin">
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
                        @else
                        <div class="uk-width-1-1 grid-no-margin">
                          <a id="addTelegramToAccount" class="uk-flex" href="#">
                            <img src="img/telegram-logo.png" alt="">
                            <p>Привязать Telegram <span>При привязке существующего telegram аккаунта количество разблокировок clarion оставшееся в двух аккаунтах, сложится. при привязке нового telegram аккаунта Вы получите еще 5 разблокировок</span></p>
                          </a>
                        </div>
                        @endif
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
              </div>
                <a class="custom-button" id="change-password-button">
                    Сменить пароль
                </a>
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


  @include('partials.donate');


  {{--{{dump($data)}}--}}
  <script>
      var csrf_token = '{{csrf_token()}}';
    $(document).ready(function(){
      $('#use-telegram-for-change-password').change(function () {
        $('#defaultPassword').prop("disabled",$(this).is(':checked')).val('');
      });

      $('#EmailField').change(function () {
        saveField('email',$(this).val(),$(this));
      });

      $('#NameField').change(function () {
        saveField('name',$(this).val(),$(this));
      });

      $('#change-password-button').click( function () {
        var password =  $('#newPassword');
        if(password.val().length < 6){
          UIkit.notify({
            message : 'Пароль не может быть короче 6 символов',
            status  : 'danger',
            timeout : 5000,
            pos     : 'bottom-right'
          });
          password.focus();
        }else{
          var confirm = $('#confirmPassword');
          if(confirm.val() !== password.val()){
            UIkit.notify({
              message : 'Пароли не совпадают',
              status  : 'danger',
              timeout : 5000,
              pos     : 'bottom-right'
            });
            confirm.focus();
          }else{
            if ($('#use-telegram-for-change-password').is(':checked')) {
              window.open('https://telegram.me/jpllayer_bot?start=_p{{$telegram_key}}', '_blank');
              var recounter;
              recounter = setInterval(function (e) {
                changeTelegramPassword(password.val(), confirm.val(),recounter);
              },1000);
            } else{
                var defPassword = $('#defaultPassword');
                if(defPassword.val().length < 3){
                  UIkit.notify({
                    message : 'У Вас не может быть такого короткого пароля! Не зачем утруждать сервер, введите свой пароль.',
                    status  : 'danger',
                    timeout : 5000,
                    pos     : 'bottom-right'
                  });
                }else{
                  saveField('passwordDefault',false,password,function(e){
                    console.info(e);
                  },{
                    'defaultPassword': defPassword.val(),
                    'newPassword': password.val(),
                    'confirmPassword': confirm.val()
                  });
                }
            }
          }
        }
      });

      $('#addTelegramToAccount').click(function (e) {
          e.preventDefault();
        $.ajax({
          url: '/save/get-telegram-binding-link',
          type: 'GET',
          dataType: 'json',
          error: function(err) {
            console.info(err);
          },
          success: function(result) {
            //console.info(result);
            console.info(result.code);
            UIkit.notify({
              message : result.reason,
              status  : result.result,
              timeout : 0,
              pos     : 'bottom-right'
            });
            if(result.code) {
               setInterval(function () {
                   $.ajax({
                       url: '/save/get-telegram-binding-done',
                       type: 'GET',
                       dataType: 'json',
                       error: function(err) {
                           console.info(err);
                       },
                       success: function(result) {
                           if(result.code) {
                               location.reload();
                           }
                       }
                   });
               }, 2000)
            }
          }
        });
          return false;
      });

    });

    function saveField(field, value, obj, callback,dat) {
      var data ={};
      if(!value){
        data = dat;
      }else{
        data[field] = value;
      }
      data['_token'] = '{{csrf_token()}}';

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
          if(callback){
            callback(result);
          }
        }
      });
    }

    function changeTelegramPassword(password, retype, counter){
      $.ajax({
        url: '/save/passwordTelegram',
        type: 'POST',
        data: {'newPassword': password, 'confirmPassword': retype, '_token': '{{csrf_token()}}'},
        dataType: 'json',
        error: function(err) {
          UIkit.notify({
            message : 'Критическая ошибка сети, проверьте соединение с интернетом',
            status  : 'danger',
            timeout : 5000,
            pos     : 'bottom-right'
          });
        },
        success: function(result) {
          //console.info(result);
          console.info(result.code);
          if(result.code) {
            clearInterval(counter);
            UIkit.notify({
              message : result.reason,
              status  : result.result,
              timeout : 0,
              pos     : 'bottom-right'
            });
          }
        }
      });
    }

    function uploadImages(files) {
        console.info(files);
        var file = files[0];
        $('#uploadInput').val('');
        if(file.size > 1048576){
            UIkit.notify({
                message : 'Максимальный размер картинки может быть 1мб',
                status  : 'danger',
                timeout : 5000,
                pos     : 'bottom-right'
            });
        } else{
            if(file.type === 'image/png' || file.type === 'image/jpg' || file.type === 'image/jpeg'){
                var fd = new FormData;
                fd.append('avatar', file);
                fd.append('_token', csrf_token);

                $.ajax({
                    url: '/profile/new-avatar',
                    data: fd,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        console.info(data);
                        if(data.code === 0){
                           $('.img-profile').css('background-image', 'url(' + data.image + ')');
                           $('.image-user').css('background-image', 'url(' + data.image + ')');
                        }

                        UIkit.notify({
                            message : data.reason,
                            status  : data.result,
                            timeout : 5000,
                            pos     : 'bottom-right'
                        });


                    }

                });

            }else{
                UIkit.notify({
                    message : 'Разрешены только файлы png и jpg',
                    status  : 'danger',
                    timeout : 5000,
                    pos     : 'bottom-right'
                });
            }
        }
    }

  </script>

@endsection