@extends('layouts.app')

@include('layouts.header')

@section('content')
<div class="p-home__container">
  <div class="p-home__background">
    <div class="p-home__slider">
      <div v-if="tasks.length">
        <transition-group name="fade" tag="div" class="p-tasks__container" style="list-style: none;">
          <li class="p-task__list" v-for="(task,index) in tasks" v-bind:key="task.id" v-if="current_slide == index">

            <a class="p-img__container" :href="`https://image.rarayan.work/tasks_image/${task.picture1}`" data-lightbox="group">
              <img class="p-task__img" :src="`https://image.rarayan.work/tasks_image/${task.picture1}`" /></a>

            <div class="p-task__container">
              <p class="p-task__flex">{{ __('plant_name') }}：@{{task.plant_name}}</p>
              <p class="p-task__flex">{{ __('tag_no') }}：@{{task.tag_no}}</p>
              <a v-bind:href="`tasks/${task.id}/details`" class="btn btn-secondary p-task__flex">{{ __('Go Details')}}</a>
              @if(Auth::check())
              <a v-bind:href="`tasks/${task.id}/edit`" class="btn btn-secondary p-task__flex">{{ __('Go Update')}}</a>
              @endif
            </div>
          </li>
        </transition-group>
      </div>
      <div v-else class="p-tasks__non">
        <p class="p-tasks__non__message">工事データがありません</p>
        <p class="p-tasks__non__message">登録しましょう</p>
      </div>
    </div>
    <div class="p-home__btn">
      <ul class="navbar-nav ml-auto">
        <div v-if="tasks.length">
          <p class="p-home__list">
            <span class="p-home__text">ログインせず工事を見たい方はこちら</span>
            <span class="p-home__text">(ログイン後、編集や削除など可能)</span></p>
          <li class="nav-item">
            <a class="nav-link btn btn-secondary p-task__flex" href="{{ route('tasks.index') }}">{{ __('Task List') }}</a>
          </li>
        </div>
        <div v-else>
          <p class="p-home__list">
            <span class="p-home__text">ユーザー登録済みの方はこちら</span>
            <li class="nav-item">
              <a class="nav-link btn btn-secondary" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
        </div>
      </ul>
    </div>
    <div class="p-home__list-container">
      <!-- 構成 -->
      <div class="p-home__list nav-item">
        <div class=p-img__container>
          <img class="p-home__img" :src="`https://instrment-aws-infra.s3-ap-northeast-1.amazonaws.com/tasks_image/inst-img.png
`" />
        </div>
        <a class="p-task__flex" href="https://github.com/RyotaAraya/laravel_instrment2" target="_blank" rel="noopener">
          <i class="fab fa-github p-nav__center"></i>
          source code
        </a>
        <p class="p-task__boder"></p>
      </div>

      <!-- youtube -->
      <div class="p-home__list nav-item">
        <div class=p-img__container>
          <img class="p-home__img" :src="`https://instrment-aws-infra.s3-ap-northeast-1.amazonaws.com/tasks_image/respon-img.png
`" />
        </div>
        <a class="p-task__flex" href="https://www.youtube.com/watch?v=1EHorHgucnM" target="_blank" rel="noopener">
          <i class="fab fa-youtube"></i>
          操作動画
        </a>
        <p class="p-task__boder"></p>
      </div>
      <!-- 2.開発環境 -->
      <div class="p-home__list nav-item">
        <div class=p-img__container>
          <img class="p-home__img" :src="`https://instrment-aws-infra.s3-ap-northeast-1.amazonaws.com/tasks_image/laravel-img.png
`" />
        </div>
        <a class="p-task__flex" href="https://qiita.com/ryota_qiita/private/2133612e90b98403d554" target="_blank" rel="noopener">
          <span class="fa-stack" style="color:#4cb10d">
            <i class="fa fa-square fa-stack-2x"></i>
            <i class="fa fa-search fa-stack-1x fa-inverse fa-2x"></i>
          </span>
          開発環境と工程まとめ
        </a>
        <p class="p-task__boder"></p>
      </div>
      <!-- 3.AWS -->
      <div class="p-home__list nav-item">
        <div class=p-img__container>
          <img class="p-home__img" :src="`https://instrment-aws-infra.s3-ap-northeast-1.amazonaws.com/tasks_image/aws-img.png
`" />
        </div>
        <a class="p-task__flex" href="https://qiita.com/ryota_qiita/private/d06e36819a7a432403fb" target="_blank" rel="noopener">
          <span class="fa-stack" style="color:#4cb10d">
            <i class="fa fa-square fa-stack-2x"></i>
            <i class="fa fa-search fa-stack-1x fa-inverse fa-2x"></i>
          </span>
          AWSで本番環境構築
        </a>
        <p class="p-task__boder"></p>
      </div>
    </div>
  </div>
</div>
@endsection

@include('layouts.footer')