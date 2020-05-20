@extends('layouts.app')

@include('layouts.header')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <!-- 検索数を表示 -->
            <div class="p-counter__box p-form__width card-header"><i class="far fa-list-alt">{{ __('ScrollPage') }}</i>
                <!-- 検索数を表示 -->
                <p class="p-counter__right">
                    <a class="p-counter__total">{{ $tasks->total() }} 件</a>
                </p>
            </div>

            <section class="scroll_area p-tasks__container" data-infinite-scroll='{
    "path": ".pagination a[rel=next]",
    "append": ".post"
  }'>
                @foreach($tasks as $task)
                <div class="post p-task__list">
                    <a class="p-img__container" href="https://image.rarayan.work/tasks_image/{{ $task->picture1 }}" data-lightbox="group">
                        <img class="p-task__img" src="https://image.rarayan.work/tasks_image/{{ $task->picture1 }}" /></a>
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
                <!-- まだ表示すべきデータが残っているかチェックする -->
                @if($tasks->hasMorePages())
                <div class="p-display__non">{{ $tasks->links() }}</div>
                @endif
            </section>
        </div>
    </div>
</div>
@endsection
@include('layouts.footer')