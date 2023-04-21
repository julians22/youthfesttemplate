@extends('frontend.layouts.app')

@section('title', __('Buat Video'))

@section('content')
<form action="{{ route('frontend.post.store') }}" method="POST"  enctype="multipart/form-data">
    @csrf
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <x-frontend.card>

                    <x-slot name="body">
                        <h5 class="card-title mb-2">
                            @lang('Buat Video')
                        </h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4">@lang('Judul Video')</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" required value="{{ old('title') }}" name="title" id="title">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4">@lang('Sumber Video')</label>
                                    <div class="col-md-8">
                                        <select name="type" id="type" class="custom-select">
                                            <option value="instagram">@lang('Instagram (Reels)')</option>
                                            <option value="tiktok">@lang('Tik Tok')</option>
                                            <option value="youtube">@lang('Youtube')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4">@lang('URL Video')</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" required value="{{ old('url') }}" name="url" id="url">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4">@lang('Thumbnail Video')</label>
                                    <div class="col-md-8">
                                        <input type="file" class="custom-file" required value="{{ old('thumbnail') }}" name="thumbnail" id="thumbnail">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Data</button>
                            </div>
                        </div>




                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
</form>

@endsection
