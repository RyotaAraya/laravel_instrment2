@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="p-counter__box p-form__width card-header">{{ __('My Page') }}
                <!-- 検索数を表示 -->
                <p class="p-counter__right">
                    <a class="p-counter__total">{{ $tasks->total() }} 件Hit /</a>
                    ({{ $tasks->firstItem() }} 〜
                    {{ $tasks->lastItem() }} )
                </p>
            </div>
            @if(count($tasks))
            <div name="fade" class="p-tasks__container">
                @foreach($tasks as $task)
                <div class="p-task__list">
                    <div class="p-img__container">
                        <img class="p-task__img" src="storage/img/{{ $task->picture1 }}" />
                    </div>
                    <div class="p-task__container">
                        <p class="p-task__flex">{{ __('plant_name') }}：{{$task->plant_name}}</p>
                        <p class="p-task__flex">{{ __('tag_no') }}：{{$task->tag_no}}</p>
                        <p class="p-task__flex">{{ __('task_status') }}：{{$task->task_status}}</p>
                        <p class="p-task__flex">{{ __('task_createdate') }}：{{$task->created_at}}</p>
                        <a href="tasks/{{ $task->id }}/details" class="btn btn-secondary p-task__flex">{{ __('Go Details')}}</a>
                        <a href="tasks/{{ $task->id }}/edit" class="btn btn-secondary p-task__flex">{{ __('Go Update')}}</a>
                        @if($task->delete_flg === 0)
                        <form action="{{ route('tasks.delete', $task->id) }}" method="POST" class="">
                            @csrf
                            <button class="btn btn-danger p-task__flex" onclick='return confirm("削除しますか？工事一覧ページで表示されなくなります。");'>{{ __('Go Delete')}}</button>
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