<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Models\BankAccount;
use App\Http\Requests\TransactionRequest as StoreRequest;
use App\Http\Requests\TransactionRequest as UpdateRequest;

class TransactionCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Transaction');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/transaction');
        $this->crud->setEntityNameStrings('transaction', 'transactions');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        // ------ CRUD FIELDS
        $this->crud->addField([
            'name' => 'name',
            'label' => 'Name',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'in_out',
            'label' => "Transaction Type",
            'type' => 'select_from_array',
            'options' => [-1 => 'Expense', 1 => 'Income'],
            'allows_null' => false,
            'default' => -1,
        ], 'create');

        $this->crud->addField([
            'name' => 'amount',
            'label' => 'Amount',
            'type' => 'number',
            'prefix' => '£',
            'min' => 1,
        ]);

        $this->crud->addField([
            'name' => 'made_on',
            'label' => 'Date',
            'type' => 'date_picker',
            'date_picker_options' => [
                'todayHighlight' => true,
            ],
        ]);

        $this->crud->addField([
            'label' => 'Bank Account',
            'type' => 'select2',
            'name' => 'bank_account_id',
            'entity' => 'bankAccount',
            'attribute' => 'name',
            'model' => BankAccount::class,
        ]);

        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Name',
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'amount',
            'label' => 'Amount',
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'made_on',
            'label' => 'Date',
            'type' => 'date',
        ]);

        $this->crud->addColumn([
            'name' => 'bank_account_id',
            'label' => 'Bank Account',
            'type' => 'select',
            'entity' => 'bankAccount',
            'attribute' => 'name',
            'model' => BankAccount::class,
        ]);

        // ------ CRUD FILTERS
        $this->crud->addFilter([ // dropdown filter
            'name' => 'direction',
            'type' => 'dropdown',
            'label'=> 'Direction'
        ], [
            2 => 'Expense',
            3 => 'Income',
        ], function($value) { // if the filter is active

            switch ($value) {
                case 1:
                    $this->crud->addClause('where', 'amount', '>', '0');
                    break;
                case 2:
                    $this->crud->addClause('where', 'amount', '<=', '0');
                    break;
                default:
                    break;
            }
        });

        $this->crud->addFilter([ // daterange filter
           'type' => 'date_range',
           'name' => 'from_to',
           'label'=> 'Date range'
         ],
         false,
         function($value) { // if the filter is active, apply these constraints
           $dates = json_decode($value);
           $this->crud->addClause('where', 'made_on', '>=', $dates->from);
           $this->crud->addClause('where', 'made_on', '<=', $dates->to);
         });

        $this->crud->addFilter([ // select2 filter
          'name' => 'bank_account_id',
          'type' => 'select2',
          'label'=> 'Bank Account'
        ], function() {
            return BankAccount::forUser()->get()->pluck('name', 'id')->toArray();
        }, function($bank_account_id) {
            $this->crud->addClause('where', 'bank_account_id', $bank_account_id);
        });
        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);
        // $this->crud->removeAllButtons();
        // $this->crud->removeAllButtonsFromStack('line');

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        $this->crud->addClause('forUser');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->addClause('withoutGlobalScopes');
        // $this->crud->addClause('withoutGlobalScope', VisibleScope::class);
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

    public function store(StoreRequest $request)
    {
        if ($request->has('in_out')) {
            $request->merge(['amount' => $request->input('amount') * $request->input('in_out')]);
        }

        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
