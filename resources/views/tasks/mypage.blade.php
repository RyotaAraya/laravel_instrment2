@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="p-form__width card-header">{{ __('Task List') }}</div>
            <!-- 検索 -->
            <div class="p-search__container form-group mt-4 mb-4">
                <input type="text" class="p-form__search " v-model="keyword" placeholder="Search KeyWord" />
                <i class="fas fa-search"></i>
            </div>
            <div v-if="filteredTasks.length">
                <transition-group name="fade" tag="div" class="p-task__container" style="list-style: none;">
                    <li class="p-task__list" v-for="(task,index) in filteredTasks" v-bind:key="task.id">

                        <div class="p-img__container">
                            <img class="p-task__img" :src="`storage/img/${task.picture1}`" />
                        </div>
                        <div class="p-task__container">
                            <p class="p-task__flex">{{ __('plant_name') }}：@{{task.plant_name}}</p>
                            <p class="p-task__flex">{{ __('tag_no') }}：@{{task.tag_no}}</p>
                            <p class="p-task__flex">{{ __('task_status') }}：@{{task.task_status}}</p>
                            <p class="p-task__flex">{{ __('task_createdate') }}：@{{task.created_at}}</p>
                            <a v-bind:href="`tasks/${task.id}/details`" class="btn btn-secondary p-task__flex">詳細ページへ</a>
                            <a v-bind:href="`tasks/${task.id}/edit`" class="btn btn-secondary p-task__flex">編集ページへ</a>
                        </div>

                    </li>
                </transition-group>
            </div>
            <div v-else class="p-task__list__non">
                <p>工事がありません。</p>
            </div>
        </div>
    </div>
</div>
@endsection