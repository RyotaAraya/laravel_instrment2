@extends('layouts.app')

@include('layouts.header')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="card">
      <div class="card-header">{{ __('Task Details') }}</div>

      <div class="card-body">
        <!-- プラント名 -->
        <div class="form-group row">
          <div for="plant_name" class="col-md-3 text-md-right">{{ __('plant_name') }}</div>
          <div class="col-md-8 p-task__display">{{ $task->plant_name }}</div>
        </div>

        <!-- タグナンバー -->
        <div class="form-group row">
          <div for="plant_name" class="col-md-3 text-md-right">{{ __('tag_no') }}</div>
          <div class="col-md-8 p-task__display">{{ $task->tag_no }}</div>
        </div>

        <!-- 不具合内容 -->
        <div class="form-group row">
          <div for="plant_name" class="col-md-3 text-md-right">{{ __('trouble_content') }}</div>
          <div class="col-md-8 p-task__display">{{ $task->trouble_content }}</div>
        </div>

        <!-- 補修内容 -->
        <div class="form-group row">
          <div for="plant_name" class="col-md-3 text-md-right">{{ __('details_repair') }}</div>
          <div class="col-md-8 p-task__display">{{ $task->details_repair }}</div>
        </div>

        <!-- 状態 -->
        <div class="form-group row">
          <div for="plant_name" class="col-md-3 text-md-right">{{ __('task_status') }}</div>
          <div class="col-md-8 p-task__display">{{ $task->task_status }}</div>
        </div>

        <!-- 通知者 -->
        <div class="form-group row">
          <div for="plant_name" class="col-md-3 text-md-right">{{ __('creater_name') }}</div>
          <div class="col-md-8 p-task__display">{{ $task->user->name }} /
            <a href="mailto:{{ $task->user->email }}">{{ $task->user->email }}</a></div>
        </div>

        <!-- 通知日 -->
        <div class="form-group row">
          <div for="plant_name" class="col-md-3 text-md-right">{{ __('task_createdate') }}</div>
          <div class="col-md-8 p-task__display">{{ $task->created_at }}</div>
        </div>

        <!-- 更新日 -->
        <div class="form-group row">
          <div for="plant_name" class="col-md-3 text-md-right">{{ __('task_updatedate') }}</div>
          <div class="col-md-8 p-task__display">{{ $task->updated_at }}</div>
        </div>

        <!-- 画像1 -->
        <div class="form-group row">
          <div for="picture1" class="col-md-3 text-md-right">{{ __('picture1') }}</div>

          <div class="col-md-8">
            <a class="" href="https://image.rarayan.work/tasks_image/{{ $task->picture1 }}" data-lightbox="group">
              <img class="img" src="https://image.rarayan.work/tasks_image/{{ $task->picture1 }}" style="max-width: 100%; height:auto;" />
            </a></p>
          </div>
        </div>
        <!-- 画像2 -->
        <div class="form-group row">
          <div for="picture2" class="col-md-3 text-md-right">{{ __('picture2') }}</div>

          <div class="col-md-8">
            <a class="" href="https://image.rarayan.work/tasks_image/{{ $task->picture2 }}" data-lightbox="group">
              <img class="img" src="https://image.rarayan.work/tasks_image/{{ $task->picture2 }}" style="max-width: 100%; height:auto;" />
            </a></p>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-6">
            <a href="{{ route('tasks.index')}}">&lt; 工事一覧へ</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@include('layouts.footer')