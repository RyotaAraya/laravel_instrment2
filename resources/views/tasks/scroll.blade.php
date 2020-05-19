@extends('layouts.app')

@include('layouts.header')
@section('content')



<section class="scroll_area" data-infinite-scroll='{
    "path": ".pagination a[rel=next]",
    "append": ".post"
  }'>
    @foreach($tasks as $task)
    <div class="post">
        <div class="p-task__list">
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
    </div>
    @endforeach

    <!-- まだ表示すべきデータが残っているかチェックする -->
    @if($tasks->hasMorePages())
        {{ $tasks->links() }}
    @endif
</section>

@endsection
@include('layouts.footer')