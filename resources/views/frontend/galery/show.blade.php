@extends('frontend.layouts.app')

@section('title', $post->title)

@push('after-styles')
<style>
    .tiktok-wrapper [data-e2e="Player-index-EmbedRecommendation"]{
        display: none !important;
    }
    .tiktok-wrapper [data-e2e="Player-Layer-LayerContainer"]{
        display: none !important;
    }

    .youtube-wrapper iframe{
        width: 700px;
        height: 467px;
    }

</style>
@endpush

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center text-secondary">{{ $post->title }}</h1>

                <div style="max-width: 700px; margin: auto">
                    @if ($post->hasVideo())
                    <div class="position-relative">

                        @if ($post->video->isType('tiktok'))
                            <div class="tiktok-wrapper">
                                {!! $video['data']->html !!}
                            </div>
                        @endif

                        @if ($post->video->isType('youtube'))
                            <div class="youtube-wrapper">
                                {!! $video['data']->html !!}
                            </div>
                        @endif

                        @if ($post->video->isType('instagram'))
                            <div class="instagram-wrapper">
                                {!! $video['data']->html !!}
                            </div>
                        @endif


                        {{-- <img src="{{ asset('storage/post_thumbnails/'.$post->video->thumbnail) }}" alt="" class="w-100 rounded "> --}}
                    </div>
                    @endif
                </div>

                <share-button-component :post-id="{{$post->id}}" :links-data='@json($post->share_link)'/>
            </div>
        </div>
    </div>
@endsection

