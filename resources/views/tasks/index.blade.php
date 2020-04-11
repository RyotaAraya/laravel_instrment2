@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">{{ __('Task List') }}</div>
            <!-- 検索 -->
            <div class="form-group mt-4">
                    <input type="text" class="" v-model="keyword" placeholder="Search KeyWord" />
                    <i class="fas fa-search"></i>
            </div>
            <transition-group name="fade" tag="div" class="p-task__container" style="list-style: none;">
                <li class="p-task__list" v-for="(task,index) in filteredTasks" v-bind:key="task.id">

                    <div class="p-img__container">
                        <img class="p-task__img" :src="`storage/img/${task.picture1}`" />
                    </div>
                    <div class="p-task__container">
                        <p class="p-task__right">@{{task.plant_name}}</p>
                        <p class="p-task__right">@{{task.tag_no}}</p>
                        <p class="p-task__right">@{{task.task_status}}</p>
                        <p class="p-task__right">
                            <a v-bind:href="`tasks/${task.id}/details`" class="btn btn-secondary">詳細</a>
                            <a v-bind:href="`tasks/${task.id}/edit`" class="btn btn-secondary">編集</a>
                        </p>
                    </div>

                </li>
            </transition-group>
        </div>
    </div>
</div>
@endsection