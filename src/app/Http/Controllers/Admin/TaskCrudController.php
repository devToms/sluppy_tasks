<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Task;

class TaskCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(Task::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/task');
        CRUD::setEntityNameStrings('task', 'tasks');
    }

    protected function setupListOperation()
    {
        CRUD::column('name')->label('Nazwa');
        CRUD::column('description')->label('Opis');
        CRUD::column('priority')->label('Priorytet');
        CRUD::column('status')->label('Status');
        CRUD::column('due_date')->label('Termin wykonania');
        CRUD::column('user_id')->label('Użytkownik')
            ->type('select')
            ->entity('user')
            ->attribute('name');
    }

    protected function setupCreateOperation()
    {
        CRUD::field('name')->label('Nazwa')->type('text');
        CRUD::field('description')->label('Opis')->type('textarea');
        CRUD::field('priority')->label('Priorytet')->type('enum')->options([
            'low' => 'Niski',
            'medium' => 'Średni',
            'high' => 'Wysoki',
        ]);
        CRUD::field('status')->label('Status')->type('enum')->options([
            'to-do' => 'Do zrobienia',
            'in progress' => 'W trakcie',
            'done' => 'Zakończone',
        ]);
        CRUD::field('due_date')->label('Termin wykonania')->type('date');
        CRUD::field('user_id')->label('Użytkownik')->type('select')
            ->model(User::class)
            ->attribute('name');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}