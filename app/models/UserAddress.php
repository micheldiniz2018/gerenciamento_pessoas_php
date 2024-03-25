<?php

namespace app\models;

use app\helpers\ConnectionMsql;

use PDO;
use PDOException;

date_default_timezone_set('America/Sao_Paulo');

/**
** Declare the interface ImplementUserAdrress.
**/
interface ImplementUserAdrress{

    /**
    ** Implements Setters.
    **/
    public function setUserStateId(string $user_state_id);
    public function setUserCityId(string $user_city_id);
    public function setPostalCode(string $postal_code);
    public function setDistrict(string $district);
    public function setNumber(string $number);
    public function setStreet(string $street);
    public function setUserId(int $user_id);
    public function setAddreesId(int $id);

    /**
    ** Implements Getters.
    **/
    public function getUserStateId();
    public function getUserCityId();
    public function getPostalCode();
    public function getAdreesId();
    public function getDistrict();
    public function getNumber();
    public function getStreet();
    public function getUserId();

    /**
    ** Implements Get all address.
    **/
    public function allAddresses();

    /**
    ** Implements Record a address.
    **/
    public function store();

    /**
    ** Implements Get a city.
    **/
    public function show();

    /**
    ** Implements Update the specified resource in storage.
    **/
    public function update();

    /**
    ** Implements Remove the specified resource from storage with soft delet.
    **/
    public function destroy();
}

class UserAddress extends ConnectionMsql implements ImplementUserAdrress
{

    /**
    ** Define Variables.
    **/
    private $user_state_id = '';
    private $user_city_id = '';
    private $postal_code = '';
    private $district = '';
    private $user_id = '';
    private $street = '';
    private $number = '';
    private $id = '';

    /**
    ** Setters.
    **/
    public function setPostalCode(string $postal_code)
    {
        $this->postal_code = $postal_code;
    }

    public function setDistrict(string $district)
    {
        $this->district = $district;
    }

    public function setUserStateId(string $user_state_id)
    {
        $this->user_state_id = $user_state_id;
    }

    public function setUserCityId(string $user_city_id)
    {
        $this->user_city_id = $user_city_id;
    }

    public function setNumber(string $number)
    {
        $this->number = $number;
    }

    public function setStreet(string $street)
    {
        $this->street = $street;
    }

    public function setAddreesId(int $id)
    {
        $this->id = $id;
    }

    public function setUserId(int $user_id)
    {
        $this->user_id = $user_id;
    }

    /**
    ** Getters.
    **/
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    public function getDistrict()
    {
        return $this->district;
    }

    public function getUserStateId()
    {
        return $this->user_state_id;
    }

    public function getUserCityId()
    {
        return $this->user_city_id;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getAdreesId()
    {
       return $this->id;
    }

    /**
    ** Set variables.
    **/
    function __construct($fields)
    {
        (!empty($fields['user_state_id'])) ? $this->setUserStateId($fields['user_state_id']) : null;
        (!empty($fields['user_city_id'])) ? $this->setUserCityId($fields['user_city_id']) : null;
        (!empty($fields['postal_code'])) ? $this->setPostalCode($fields['postal_code']) : null;
        (!empty($fields['district'])) ? $this->setDistrict($fields['district']) : null;
        (!empty($fields['user_id'])) ? $this->setUserId($fields['user_id']) : null;
        (!empty($fields['number'])) ? $this->setNumber($fields['number']) : null;
        (!empty($fields['street'])) ? $this->setStreet($fields['street']) : null;
        (!empty($fields['id'])) ? $this->setAddreesId($fields['id']) : null;
    }
 
    /**
    ** Get all address.
    **/
    public function allAddresses()
    {
        $connection = self::msql_connect();

        try{
            $sql = $connection->prepare('SELECT * FROM gereciar_pessoas.user_addresses where deleted_at is null;');
            $sql->execute();
            
        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }

        $fetch_adresses = $sql->fetchAll();
        $retorno = [];

        foreach($fetch_adresses as $key => $value){
            $retorno[] = [
                $key => $value
            ];
        }
        
        return $retorno;
    }

    /**
    ** Record a address.
    **/
    public function store()
    {
        $connection = self::msql_connect();
        
        try{
            $sql = $connection->prepare('insert into gereciar_pessoas.user_addresses(postal_code, district, user_state_id, user_city_id, number, street, user_id, created_at, updated_at) values (:postal_code, :district, :user_state_id, :user_city_id, :number, :street, :user_id, :created_at, :updated_at)');
            $sql->BindValue(":created_at", date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->BindValue(":updated_at", date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->BindValue(":postal_code", $this->getPostalCode(), PDO::PARAM_STR);
            $sql->BindValue(":district", $this->getDistrict(), PDO::PARAM_STR);
            $sql->BindValue(":user_state_id", $this->getUserStateId(), PDO::PARAM_STR);
            $sql->BindValue(":user_city_id", $this->getUserCityId(), PDO::PARAM_STR);
            $sql->BindValue(":number", $this->getNumber(), PDO::PARAM_STR);
            $sql->BindValue(":street", $this->getStreet(), PDO::PARAM_STR);
            $sql->BindValue(":user_id", $this->getUserId(), PDO::PARAM_STR);
            $sql->BindValue(":postal_code", $this->getPostalCode(), PDO::PARAM_STR);
            $sql->BindValue(":postal_code", $this->getPostalCode(), PDO::PARAM_STR);
            $sql->execute();

        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }

        return json_encode('Success in the insertion the state '.$this->getStreet());

    }

    /**
    ** Get a city.
    **/
    public function show()
    {
        $connection = self::msql_connect();

        try{
            $sql = $connection->prepare('SELECT * FROM gereciar_pessoas.user_addresses where deleted_at is null and id = :id;');
            $sql->BindValue(":id", $this->getAdreesId(), PDO::PARAM_INT);
            $sql->execute();
            
        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }
        
        $fetch_user = $sql->fetchAll();
        $retorno = [];
        
        foreach($fetch_user as $key => $value){
            $retorno[] = [
                $key => $value
            ];
        }
        
        return json_encode($retorno);
    }

    /**
    ** Update the specified resource in storage.
    **/
    public function update()
    {
        $connection = self::msql_connect();
        
        try{
            $sql = $connection->prepare('update gereciar_pessoas.user_addresses set postal_code = :postal_code, district = :district, user_state_id = :user_state_id, user_city_id = :user_city_id, number = :number, street = :street, user_id = :user_id, updated_at = :updated_at where id = :id and deleted_at is null;');
            $sql->BindValue(":updated_at", date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->BindValue(":postal_code", $this->getPostalCode(), PDO::PARAM_STR);
            $sql->BindValue(":district", $this->getDistrict(), PDO::PARAM_STR);
            $sql->BindValue(":user_state_id", $this->getUserStateId(), PDO::PARAM_STR);
            $sql->BindValue(":user_city_id", $this->getUserCityId(), PDO::PARAM_STR);
            $sql->BindValue(":number", $this->getNumber(), PDO::PARAM_STR);
            $sql->BindValue(":street", $this->getStreet(), PDO::PARAM_STR);
            $sql->BindValue(":user_id", $this->getUserId(), PDO::PARAM_STR);
            $sql->BindValue(":postal_code", $this->getPostalCode(), PDO::PARAM_STR);
            $sql->BindValue(":postal_code", $this->getPostalCode(), PDO::PARAM_STR);
            $sql->BindValue(":id", $this->getAdreesId(), PDO::PARAM_INT);
            $sql->execute();

        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }

        return json_encode('Success in the update the state to '.$this->getStreet());
    }

    /**
    ** Remove the specified resource from storage with soft delet.
    **/
    public function destroy()
    {
        $connection = self::msql_connect();
        
        try{
            $sql = $connection->prepare('update gereciar_pessoas.user_addresses set deleted_at = :deleted_at where id = :id and deleted_at is null;');
            $sql->BindValue(":deleted_at", date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->BindValue(":id", $this->getAdreesId(), PDO::PARAM_INT);
            $sql->execute();

        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }

        return json_encode('Success in the deleting the user');
    }
}