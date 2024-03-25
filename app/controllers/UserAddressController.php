<?php 

namespace app\controllers;

use app\models\UserAddress;

/**
** Declare the interface ImplementUserAddressController.
**/
interface ImplementUserAddressController{

    /**
     * Implements Store
     */
    public function store();

    /**
     * Implements Show All Address
     */
    public function showAll();

    /**
     * Implements Delete Address
     */
    public function delete();

    /**
     * Implements Update Address
     */
    public function update();
}

class UserAddressController implements ImplementUserAddressController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $fields = [
            'user_state_id' => $_GET['user_state_id'],
            'user_city_id' => $_GET['user_city_id'],
            'postal_code' => $_GET['postal_code'],
            'district' => $_GET['district'],
            'user_id' => $_GET['user_id'],
            'number' => $_GET['number'],
            'street' => $_GET['street'],
        ];

        $states = new UserAddress($fields);
        $response = $states->store();
        
        return $response;
    }

    /**
     * Get all states.
     */
    public function showAll()
    {
        $all = [];

        $address = new UserAddress($all);
        $response = json_encode($address->allAddresses());
        
        return $response;
    }

    /**
     * Get a state by id.
     */
    public function show()
    {
        $fields = ['id' => $_GET['id']];

        $address = new UserAddress($fields);
        $response = json_encode($address->show());

        return $response;
    }

    /**
     * Get a state by id.
     */
    public function update()
    {
        $fields = [
            'user_state_id' => $_GET['user_state_id'],
            'user_city_id' => $_GET['user_city_id'],
            'postal_code' => $_GET['postal_code'],
            'district' => $_GET['district'],
            'user_id' => $_GET['user_id'],
            'number' => $_GET['number'],
            'street' => $_GET['street'],
            'id' => $_GET['id'],
        ];

        $states = new UserAddress($fields);
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

        $address = new UserAddress($fields);
        $response = json_encode($address->destroy());

        return $response;
    }

}