@extends('common')

@section('content')
    <div class="about">
      <div class="uk-container uk-container-center">
        <h2>Используйте</h2>
        <div class="uk-grid grid-block">
          <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-2">
            <div class="about-block">
              <div class="uk-grid">
                <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-3 uk-flex uk-flex-center uk-flex-middle">
                  <img src="img/telegram-logo.png" alt="">
                </div>
                <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-2-3">
                  <article>
                    <h3>В Telegram</h3>
                    У нас есть Telegram бот, который может выдавать Вам ключики прямо в мессенджер, кстати регистрируяс на сайте через Telegram, вы получите пять разблокировок для clarion вместо трех при обычной регистрации
                  </article>
                </div>
              </div>
            </div>
          </div>
          <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-2">
            <div class="about-block">
              <div class="uk-grid">
                <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-3 uk-flex uk-flex-center uk-flex-middle">
                  <img src="img/small-logo.png" alt="">
                </div>
                <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-2-3">
                  <article>
                    <h3>На сайте</h3>
                    После регистрации Вы сможете разблокировать любое количество устройств по ERC коду а так же некоторое количество устройств Clarion.
                  </article>
                </div>
              </div>
            </div>
          </div>
        </div>

        <h3 class="post-title uk-text-center">Бесплатно и без ограничений <span>*</span></h3>
        <h5>Без ограничений Вы сможете разблокировать любое количество устройств по ERC коду, на устройства Clarion существуют ограничения для обычного аккаунта 3 ключа и для telegram аккаунта 5 ключей</h5>
      </div>
    </div>

    <div class="faq">
      <h2 class="main-title">F.A.Q</h2>
      <div class="uk-container uk-container-center">
        <div class="uk-grid faq-list">
          <div class="uk-width-1-1 faq-block">
            <h3>Что это за сайт?</h3>
            <article>
              На этом сайте можно разблокировать штатные головные устройства Toyota, а так же с недавнего времени мультимедийные устройства Clarion.
            </article>
          </div>
          <div class="uk-width-1-1 faq-block">
            <h3>Сколько это стоит?</h3>
            <article>
              Нисколько. После регистрации Вы можете получить столько кодов, сколько нужно.
            </article>
          </div>
          <div class="uk-width-1-1 faq-block">
            <h3>Какие модели этот калькулятор может разблокировать?</h3>
            <article>
              Этот калькулятор был протестирован с несколькими десятками разных штатных головных устройств Toyota. Поддержка Clarion должна быть полной, но бывают исключения.
            </article>
          </div>
          <div class="uk-width-1-1 faq-block">
            <h3>Какие Вы предоставляете гарантии?</h3>
            <article>
              Никаких. Сайт и бот генерируют коды разблокировки, можете использовать, а можете закрыть страничку и поехать в ближайший сервис-центр.
            </article>
          </div>
          <div class="uk-width-1-1 faq-block">
            <h3>С чего начать?</h3>
            <article>
              Для головных устройств Toyota нужно получить ERC код, подробнее можете найти информацию на нашем форуме.
              <br>
              Для медиаустройств Clarion нужен файл (название файла), как ео получить, Вы можете прочитать на нашем формуе.
            </article>
          </div>
          <div class="uk-width-1-1 faq-block">
            <h3>Как русифицировать?</h3>
            <article>
              На данный момент участники форума ведут работу над русификацией в закрытых разделах форума, следите за новостями.
            </article>
          </div>
          <div class="uk-width-1-1 faq-block">
            <h3>А как..?</h3>
            <article>
              На большинство вопросов, которые Вы захотите задать, есть ответы на форуме, если на там у Вас не получается найти нужную информацю, всегда можно спросить, регистрация открытая.
            </article>
          </div>
          <div class="uk-width-1-1 faq-block">
            <h3>Что я могу для Вас сделать?</h3>
            <article>
              Вы можете:
              <ul>
                <li>Делиться своими наработками</li>
                <li>Сообщать об ошибках</li>
                <li>Участвовать в обсуждениях на форуме</li>
                <li>Сделать пожартвование</li>
              </ul>
            </article>
          </div>
        </div>
      </div>
    </div>

    <div class="donat">
      <h2 class="main-title">Поддержите развитие проекта</h2>
      <div class="uk-container uk-container-center">
        <div class="donat-article">
          <article>
            Все наработки сделаны участниками форума. Чтобы внести <br>
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