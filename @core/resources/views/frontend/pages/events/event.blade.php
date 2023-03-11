@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('events_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('events_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('events_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('events_page_'.$user_select_lang_slug.'_meta_tags')}}">
@endsection
@section('content')
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12">
                        @foreach($all_events as $data)
                            <div class="single-events-list-item">
                                <div class="thumb">
                                    {!! render_image_markup_by_attachment_id($data->image,'','grid') !!}
                                </div>
                                <div class="content-area">
                                    <div class="top-part">
                                        <div class="time-wrap">
                                            <span class="date">{{date('d',strtotime($data->date))}}</span>
                                            <span class="month">{{date('M',strtotime($data->date))}}</span>
                                        </div>
                                        <div class="title-wrap">
                                            <a href="{{route('frontend.events.single',$data->slug)}}"><h4 class="title">{{$data->title}}</h4></a>
                                            <span class="location"><i class="fas fa-map-marker-alt"></i> {{$data->venue_location}}</span>
                                        </div>
                                    </div>
                                    <p>{{strip_tags(Str::words(str_replace('&nbsp;',' ',$data->content),20))}}</p>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    <div class="col-lg-12 text-center">
                        <nav class="pagination-wrapper " aria-label="Page navigation ">
                            {{$all_events->links()}}
                        </nav>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget-area">
                        {!! App\WidgetsBuilder\WidgetBuilderSetup::render_frontend_sidebar('event',['column' => false]) !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
