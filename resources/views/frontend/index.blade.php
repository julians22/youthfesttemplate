@extends('frontend.layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Landing page for Youth Festival')
                    </x-slot>

                    <x-slot name="body">
                        Welcome To Youth Festival
                    </x-slot>
                </x-frontend.card>
            </div>
        </div>
    </div>
@endsection
