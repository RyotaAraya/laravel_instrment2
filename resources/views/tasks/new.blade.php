@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="card" style="width:100%;">
      <div class="card-header"><i class="fas fa-hammer"></i>{{ __('Task Register') }}</div>

      <div class="card-body">
        <form method="POST" action="{{ route('tasks.create') }}" enctype="multipart/form-data">
          @csrf
          <!-- plant_name -->
          <div class="form-group row">
            <label for="plant_name" class="col-md-3 col-form-label text-md-right">{{ __('plant_name') }}</label>

            <div class="col-md-8">
              <input id="plant_name" type="text" class="form-control @error('plant_name') is-invalid @enderror" name="plant_name" value="{{ old('plant_name') }}" required autocomplete="plant_name" autofocus>

              @error('plant_name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- tag_no -->
          <div class="form-group row">
            <label for="tag_no" class="col-md-3 col-form-label text-md-right">{{ __('tag_no') }}</label>

            <div class="col-md-8">
              <input id="tag_no" type="text" class="form-control @error('tag_no') is-invalid @enderror" name="tag_no" value="{{ old('tag_no') }}" autocomplete="tag_no" autofocus>

              @error('tag_no')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- 不具合内容 -->
          <div class="form-group row">
            <label for="trouble_content" class="col-md-3 col-form-label text-md-right">{{ __('trouble_content') }}</label>

            <div class="col-md-8">
              <textarea id="trouble_content" rows="4" class="form-control @error('trouble_content') is-invalid @enderror" name="trouble_content" autocomplete="trouble_content">{{ old('trouble_content'?:$articles->trouble_content) }}</textarea>

              @error('trouble_content')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- 補修内容 -->
          <div class="form-group row">
            <label for="details_repair" class="col-md-3 col-form-label text-md-right">{{ __('details_repair') }}</label>

            <div class="col-md-8">
              <textarea id="details_repair" rows="4" class="form-control @error('details_repair') is-invalid @enderror" name="details_repair" value="{{ old('details_repair') }}" autocomplete="details_repair">{{ old('trouble_content'?:$articles->trouble_content) }}</textarea>

              @error('details_repair')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- task_status -->
          <div class="form-group row">
            <label for="task_status" class="col-md-3 col-form-label text-md-right">{{ __('task_status') }}</label>

            <div class="col-md-8">
              <input id="task_status" type="text" class="form-control @error('task_status') is-invalid @enderror" name="task_status" value="{{ old('task_status') }}" autocomplete="task_status" autofocus>

              @error('task_status')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- picture1 -->
          <div class="form-group row">
            <label for="picture1" class="col-md-3 col-form-label text-md-right">{{ __('picture1') }}</label>

            <div class="col-md-8">
              <input id="picture1" type="file" class="form-control @error('picture1') is-invalid @enderror" name="picture1" value="{{ old('picture1') }}" autocomplete="picture1" autofocus>

              @error('picture1')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- picture2 -->
          <div class="form-group row">
            <label for="picture2" class="col-md-3 col-form-label text-md-right">{{ __('picture2') }}</label>

            <div class="col-md-8">
              <input id="picture2" type="file" class="form-control @error('picture2') is-invalid @enderror" name="picture2" value="{{ old('picture2') }}" autocomplete="picture2" autofocus>

              @error('picture2')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <div class="form-group row mt-5 mb-4">
            <div class="col-md-8 offset-md-3">
              <button type="submit" class="btn btn-secondary btn-lg btn-block">
                {{ __('Task Add') }}
              </button>
            </div>
          </div>
        </form>
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