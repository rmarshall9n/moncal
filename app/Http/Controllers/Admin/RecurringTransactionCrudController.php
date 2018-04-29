<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\RecurringTransactionRequest as StoreRequest;
use App\Http\Requests\RecurringTransactionRequest as UpdateRequest;

class RecurringTransactionCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\RecurringTransaction');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/recurring-transaction');
        $this->crud->setEntityNameStrings('recurring transaction', 'recurring transactions');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        // ------ CRUD FIELDS
        $this->crud->addField([
            'name' => 'name',
            'label' => 'Name',
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
        ]);

        $this->crud->addField([
            'name' => 'start_on',
            'label' => 'Start On',
            'type' => 'date_picker'
        ]);

        $this->crud->addField([
            'name' => 'repeat_increment',
            'label' => 'Repeat Increment',
            'type' => 'number',
        ]);

        $this->crud->addField([
            'name' => 'repeat_type',
            'label' => "Repeat Type",
            'type' => 'select_from_array',
            'options' => [
                'd' => 'Day',
                'w' => 'Week',
                'm' => 'Month',
                'y' => 'Year',
            ],
            'allows_null' => false,
            'default' => 'm',
        ]);

        $this->crud->addField([
            'name' => 'num_repeats',
            'label' => 'Number of repeats',
            'type' => 'number',
        ]);

        $this->crud->addField([
            'name' => 'end_on',
            'label' => 'End On',
            'type' => 'date_picker'
        ]);

        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Name',
        ]);

        $this->crud->addColumn([
            'name' => 'amount',
            'label' => 'Amount',
            'type' => 'number',
        ]);

        $this->crud->addColumn([
            'name' => 'start_on',
            'label' => 'Start On',
            'type' => 'datetime'
        ]);

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
        // $this->crud->addClause('active');
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
        // your additional operations before save here
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
