@extends('layouts.app')

@section('content')
<script src="{{ asset('js/upload-aws-s3.js') }}" defer></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New Picture for gallery: {{$gallery->name}}</div>

                <div class="card-body">
                <form method="POST" action="{{ route('galleries.pictures.store', $gallery) }} " enctype="multipart/form-data" id="image-form" data-s3-attributes="{{ json_encode($formAttributes) }}" data-s3-inputs="{{ json_encode($formInputs) }}">
                        @csrf
                        @foreach ($formInputs as $name => $value)
                            <input type="hidden" name="{{ $name }}" value="{{ $value }}" >
                        @endforeach                              
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Titre</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required autofocus>
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">File</label>

                            <div class="col-md-6">
                                <input id="path" type="file" class="form-control{{ $errors->has('path') ? ' is-invalid' : '' }}" name="path" value="{{ old('path') }}" required autofocus>
                                @if ($errors->has('path'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('path') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                   Create
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
