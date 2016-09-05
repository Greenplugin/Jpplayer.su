@extends('common')

@section('content')

    <div class="about">
        <div class="uk-container uk-container-center">
            <div class="uk-grid grid-block">
                <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-2 about-block">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad animi blanditiis commodi consequatur cupiditate distinctio, eius error expedita explicabo id illum in ipsum iste itaque iure iusto labore, mollitia odit porro quaerat quas quis quo ratione repellendus repudiandae, suscipit tenetur ullam veniam voluptas voluptate. Architecto asperiores aspernatur autem beatae cum debitis deserunt distinctio, earum facere illum inventore iste laudantium magni molestias necessitatibus nesciunt placeat provident quaerat quia quis quisquam ratione repellendus sed sequi sint sit suscipit tempora ut vel voluptate? Error labore libero maiores optio quia quis quos similique sit sunt suscipit tempora, temporibus vel voluptas, voluptatem voluptatibus? Quos, sit?
                </div>

                <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-2">
                    <div class="about-block full-height form-block">
                        <form action="{{ url('/password/reset') }}" role="form" method="POST" class="registration-form">
                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="input-block{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input required id="email" name="email" type="text" value="{{ $email or old('email') }}">
                                <label for="email">Email</label>
                                <span></span>
                                @if ($errors->has('email'))
                                    <p class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </p>
                                @endif
                            </div>
                            <div class="input-block{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input required id="newPassword" type="password" name="password" value="">
                                <label for="newPassword">Новый пароль</label>
                                <span></span>
                                @if ($errors->has('password'))
                                    <p class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </p>
                                @endif
                            </div>
                            <div class="input-block{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <input required id="confirmPassword" type="password" name="password_confirmation" value="">
                                <label for="confirmPassword">Потвердите пароль</label>
                                <span></span>
                                @if ($errors->has('password_confirmation'))
                                    <p class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </p>
                                @endif
                            </div>
                            <div class="submit-div">
                                <button id="change-password-button">
                                    Сменить пароль
                                </button>
                            </div>
                        </form>

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