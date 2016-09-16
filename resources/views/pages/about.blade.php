@extends('common')

@section('content')
    <div class="about">
      <div class="uk-container uk-container-center">
        <h2>Об авторах</h2>
        <h5>К тому чтобы этот сайт появился на свет приложили руку немало людей. Программисты и вдохновители, участники нашего форума, форума toyota-club участники форума drom. А так же блогеры которые писали о нашем старом сайте, что и стало толчком сделать полное обновление.</h5>
      </div>
    </div>

    <div class="faq" style="margin: 0">
      <div class="uk-container uk-container-center">

        <div class="uk-grid faq-list" style="padding: 0; margin:0;">
          <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-2 faq-block">
            <h3>Алгоритм Clarion</h3>
            <article>
              <ul>
                <li>x27</li>
              </ul>
            </article>
          </div>
          <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-2 faq-block">
            <h3>Алгоритм Erc</h3>
            <article>
              <ul>
                <li>eraser19rus</li>
                <li>Пользователи форума Drom</li>
              </ul>
            </article>
          </div>
        </div>

        <div class="uk-grid faq-list" style="padding: 0; margin:0;">
            <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-2 faq-block">
              <h3>Разработка сайта</h3>
              <article>
                <ul >
                  <li>Dobro</li>
                  <li>Greenplugin</li>
                  <li>GoshanFloyd</li>
                </ul>
              </article>
            </div>
            <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-2 faq-block">
              <h3>Telegram бот</h3>
              <article>
                <ul>
                  <li>Dobro</li>
                  <li>Greenplugin</li>
                </ul>
              </article>
            </div>
        </div>

        <div class="uk-grid faq-list" style="padding: 0; margin:0;">
          <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-2 faq-block">
              <h3>Идея</h3>
              <article>
                <ul>
                  <li>Dobro</li>
                  <li>turboleo</li>
                </ul>
              </article>
          </div>
          <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-2 faq-block">
            <h3>Портирование алгоритмов</h3>
            <article>
              <ul>
                <li>Edge</li>
                <li>Dobro</li>
              </ul>
            </article>
          </div>
        </div>

      </div>
    </div>

    <div class="donat">
      <div class="uk-container uk-container-center">
        <div class="donat-article">
          <div class="uk-width-1-1"><h3 class="uk-center">Все что Вы видете, делалось бесплатно и отдавалось даром, Если Вы хотите чтоы этот ресурс продолжал свое существование, и чтобы нам было чем заплатить за сервер, пожертвуйте немного денег. </h3></div>
          @include('partials.donateForm') <br>
          <div class="uk-width-1-1"><p class="uk-center">Можете перевети пожертвование напрямую на Qiwi. Номер Qiwi кошелька: +7(707)402-31-33</p></div>
        </div>

      </div>
    </div>
@endsection