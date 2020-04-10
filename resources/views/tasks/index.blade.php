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

    <transition-group name="fade" tag="div" class="row list-flex container">
        <li class="col-md-6 col-sm-12" v-for="(task,index) in filteredTasks" v-bind:key="task.id">

            <a>@{{task.picture1}}</a>
            <a>@{{index + 1}}</a>
            <a>@{{task.plant_name}}</a>
            <a>@{{task.tag_no}}</a>
            <a>@{{task.task_status}}</a>
            <p><button class="btn btn-secondary">完了</button></p>
        </li>
    </transition-group>
</div>
@endsection