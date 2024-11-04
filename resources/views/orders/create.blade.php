@extends('layouts.master')
@section('content')
    <main id="main-container">
        <div class="content">
            <div class="block block-rounded block-bordered">

                <div class="block-header block-header-default border-bottom bg-gd-dusk">
                    <h3 class="block-title" style="color: white;">{{ $type[0]->name }}</h3>
                </div>
                <div class="block-content">
                    @if ($type[0]->path == 'review')
                        @include('orders._form_review', ['type', $type])
                    @elseif($type[0]->path == 'seomap')
                        @include('orders._form_seomap', ['type', $type])
                    @elseif($type[0]->path == 'likemap')
                        @include('orders._form_likemap', ['type', $type])
                    @elseif($type[0]->path == 'reportmap')
                        @include('orders._form_reportmap', ['type', $type])
                    @elseif($type[0]->path == 'createmap')
                        @include('orders._form_createmap', ['type', $type])
                    @endif
                </div>


            </div>


        </div>
    </main>
@endsection
