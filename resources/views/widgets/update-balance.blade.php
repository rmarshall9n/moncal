<div class="box box-default">
    <div class="box-header with-border">
        <div class="box-title">Update balance</div>
    </div>

    <div class="box-body">
        <form action="{{ route('update-balance.store') }}" method="post">
            {!! csrf_field() !!}

            <div class="form-group col-xs-12">
                <label>Account</label>
                <select name="bank_account_id" class="form-control">
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-xs-12">
                <label>New Balance</label>
                <div class="input-group">
                    <div class="input-group-addon">£</div>
                    <input type="number" name="updated_balance" class="form-control" step="0.01">
                 </div>
            </div>

            <div class="form-group col-xs-12">
                <button type="submit" class="btn btn-success">
                    <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
                    <span data-value="save_and_back">Save and back</span>
                </button>
            </div>

        </form>
    </div>
</div>


