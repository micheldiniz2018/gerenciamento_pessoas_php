<?php

namespace app\controllers;

use app\models\UserCity;

/**
** Declare the interface ImplementUserCitiesController.
**/
interface ImplementUserCitiesController{

    /**
     * Implements Store
     */
    public function store();

    /**
     * Implements Show All city
     */
    public function showAll();

    /**
     * Implements Delete city
     */
    public function delete();

    /**
     * Implements Update city
     */
    public function update();
}

class UserCitiesController implements ImplementUserCitiesController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $fields = ['name' => $_GET['name']];

        $cities = new UserCity($fields);
        $response = $cities->store();

        return $response;
    }

    /**
     * Get all cities.
     */
    public function showAll()
    {
        $all = [];

        $cities = new UserCity($all);
        $response = json_encode($cities->allCities());

        return $response;
    }

    /**
     * Get a city by id.
     */
    public function show()
    {
        $fields = ['id' => $_GET['id']];

        $cities = new UserCity($fields);
        $response = json_encode($cities->show());
        
        return $response;
    }

    /**
     * Get a city by id.
     */
    public function update()
    {
        $fields = [
            'id' => $_GET['id'],
            'name' => $_GET['name'],
        ];

        $cities = new UserCity($fields);
        $response = json_encode($cities->update());
        var_dump($response);
        return $response;
    }

    /**
     * Delete a city by id using soft delete.
     */
    public function delete()
    {
        $fields = [
            'id' => $_GET['id'],
        ];

        $cities = new UserCity($fields);
        $response = json_encode($cities->destroy());
        var_dump($response);
        return $response;
    }
}