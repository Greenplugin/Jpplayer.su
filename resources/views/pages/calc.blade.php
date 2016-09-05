@extends('common')

@section('content')
  <div class="about" ng-controller="Calc">
    <div class="uk-container uk-container-center">
      <h2>Калькулятор</h2>
      <div class="uk-grid grid-block">
        <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-1">
          <div class="about-block full-height form-block">
            <ul class="form-switcher" data-uk-switcher="{connect:'#forms'}">
              <li><a href="">Erc</a></li>
              <li><a href="">Clarion</a></li>
            </ul>
            <ul id="forms" class="uk-switcher">
              <li>
                <form action="" class="registration-form full-width">
                  <div class="uk-grid">
                    <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-3-4">
                      <div class="input-block">
                        <input required id="ercCode" type="text" value="">
                        <label for="ercCode">ERC код</label>
                        <span></span>
                      </div>
                    </div>
                    <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4">
                      <div class="submit-div">
                        <button class="full-width" id="submitErc">
                          Получить код
                        </button>
                      </div>
                    </div>
                    <div class="uk-width-1-1">
                      <div class="code-article">
                        <article class="code-caption">Код разблокировки: </article>
                        <article>0369</article>
                        <article>3695</article>
                      </div>
                    </div>
                  </div>
                </form>
              </li>
              <li>
                <form action="" class="registration-form full-width">
                  <div class="uk-grid">
                    <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-1">
                      <div class="file-upload upload">
                        <div class="static-file">
                          <h3>Выберите файл или перетащите его сюда</h3>
                          <p>Осталось разблокировок: 3</p>
                        </div>
                        <div class="file-drag">
                          <h3>Выберите файл или перетащите его сюда</h3>
                          <p>Осталось разблокировок: 3</p>
                        </div>
                        <div class="file-ready">
                          <div class="uk-grid">
                            <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-3-4">
                              <h3>шindows.exe - файл некоректный. </h3>
                              <p>Осталось разблокировок: 3</p>
                            </div>
                            <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4">
                              <button>
                                Получить код
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-1-1">
                      <div class="code-article">
                        <article class="code-caption">Код разблокировки: </article>
                        <article>0369</article>
                      </div>
                    </div>
                  </div>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="table-result" ng-controller="History">
    <div class="uk-container uk-container-center">
      <div class="body-table">
        <h3>История</h3>
        <div class="uk-overflow-container">
          <table class="uk-table k-table-condensed">
            <thead>
            <tr>
              <th ng-click="sort('created_at')" >Дата и время
                <i class="" ng-show="sortKey=='created_at'" ng-class="{'uk-icon-sort-amount-asc':reverse,'uk-icon-sort-amount-desc':!reverse}"></i></th>
              <th ng-click="sort('device_type')" >Тип ключа
                <i class="" ng-show="sortKey=='device_type'" ng-class="{'uk-icon-sort-amount-asc':reverse,'uk-icon-sort-amount-desc':!reverse}"></i></th></th>
              <th ng-click="sort('app_type')" >Приложение
                <i class="" ng-show="sortKey=='app_type'" ng-class="{'uk-icon-sort-amount-asc':reverse,'uk-icon-sort-amount-desc':!reverse}"></i></th></th>
              <th ng-click="sort('input_data')" >Исходные данные
                <i class="" ng-show="sortKey=='input_data'" ng-class="{'uk-icon-sort-amount-asc':reverse,'uk-icon-sort-amount-desc':!reverse}"></i></th></th>
              <th ng-click="sort('result')" >Ключ
                <i class="" ng-show="sortKey=='result'" ng-class="{'uk-icon-sort-amount-asc':reverse,'uk-icon-sort-amount-desc':!reverse}"></i></th></th>
            </tr>
            </thead>
            <tbody>
       {{--     @foreach($histories as $key=>$entity) ---}}
            <tr dir-paginate="row in rows|orderBy:sortKey:reverse|itemsPerPage:10">
              <td>@{{row.created_at}}</td>
              <td>@{{row.device_type}}</td>
              <td>@{{row.app_type}}</td>
              <td>@{{row.input_data}}</td>
              <td>@{{row.result}}</td>
            </tr>
          {{---@endforeach--}}
            </tbody>
          </table>
          <dir-pagination-controls
                  max-size="5"
                  direction-links="true"
                  boundary-links="true" >
          </dir-pagination-controls>
          {{--@include('partials.pagination', ['paginator' => $histories])--}}
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