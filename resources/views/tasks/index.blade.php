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
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection