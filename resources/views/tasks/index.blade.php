@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="p-counter__box p-form__width card-header"><i class="far fa-list-alt">{{ __('Task List') }}</i>
                <!-- 検索数を表示 -->
                <p class="p-counter__right">
                    {{ $tasks->firstItem() }} 〜
                    {{ $tasks->lastItem() }} ／
                    <a class="p-counter__total">{{ $tasks->total() }} 件</a>
                </p>
            </div>
            <!-- 全件表示リンク vue.js -->
            <div class="p-title__container">
                <p class="p-title__tag"><a href="{{ route('tasks.alltasks') }}">{{ __('All Tasks') }}</a>
                </p>
            </div>
            @if(count($tasks))
            <div name="fade" class="p-tasks__container">

                @foreach($tasks as $task)
                <div class="p-task__list">
                    <a class="p-img__container" href="storage/img/{{ $task->picture1 }}" data-lightbox="group">
                        <img class="p-task__img" src="storage/img/{{ $task->picture1 }}" /></a>
                    <div class="p-task__container">
                        <p class="p-task__flex">{{ __('plant_name') }}：{{$task->plant_name}}</p>
                        <p class="p-task__flex">{{ __('tag_no') }}：{{$task->tag_no}}</p>
                        <p class="p-task__flex">{{ __('task_status') }}：{{$task->task_status}}</p>
                        <p class="p-task__flex">{{ __('creater_name') }}：{{$task->user->name}}</p>
                        <p class="p-task__flex">{{$task->created_at}}</p>
                        <a href="tasks/{{ $task->id }}/details" class="btn btn-secondary p-task__flex"><i class="fas fa-search"></i>{{ __('Go Details')}}</a>
                        @if(Auth::check())
                        <a href="tasks/{{ $task->id }}/edit" class="btn btn-secondary p-task__flex"><i class="fas fa-pen"></i>{{ __('Go Update')}}</a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="p-tasks__non">
                <p>工事データがありません</p>
                <p>登録しましょう</p>
            </div>
            @endif
        </div>
        {{ $tasks->links('pagination::default')  }}

    </div>
</div>
@endsection