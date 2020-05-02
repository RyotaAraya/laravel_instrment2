@extends('layouts.app')

@section('content')
<div class="p-home__container">
  <div class="p-home__background">
    <div class="p-home__slider">
      <div v-if="tasks.length">
        <transition-group name="fade" tag="div" class="p-tasks__container" style="list-style: none;">
          <li class="p-task__list" v-for="(task,index) in tasks" v-bind:key="task.id" v-if="current_slide == index">

            <a class="p-img__container" :href="`storage/img/${task.picture1}`" data-lightbox="group">
              <img class="p-task__img" :src="`storage/img/${task.picture1}`" /></a>

            <div class="p-task__container">
              <p class="p-task__flex">{{ __('plant_name') }}：@{{task.plant_name}}</p>
              <p class="p-task__flex">{{ __('tag_no') }}：@{{task.tag_no}}</p>
              <p class="p-task__flex">{{ __('task_status') }}：@{{task.task_status}}</p>
              <p class="p-task__flex">@{{task.created_at}}</p>
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
            <a class="nav-link btn btn-secondary p-task__flex" href="{{ route('login') }}">{{ __('Login') }}</a>
          </li>
        </div>
        <li class="nav-item p-nav__first">
          <a class="nav-link p-task__flex" href="https://github.com/RyotaAraya/laravel_instrment2" target="_blank" rel="noopener">
            <i class="fab fa-github p-nav__center"></i>
            source code
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://qiita.com/ryota_qiita/private/2133612e90b98403d554" target="_blank" rel="noopener">
            <span class="fa-stack" style="color:#4cb10d">
              <i class="fa fa-square fa-stack-2x"></i>
              <i class="fa fa-search fa-stack-1x fa-inverse fa-2x"></i>
            </span>
            制作環境と工程まとめ
          </a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link p-task__flex" href="https://github.com/RyotaAraya/laravel_instrment2" target="_blank" rel="noopener">
            <i class="fab fa-youtube p-nav__center"></i>
            操作方法
          </a>
        </li> -->
      </ul>
    </div>

  </div>
</div>
@endsection