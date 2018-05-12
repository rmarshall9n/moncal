<div class="box box-default">
    <div class="box-header with-border">
        <div class="box-title">Upcoming balance</div>
    </div>

    <div class="box-body">
        <div class="col-xs-12">
            <table class="table">
                <thead>
                    <th>Account</th>
                    @foreach($dates as $date)
                        <th>{{ $date->format('M') }}</th>
                    @endforeach
                </thead>
                <tbody>
                    @foreach($accounts as $account)
                        <tr>
                            <td>{{ $account->name }}</td>

                            @foreach($dates as $date)
                                <td>{{ $account->getBalanceOn($date) }}</td>
                            @endforeach

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>


