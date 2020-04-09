@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Tasks_Updater') }}</div>

        <div class="card-body">
          <form method="POST" action="{{ route('tasks.update', $task->id) }}">
            @csrf
            <!-- plant_name -->
            <div class="form-group row">
              <label for="plant_name" class="col-md-4 col-form-label text-md-right">{{ __('plant_name') }}</label>

              <div class="col-md-6">
                <input id="plant_name" type="text" class="form-control @error('plant_name') is-invalid @enderror" name="plant_name" value="{{ $task->plant_name }}" required autocomplete="plant_name" autofocus>

                @error('plant_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <!-- tag_no -->
            <div class="form-group row">
              <label for="tag_no" class="col-md-4 col-form-label text-md-right">{{ __('tag_no') }}</label>

              <div class="col-md-6">
                <input id="tag_no" type="text" class="form-control @error('tag_no') is-invalid @enderror" name="tag_no" value="{{ $task->tag_no }}" autocomplete="tag_no" autofocus>

                @error('tag_no')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <!-- trouble_content -->
            <div class="form-group row">
              <label for="trouble_content" class="col-md-4 col-form-label text-md-right">{{ __('trouble_content') }}</label>

              <div class="col-md-6">
                <input id="trouble_content" type="text" class="form-control @error('trouble_content') is-invalid @enderror" name="trouble_content" value="{{ $task->trouble_content }}" autocomplete="trouble_content" autofocus>

                @error('trouble_content')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <!-- details_repair -->
            <div class="form-group row">
              <label for="details_repair" class="col-md-4 col-form-label text-md-right">{{ __('details_repair') }}</label>

              <div class="col-md-6">
                <input id="details_repair" type="text" class="form-control @error('details_repair') is-invalid @enderror" name="details_repair" value="{{ $task->details_repair }}" autocomplete="details_repair" autofocus>

                @error('details_repair')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <!-- task_status -->
            <div class="form-group row">
              <label for="task_status" class="col-md-4 col-form-label text-md-right">{{ __('task_status') }}</label>

              <div class="col-md-6">
                <input id="task_status" type="text" class="form-control @error('task_status') is-invalid @enderror" name="task_status" value="{{ $task->task_status }}" autocomplete="task_status" autofocus>

                @error('task_status')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <!-- picture1 -->
            <div class="form-group row">
              <label for="picture1" class="col-md-4 col-form-label text-md-right">{{ __('picture1') }}</label>

              <div class="col-md-6">
                <input id="picture1" type="text" class="form-control @error('picture1') is-invalid @enderror" name="picture1" value="{{ $task->picture1 }}" autocomplete="picture1" autofocus>

                @error('picture1')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <!-- picture2 -->
            <div class="form-group row">
              <label for="picture2" class="col-md-4 col-form-label text-md-right">{{ __('picture2') }}</label>

              <div class="col-md-6">
                <input id="picture2" type="text" class="form-control @error('picture2') is-invalid @enderror" name="picture2" value="{{ $task->picture2 }}" autocomplete="picture2" autofocus>

                @error('picture2')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('Register') }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection