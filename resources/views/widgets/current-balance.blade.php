<div class="box box-default">
    <div class="box-header with-border">
        <div class="box-title">Current balance</div>
    </div>

    <div class="box-body">
        <div class="col-xs-12">
            <table class="table">
                <thead>
                    <th>Account</th>
                    <th>Balance</th>
                </thead>
                <tbody>
                    @foreach($accounts as $account)
                        <tr>
                            <td>{{ $account->name }}</td>
                            <td>{{ Formatter::toMoney($account->getCurrentBalance()) }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>


