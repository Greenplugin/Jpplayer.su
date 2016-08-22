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
                <div class="img-profile"></div>
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
                        <input required id="defaultpassword1" type="password" value="">
                        <label for="defaultpassword1">Email / Telegram Id</label>
                        <span></span>
                      </div>
                    </div>
                    <div class="uk-width-1-1">
                      <div class="uk-grid grid-no-margin">
                        <div class="uk-width-2-3 grid-no-margin">
                          <div class="input-block">
                            <input required id="newPasswor1d" type="password" value="">
                            <label for="newPasswor1d">Telegram Username</label>
                            <span></span>
                          </div>
                          <div class="input-block">
                            <input required id="confirmPassword1" type="password" value="">
                            <label for="confirmPassword1">Telegram id</label>
                            <span></span>
                          </div>
                        </div>
                        <div class="uk-width-1-3 grid-no-margin">
                          <button>
                            <img src="img/telegram-logo.png" alt="">
                            <p>Привязать</p>
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-1-1 grid-no-margin">
                      <div class="input-block">
                        <input required id="defaultpassword12" type="password" value="">
                        <label for="defaultpassword12">Имя</label>
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
                  <input type="checkbox" id="test1" />
                  <label for="test1">Использовать для входа телеграм</label>
                </p>
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


@endsection