@extends('backpack::layout')

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('css/extra.css') }}">
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

<style>
    .total {
        border-top: 1px solid black;
    }
</style>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">


                        <form action="/calendar">
                            <input type="hidden" name="date" value="{{ $calendar->date->format('dmY') }}">
                            <input type="hidden" name="display" value="{{ $calendar->display }}">

                            <button name="navigate" value="today" class="btn btn-primary">Today</button>
                            <button name="navigate" value="prev" class="btn btn-primary">Prev</button>
                            <button name="navigate" value="next" class="btn btn-primary">Next</button>
                        </form>

                    </div>
                </div>

                <div class="box-body">

                    <div class="calendar">

                        <div class="cal-row">
                            @foreach($calendar->getHeadings() as $heading)
                                <div class="cal-col cal-head">{{ $heading }}</div>
                            @endforeach
                        </div>

                        @foreach($calendar->getDates() as $row)
                            <div class="cal-row">
                                @foreach($row as $cell)

                                    <div class="cal-col cal-cell{{ $cell['today'] ? ' cell-primary' : '' }}{{ $cell['in_range'] ? '' : ' cell-secondary' }}">

                                        <div class="date">{{ $cell['day'] }}</div>

                                        @foreach($calendar->getItems($cell['date_id']) as $item)
                                            <div><span class="fa {{ $item['value'] > 0 ? 'fa-arrow-right text-success' : 'fa-arrow-left text-danger' }}"></span> {{ $item['value'] }}</div>
                                        @endforeach

                                        @isset($calendar->balances[$cell['date_id']])
                                            <div class="total">{{ $calendar->balances[$cell['date_id']]['value'] }}</div>
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
