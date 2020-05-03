@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="p-counter__box p-form__width card-header">
                {{ __('All Tasks') }}
                <!-- 検索数を表示 -->
                <p class="p-counter__right">
                    <a class="p-counter__total">
                        @{{ filteredTasks.length}} 件
                    </a>
                </p>
            </div>
            <!-- 検索 -->

            <div class="p-search__container form-group mt-4 mb-4">
                <input type="text" class="p-form__search " v-model="keyword" placeholder="Search Keyword" />
            </div>
            <div v-if="filteredTasks.length">
                <transition-group name="fade" tag="div" class="p-tasks__container" style="list-style: none;">
                    <li class="p-task__list" v-for="(task,index) in filteredTasks" v-bind:key="task.id">

                        <a class="p-img__container" :href="`https://instrment-aws-infra.s3-ap-northeast-1.amazonaws.com/tasks_image/${task.picture1}`" data-lightbox="group">
                            <img class="p-task__img" :src="`https://instrment-aws-infra.s3-ap-northeast-1.amazonaws.com/tasks_image/${task.picture1}`" /></a>

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
                <p>工事データがありません</p>
                <p>登録しましょう</p>
            </div>
        </div>
    </div>
</div>
@endsection