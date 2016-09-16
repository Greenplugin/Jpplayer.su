@extends('common')

@section('content')

    <div class="about">
        <div class="uk-container uk-container-center">
            <div class="uk-grid grid-block">
                <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-2 about-block">
                        Укажите E-mail от аккаунта у которого Вы забыли пароль. после нажатия на кнопку "восстановить пароль" Вам будет выслано письмо со ссылкой, перейдя по которой Вы сможете установить новый пароль. Ну и как обычно никому не сообщайте свои данные для входа.
                </div>
                <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-2">
                    <div class="about-block full-height form-block">
                        @if (session('status'))
                            <div class="registration-form uk-flex uk-flex-center uk-flex-middle uk-flex-column" style="height: 100%">
                                <div style="text-align: center">
                                    Вам на E-mail {{ old('email') }} должно прийти письмо со ссылкой для восстановления пароля
                                </div>
                                <div class="submit-div">
                                    <a href="/">Перейти на главную</a>
                                </div>
                            </div>
                        @else
                            <h3 style="margin:0">Восстановление пароля</h3>
                            <form method="POST" action="{{ url('/password/email') }}" class="registration-form">
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
                                <div class="submit-div">

                                    <button>
                                        Восстановить пароль
                                    </button>
                                </div>


                            </form>
                        @endif

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