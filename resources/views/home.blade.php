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
    </div>
    <div class="p-home__btn">
      <ul class="navbar-nav ml-auto">
        <p class="p-home__list">ログインせず工事を見たい方はこちら(編集や削除不可)</p>
        <li class="nav-item">
          <a class="nav-link btn btn-danger p-task__flex" href="{{ route('tasks.index') }}">{{ __('Task List') }}</a>
        </li>
        @guest
        @if (Route::has('register'))
        <p class="p-home__list">ユーザー登録していない方はこちら</p>
        <li class="nav-item">
          <a class="nav-link btn btn-success p-task__flex" href="{{ route('register') }}">{{ __('Register') }}</a>
        </li>
        @endif
        <p class="p-home__list">既に会員の方はこちら</p>
        <li class="nav-item">
          <a class="nav-link btn btn-light p-task__flex" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>
        @endguest
      </ul>
    </div>

  </div>
</div>
@endsection