@extends('common')

@section('content')
    <script>

        $(document).ready(function() {
            angular.module("jpPlayer").constant("CSRF_TOKEN", '{{csrf_token()}}');
            jQuery(function($) {

                $('#main-drop-zone').click(function () {
                   $('#clarionInput').click();
                });

                /*маскировка поля erc*/
                $elem = $('#ercCode');
                $.mask.definitions['x']='[A-Fa-f0-9]';
                $elem.mask('xxxx xxxx xxxx xxxx', {
                    autoclear: true,
                    placeholder: '-',
                    completed:function(){
                        $elem.trigger('change');
                    }
                });
                $elem.blur(function () {
                    $elem.trigger('change');
                })

            });
        });


    </script>
    <div ng-controller="Calc">
        <div class="about" >
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
                                    <div class="registration-form full-width">
                                        <div class="uk-grid">
                                            <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-3-4">
                                                <div class="input-block">
                                                    <input required ng-change="update()" id="ercCode" ng-model="input" type="text" value="">
                                                    <label for="ercCode">ERC код (16 HEX символов)</label>
                                                    <span></span>
                                                    <a class="clear" ng-click="input = ''; update()" id="submitErc"><i class="uk-icon-close"></i></a>
                                                </div>
                                            </div>
                                            <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4">
                                                <div class="submit-div">
                                                    <button class="full-width" ng-click="getErc(input)" ng-disabled="!ercActive" id="submitErc">
                                                        <i class="uk-icon-spin uk-icon-spinner" ng-class="{'uk-hidden':!loader}"></i> <span ng-class="{'uk-hidden':loader}">Получить код</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1">
                                                <div class="code-article">
                                                    <article class="code-caption">Код разблокировки:@{{csrf}}</article>
                                                    <article>@{{codeLeft}}</article>
                                                    <article>@{{codeRight }}</article>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>

                                        <div class="uk-grid">
                                            <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-1">
                                                <div class="file-upload" >
                                                    <div class="static-file" id="main-drop-zone" ng-class="{'uk-hidden':fileSelected}">
                                                        <h3>Выберите файл или перетащите его сюда</h3>
                                                        <p>Осталось разблокировок: @{{unlocks}}</p>
                                                    </div>
                                                    <div class="file-ready" ng-class="{'uk-hidden':!fileSelected}">
                                                        <div class="uk-grid">
                                                            <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-3-4">
                                                                <h3>Файл корректный, осталось получить код.</h3>
                                                                <p>Осталось разблокировок: @{{unlocks}}</p>
                                                            </div>
                                                            <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4 uk-flex uk-flex-center uk-flex-middle">
                                                                <button class="custom-button" ng-disabled="cdisabled" ng-click="sendFile()">
                                                                    <i class="uk-icon-spin uk-icon-spinner" ng-class="{'uk-hidden':!cloader}"></i> <span ng-class="{'uk-hidden':cloader}">Получить код</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input hidden class="uk-hidden" type="file" id="clarionInput" ng-file-change="fileDrop">
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1">
                                                <div class="code-article">
                                                    <article class="code-caption">Код разблокировки:</article>
                                                    <article>@{{ClResult}}</article>
                                                </div>
                                            </div>
                                        </div>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-result">
            <div class="uk-container uk-container-center">
                <div class="body-table">
                    <h3>История</h3>
                    <dir-pagination-controls
                            max-size="6"
                            direction-links="true"
                            boundary-links="true">
                    </dir-pagination-controls>
                    <div class="uk-overflow-container">
                        <table class="uk-table k-table-condensed">
                            <thead>
                            <tr>
                                <th ng-click="sort('created_at')">Дата и время
                                    <i class="" ng-show="sortKey=='created_at'"
                                       ng-class="{'uk-icon-sort-amount-asc':reverse,'uk-icon-sort-amount-desc':!reverse}"></i>
                                </th>
                                <th ng-click="sort('device_type')">Тип ключа
                                    <i class="" ng-show="sortKey=='device_type'"
                                       ng-class="{'uk-icon-sort-amount-asc':reverse,'uk-icon-sort-amount-desc':!reverse}"></i>
                                </th>
                                </th>
                                <th ng-click="sort('app_type')">Приложение
                                    <i class="" ng-show="sortKey=='app_type'"
                                       ng-class="{'uk-icon-sort-amount-asc':reverse,'uk-icon-sort-amount-desc':!reverse}"></i>
                                </th>
                                </th>
                                <th ng-click="sort('input_data')">Исходные данные
                                    <i class="" ng-show="sortKey=='input_data'"
                                       ng-class="{'uk-icon-sort-amount-asc':reverse,'uk-icon-sort-amount-desc':!reverse}"></i>
                                </th>
                                </th>
                                <th ng-click="sort('result')">Ключ
                                    <i class="" ng-show="sortKey=='result'"
                                       ng-class="{'uk-icon-sort-amount-asc':reverse,'uk-icon-sort-amount-desc':!reverse}"></i>
                                </th>
                                </th>
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
                                max-size="6"
                                direction-links="true"
                                boundary-links="true">
                        </dir-pagination-controls>
                        {{--@include('partials.pagination', ['paginator' => $histories])--}}
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('partials.donate');
@endsection