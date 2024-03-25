<?php 

namespace app\controllers;

use app\models\UserState;

/**
** Declare the interface ImplementUserStatesController.
**/
interface ImplementUserStatesController{

    /**
     * Implements Store
     */
    public function store();

    /**
     * Implements Show All state
     */
    public function showAll();

    /**
     * Implements Delete state
     */
    public function delete();

    /**
     * Implements Update state
     */
    public function update();
}

class UserStatesController implements ImplementUserStatesController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $fields = ['name' => $_GET['name']];

        $states = new UserState($fields);
        $response = $states->store();
        
        return $response;
    }

    /**
     * Get all states.
     */
    public function showAll()
    {
        $all = [];

        $states = new UserState($all);
        $response = json_encode($states->allStates());
        
        return $response;
    }

    /**
     * Get a state by id.
     */
    public function show()
    {
        $fields = ['id' => $_GET['id']];

        $states = new UserState($fields);
        $response = json_encode($states->show());
        
        return $response;
    }

    /**
     * Update a state by id.
     */
    public function update()
    {
        $fields = [
            'id' => $_GET['id'],
            'name' => $_GET['name'],
        ];

        $states = new UserState($fields);
        $response = json_encode($states->update());

        return $response;
    }

    /**
     * Delete a state by id using soft delete.
     */
    public function delete()
    {
        $fields = [
            'id' => $_GET['id'],
        ];

        $state = new UserState($fields);
        $response = json_encode($state->destroy());

        return $response;
    }
}