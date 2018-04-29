@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Calendar View<small>01/01/2018 - 01/02/2018</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">Calendar</li>
      </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title"></div>
                </div>

                <div class="box-body"></div>
            </div>
        </div>
    </div>
@endsection
