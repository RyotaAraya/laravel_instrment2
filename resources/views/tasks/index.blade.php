@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('Task_List')}}</h2>
    <div class="row">
        @foreach($tasks as $task)
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">{{ $task->plant_name }}</h3>
                    <h3 class="card-title">{{ $task->tag_no }}</h3>
                    <h3 class="card-title">{{ $task->trouble_content }}</h3>
                    <h3 class="card-title">{{ $task->picture1 }}</h3>
                    <a href="" class="btn btn-primary">{{ __('Go Practice') }}</a>
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">{{ __('Go Edit') }}</a>
                    <form action="{{ route('tasks.delete', $task->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-danger" onclick='return confirm("削除しますか?");'>{{ __('Go Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection