@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="p-counter__box p-form__width card-header"><i class="far fa-address-card">{{ __('My Page') }}</i>
                <!-- 検索数を表示 -->
                @include('partials.tasks-counter')
            </div>
            <div class="p-title__container">
                <p class="p-title__tag">{{ Auth::user()->name }}さんの仕事一覧</p>
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
                        <p class="p-task__flex">{{$task->created_at}}</p>
                        <a href="tasks/{{ $task->id }}/details" class="btn btn-secondary p-task__flex"><i class="fas fa-search"></i>{{ __('Go Details')}}</a>
                        <a href="tasks/{{ $task->id }}/edit" class="btn btn-secondary p-task__flex"><i class="fas fa-pen"></i>{{ __('Go Update')}}</a>
                        @if($task->delete_flg === 0)
                        <form action="{{ route('tasks.delete', $task->id) }}" method="POST" class="">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger p-task__flex" onclick='return confirm("削除しますか？工事一覧ページで表示されなくなります。");'><i class="fas fa-trash"></i></button>
                        </form>
                        @else
                        <form action="{{ route('tasks.resurrection', $task->id) }}" method="POST" class="">
                            @csrf
                            <button class="btn btn-success p-task__flex" onclick='return confirm("削除を取り消しますか？工事一覧で表示されます。");'>{{ __('Go Resurrection')}}</button>
                        </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <!-- 検索数を表示 -->
            @include('partials.tasks-nonmessage')
            @endif
        </div>
        {{ $tasks->links('pagination::default')  }}

    </div>
</div>
@endsection