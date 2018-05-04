@extends('backpack::layout')

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('css/extra.css') }}">
@endsection

@section('after_scripts')
    <script type="text/javascript">
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection

@section('header')
    <section class="content-header">
      <h1>
        Calendar View<small>{{ $calendar->date->format('M Y') }}</small>
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
                    <div class="box-title">

                        @include('calendar.navigation')

                    </div>
                </div>

                <div class="box-body">

                    <div class="calendar">

                        <div class="cal-row">
                            @foreach($calendar->getHeadings() as $heading)
                                <div class="cal-col cal-head">{{ $heading }}</div>
                            @endforeach
                        </div>

                        @foreach($calendar->dates as $row)
                            <div class="cal-row">
                                @foreach($row as $cell)

                                    <div class="cal-col cal-cell{{ $cell['today'] ? ' cell-primary' : '' }}{{ $cell['in_range'] ? '' : ' cell-secondary' }}">

                                        <div class="date">{{ $cell['day'] }}</div>

                                        @foreach($calendar->getEvents($cell['date_id']) as $event)
                                            <div>
                                                <a href="" onclick="return false;" data-toggle="tooltip" data-placement="top" title="{{ $event->name }}">
                                                    <span class="fa{{ $event->getClasses() }}"></span> {{ $event->value }}
                                                </a>
                                            </div>
                                        @endforeach

                                        @if($balance = $calendar->getBalance($cell['date_id']))
                                            <div class="total">{{ $balance->value }}</div>
                                        @endisset

                                    </div>

                                @endforeach
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
