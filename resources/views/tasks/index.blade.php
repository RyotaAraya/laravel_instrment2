@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('Task_List')}}</h2>
    <!-- 検索 -->
    <div class="form-group mt-4">
        <form class="">
            <input type="text" class="form-control" v-model="keyword" placeholder="Search KeyWord" />
            <i class="fas fa-search"></i>
        </form>
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
                <p class="p-task__right"><button class="btn btn-secondary">完了</button></p>
            </div>

        </li>
    </transition-group>
</div>
@endsection