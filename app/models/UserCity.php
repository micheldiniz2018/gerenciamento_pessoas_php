<?php

namespace app\models;

use app\helpers\ConnectionMsql;

use PDO;
use PDOException;

date_default_timezone_set('America/Sao_Paulo');

/**
** Declare the interface ImplementUserCity.
**/
interface ImplementUserCity{

    /**
    ** Implements Setters.
    **/
    public function setCityName(string $user_state_id);
    public function setCityId(string $user_city_id);

    /**
    ** Implements Getters.
    **/
    public function getCityName();
    public function getCityId();

    /**
    ** Implements Get all cities.
    **/
    public function allCities();

    /**
    ** Implements Record a city.
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

class UserCity extends ConnectionMsql{

    /**
     * Define Setters and Getters.
     */
     private $city_name = '';
     private $id = '';
 
    public function setCityName($nome)
    {
        $this->city_name = $nome;
    }

    public function getCityName()
    {
        return $this->city_name;
    }

    public function setCityId($id)
    {
        $this->id = $id;
    }

    public function getCityId()
    {
       return $this->id;
    }

    /**
     * Set variables.
     */
    function __construct($fields)
    {
        (!empty($fields['name'])) ? $this->setCityName($fields['name']) : null;
        (!empty($fields['id'])) ? $this->setCityId($fields['id']) : null;
    }
 
    /**
     * Get all cities.
     */
    public function allCities()
    {
        $connection = self::msql_connect();

        try{
            $sql = $connection->prepare('SELECT * FROM gereciar_pessoas.user_cities where deleted_at is null;');
            $sql->execute();
            
        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }

        $fetch_cities = $sql->fetchAll();
        $retorno = [];

        foreach($fetch_cities as $key => $value){
            $retorno[] = [
                $key => $value
            ];
        }
        
        return json_encode($retorno);
    }

    /**
     * Record a city.
     */
    public function store()
    {
        $connection = self::msql_connect();
        
        try{
            $sql = $connection->prepare('insert into gereciar_pessoas.user_cities(name, created_at, updated_at) values (:name, :created_at, :updated_at)');
            $sql->BindValue(":created_at", date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->BindValue(":updated_at", date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->BindValue(":name", $this->getCityName(), PDO::PARAM_STR);
            $sql->execute();

        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }

        return json_encode('Success in the insertion the city '.$this->getCityName());

    }

    /**
     * Get a city.
     */
    public function show()
    {
        $connection = self::msql_connect();
        
        try{
            $sql = $connection->prepare('SELECT * FROM gereciar_pessoas.user_cities where deleted_at is null and id = :id;');
            $sql->BindValue(":id", $this->getCityId(), PDO::PARAM_INT);
            $sql->execute();
            
        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }
        
        $fetch_cities = $sql->fetchAll();
        $retorno = [];

        foreach($fetch_cities as $key => $value){
            $retorno[] = [
                $key => $value
            ];
        }
        var_dump($fetch_cities);
        return json_encode($retorno);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        $connection = self::msql_connect();
        
        try{
            $sql = $connection->prepare('update gereciar_pessoas.user_cities set name = :name, updated_at = :updated_at where id = :id and deleted_at is null;');
            $sql->BindValue(":updated_at", date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->BindValue(":name", $this->getCityName(), PDO::PARAM_STR);
            $sql->BindValue(":id", $this->getCityId(), PDO::PARAM_INT);
            $sql->execute();

        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }

        return json_encode('Success in the update the city to '.$this->getCityName());
    }

    /**
     * Remove the specified resource from storage with soft delet.
     */
    public function destroy()
    {
        $connection = self::msql_connect();
        
        try{
            $sql = $connection->prepare('update gereciar_pessoas.user_cities set deleted_at = :deleted_at where id = :id and deleted_at is null;');
            $sql->BindValue(":deleted_at", date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->BindValue(":id", $this->getCityId(), PDO::PARAM_INT);
            $sql->execute();

        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }

        return json_encode('Success in the deleting the city');

    }
}