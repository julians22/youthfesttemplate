@extends('frontend.layouts.app')

@section('title', $post->title)

@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <h1 class="text-center">{{ $post->title }}</h1>

                <share-button-component :post-id="{{$post->id}}" :links-data='@json($post->share_link)'/>
            </div>
        </div>
    </div>
@endsection

