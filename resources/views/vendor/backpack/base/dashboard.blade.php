@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}<small>{{ trans('backpack::base.first_page_you_see') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-6">
            @include('widgets.update-balance')
        </div>
        <div class="col-md-6">
            @include('widgets.current-balance')
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('widgets.upcoming-balance')
        </div>
    </div>
@endsection
