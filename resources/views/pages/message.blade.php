@extends('common')

@section('content')
    <div class="about">
      <div class="uk-container uk-container-center">
        <h2>{{$header}}</h2>
        <h5>{!! $description !!}</h5>
      </div>
    </div>

  <div class="notification">
    <div class="uk-container uk-container-center">
      @if(isset($image))
      <div class="uk-center">
        <img src="{{$image['src']}}" alt="{{$image['alt']}}">
      </div>
      @endif
      @if(isset($notify))
      <div class="uk-center">
        {!! $notify !!}
      </div>
      @endif
      @if(isset($button))
        <div class="uk-center">
          <div class="uk-inline-block-padding">
            <a href="{{$button['href']}}" class="custom-button">
              <span>{{$button['text']}}</span>
            </a>
          </div>
        </div>
      @endif
    </div>

  </div>

@endsection