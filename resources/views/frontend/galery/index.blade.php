@extends('frontend.layouts.app')

@section('title', 'Galery')

@section('content')

<div class="container">
    <div class="row mt-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between row">
                    <div class="col-md-6">
                        <form action="{{ route('frontend.galery.index') }}" method="GET" id="search_form">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <input type="text" name="keyword" placeholder="Cari Postingan!" value="{{ $query['keyword'] ?? '' }}" class="form-control">
                                </div>
                                <button class="btn btn-primary" type="submit">Terapkan</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row justify-content-end">
                            <label for="sort" class="col-form-label col-md-3 text-right">
                                <small>Urutkan :</small>
                            </label>
                            <div class="col-md-4 pl-0">
                                <select class="custom-select form-control" name="sort" id="sort">
                                    <option value="default" {{$query['sort'] == 'default' ? 'selected' : ''}}>Tidak ada</option>
                                    <option value="popularity" {{$query['sort'] == 'popularity' ? 'selected' : ''}}>Paling Populer</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @if ($posts->count())

            <div class="col-md-12">
                <div class="card-columns">
                    @foreach ($posts as $post)
                    <div class="card">
                        <div class="card-body">
                            <div class="position-relative">
                                <a href="{{ route('frontend.galery.show', ['slug'=>$post->slug]) }}" style="position: absolute; inset: 0"></a>
                                <h5 class="card-title text-primary mb-2">{{ $post->user->name }}</h5>
                                <p class="card-subtitle small mb-1">@displayDate($post->created_at, 'l, F jS Y')</p>
                                <p class="card-subtitle small mb-3">@displayDate($post->created_at, 'g:i A T')</p>

                                <p>{{ $post->title }}</p>
                            </div>

                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <post-like-component user-id="{{$logged_in_user ? $logged_in_user->id : 0 }}" :likes='@json($post->likes)' total-count="{{ $post->likeCount }}" post-id="{{$post->id}}" />
                                </div>
                                <div class="ml-2">
                                    <share-button-component :post-id="{{$post->id}}" :links-data='@json($post->share_link)'/>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
            <div class="col-md-6">
                {{$posts->links()}}
            </div>
            @else
            <div class="col-12">
                <h2 class="text-center">
                    Data tidak ditemukan, cobalah untuk memperluas pencarian anda!
                </h2>
            </div>
            @endif
        </div>



</div>
@endsection

@push('before-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const currentUrl = new URL(window.location);
            let keywordParam = currentUrl.searchParams.get('keyword');
            let sortParam = currentUrl.searchParams.get('sort');

            paramsSetter(currentUrl, [keywordParam, sortParam]);

            const sortSelections = document.querySelector('#sort');
            sortSelections.addEventListener('change', function (e){
                let checked = document.querySelector('#sort :checked');
                sortParam = checked.value
                let nextUrl = paramsSetter(currentUrl, [keywordParam, sortParam]);

                window.location.href = nextUrl;
            })

            const searchForm = document.querySelector('#search_form');
            searchForm.addEventListener('submit', function(e){
                e.preventDefault();
                keywordParam = e.srcElement[0].value;
                let nextUrl = paramsSetter(currentUrl, [keywordParam, sortParam]);
                window.location.href = nextUrl;
            })
        })


        function paramsSetter(url, searchs) {
            if (searchs[0]) {
                url.searchParams.set('keyword', searchs[0]);
            }
            if (searchs[1]) {
                url.searchParams.set('sort', searchs[1]);
            }
            window.history.pushState({},"", url);
            return url;
        }
    </script>
@endpush
