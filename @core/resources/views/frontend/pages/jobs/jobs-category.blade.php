@extends('frontend.frontend-page-master')
@section('page-title')
    {{__('Category:')}} {{$category_name}}
@endsection
@section('site-title')
    {{__('Category:')}} {{$category_name}}
@endsection
@section('content')
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        @if(count($all_jobs) > 0)
                        @foreach($all_jobs as $data)
                            <div class="col-lg-12">
                                <div class="single-job-list-item">
                                    <span class="job_type"><i class="far fa-clock"></i> {{str_replace('_',' ',$data->employment_status)}}</span>
                                    <a href="{{route('frontend.jobs.single',$data->slug)}}"><h3 class="title">{{$data->title}}</h3></a>
                                    <span class="company_name"><strong>{{__('Company:')}}</strong> {{$data->company_name}}</span>
                                    <span class="deadline"><strong>{{__('Deadline:')}}</strong> {{date("d M Y", strtotime($data->deadline))}}</span>
                                    <ul class="jobs-meta">
                                        <li><i class="fas fa-briefcase"></i> {{$data->position}}</li>
                                        <li><i class="fas fa-wallet"></i> {{$data->salary}}</li>
                                        <li><i class="fas fa-map-marker-alt"></i> {{$data->job_location}}</li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                        @else
                            <div class="col-lg-12">
                                <div class="alert alert-warning">{{__('Nothing Found In This Category')}}</div>
                            </div>
                        @endif

                    </div>
                    <div class="col-lg-12">
                        <nav class="pagination-wrapper text-center" aria-label="Page navigation ">
                            {{$all_jobs->links()}}
                        </nav>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget-area">
                        {!! App\WidgetsBuilder\WidgetBuilderSetup::render_frontend_sidebar('career',['column' => false]) !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
