<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TaskRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Log;
use App\Models\Task;

/**
 * Class TaskCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TaskCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        Log::info('TaskCrudController setup');
        CRUD::setModel(\App\Models\Task::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/task');
        CRUD::setEntityNameStrings('task', 'tasks');
        
    }

    protected function setupShowOperation()
{
    CRUD::column('name');
    CRUD::column('created_at');
}

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // Ustawia kolumny automatycznie na podstawie tabeli w bazie danych
        CRUD::setFromDb();
    
        // Można dodać i skonfigurować kolumny, które mają być wyświetlane
        // CRUD::column('name')->type('string'); // Kolumna 'name' typu string
        // CRUD::column('description')->type('text'); // Kolumna 'description' typu text
        // CRUD::column('priority')->type('enum')->label('Priority'); // Kolumna 'priority' typu enum
        // CRUD::column('status')->type('enum')->label('Status'); // Kolumna 'status' typu enum
        // CRUD::column('due_date')->type('datetime')->label('Due Date'); // Kolumna 'due_date' typu datetime
        // CRUD::column('user_id')->type('relationship')->label('Assigned User'); // Kolumna 'user_id' jako relacja (obiekt)
    }
    

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TaskRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
