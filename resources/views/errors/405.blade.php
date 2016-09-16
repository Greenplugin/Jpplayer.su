@extends('common')

@section('content')
  <div class="about">
    <div class="uk-container uk-container-center">
      <h2 >Метод запрещен</h2>
      <h1 class="l-404">4 <span>0</span> 5</h1>
      <div class="uk-grid">
      <div class="uk-width-small-1-1 uk-width-medium-1-5 uk-width-large-1-5"></div>
      <div class="uk-width-small-1-1 uk-width-medium-3-5 uk-width-large-3-5">
        <h3 class="uk-center">Это значит что эта страница сервисная и лезть сюда не следует</h3>
      </div>
      <div class="uk-width-small-1-1 uk-width-medium-1-5 uk-width-large-1-5"></div>
      </div>
    </div>
  </div>

  <div class="faq" style="margin: 0">
    <div class="uk-container uk-container-center">
      <div class="uk-center">
        <div class="statistics">
          <h3>Немного статистики</h3>
          <div class="uk-grid">
            <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-2">
              <h5>Получено кодов разблокировки: </h5>
              <p><span>ERC</span><span></span><span>{{\App\Key::where('device_type', 'erc')->count()}}</span></p>
              <p><span>Clarion</span><span></span><span>{{\App\Key::where('device_type', 'Clarion')->count()}}</span>
              </p>
            </div>
            <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-2">
              <h5>зарегистрировано пользователей: </h5>
              <p><span>Email</span><span></span><span>{{\App\User::where('telegram_id', 0)->count()}}</span></p>
              <p><span>Telegram</span><span></span><span>{{\App\User::where('telegram_id','!=', 0)->count()}}</span></p>
            </div>
          </div>
          <p>Последний ключ получен для {{\App\Key::orderBy('created_at', 'desc')->first()->device_type}}
            : {{\App\Key::orderBy('created_at', 'desc')->first()->result}}</p>
        </div>
      </div>
      <div class="uk-grid faq-list" style="padding: 0; margin:0;">
        <div class="uk-width-1-1 faq-block">
          <h3>Куда Вы попали?</h3>
          <article style="text-align: justify">
            Вы попали на добрый сайт, который бесплатно разблокирует ГУ Clarion и штатные Toyota. Вы попали на эту страницу потому что каким-то образом вели неверный URL или перешли по устаревшей либо неверной ссылке.
            Чтож, ничего страшного, Если Вам нужно всего лишь получить код разблокировки, авторизуйтесь и получайте сколько угодно.
            <br>P.S. И не забудьте оставить “спасибо” на <strike>пиво/кофе</strike> оплату сервера.
          </article>
        </div>
      </div>
    </div>
  </div>
@endsection