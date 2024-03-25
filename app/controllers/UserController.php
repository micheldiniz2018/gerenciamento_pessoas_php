<?php

namespace app\controllers;

use app\models\User;

/**
** Declare the interface ImplementUserController.
**/
interface ImplementUserController{

    /**
     * Implements Store
     */
    public function store();

    /**
     * Implements Show All user
     */
    public function showAll();

    /**
     * Implements Delete user
     */
    public function delete();

    /**
     * Implements Update user
     */
    public function update();
}

class UserController implements ImplementUserController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $fields = [
            'name' => $_GET['name'],
            'email' => $_GET['email'],
            'password' => hash('sha256', $_GET['password']),
        ];

        $states = new User($fields);
        $response = $states->store();
        var_dump($response);
        return $response;
    }

    /**
     * Get all users.
     */
    public function showAll()
    {
        $all = [];

        $states = new User($all);
        $response = json_encode($states->allUsers());
        
        return $response;
    }

    /**
     * Get a user by id.
     */
    public function show()
    {
        $fields = ['id' => $_GET['id']];

        $user = new User($fields);
        $response = json_encode($user->show());
        
        return $response;
    }

    /**
     * Update a user by id.
     */
    public function update()
    {
        $fields = [
            'id' => $_GET['id'],
            'name' => $_GET['name'],
            'email' => $_GET['email'],
            'password' => hash('sha256', $_GET['password']),
        ];

        $user = new User($fields);
        $response = $user->update();
        var_dump($response);
        return $response;
    }

    /**
     * Delete a user by id using soft delete.
     */
    public function delete()
    {
        $fields = [
            'id' => $_GET['id'],
        ];

        $user = new User($fields);
        $response = $user->destroy();
        var_dump($response);
        return $response;
    }
}