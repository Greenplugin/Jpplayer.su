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