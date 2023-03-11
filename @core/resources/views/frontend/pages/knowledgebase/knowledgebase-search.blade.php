@extends('frontend.frontend-page-master')
@section('page-title')
    {{__('Search For:')}} {{$search_term}}
@endsection
@section('site-title')
    {{__('Search For:')}} {{$search_term}}
@endsection
@section('content')
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        @if(count($all_knowledgebase) > 0)
                            @foreach($all_knowledgebase as $data)
                                <div class="single-knowledgebase-list-item">
                                    <h4 class="title"><a href="{{route('frontend.knowledgebase.single',$data->slug)}}"><i class="fas fa-folder"></i> {{$data->title}}</a></h4>
                                    <div class="short-content">
                                        {!! Str::words(strip_tags($data->content),50) !!}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-lg-12">
                                <div class="alert alert-warning d-block">{{__('No Article Found')}}</div>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-12">
                        <nav class="pagination-wrapper text-center" aria-label="Page navigation ">
                            {{$all_knowledgebase->links()}}
                        </nav>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget-area">
                        {!! App\WidgetsBuilder\WidgetBuilderSetup::render_frontend_sidebar('knowledgebase',['column' => false]) !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
