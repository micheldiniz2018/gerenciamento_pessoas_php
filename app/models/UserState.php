<?php

namespace app\models;

use app\helpers\ConnectionMsql;

use PDO;
use PDOException;

date_default_timezone_set('America/Sao_Paulo');

/**
** Declare the interface ImplementUserState.
**/
interface ImplementUserState{

    /**
    ** Implements Setters.
    **/
    public function setStateName(string $user_state_id);
    public function setStateId(string $user_city_id);

    /**
    ** Implements Getters.
    **/
    public function getStateName();
    public function getStateId();

    /**
    ** Implements Get all state.
    **/
    public function allStates();

    /**
    ** Implements Record a state.
    **/
    public function store();

    /**
    ** Implements Get a state.
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

class UserState extends ConnectionMsql implements ImplementUserState
{
    /**
     * Define Setters and Getters.
     */
     private $state_name = '';
     private $id = '';
 
    public function setStateName($nome)
    {
        $this->state_name = $nome;
    }

    public function getStateName()
    {
        return $this->state_name;
    }

    public function setStateId($id)
    {
        $this->id = $id;
    }

    public function getStateId()
    {
       return $this->id;
    }

    /**
     * Set variables.
     */
    function __construct($fields)
    {
        (!empty($fields['name'])) ? $this->setStateName($fields['name']) : null;
        (!empty($fields['id'])) ? $this->setStateId($fields['id']) : null;
    }
 
    /**
     * Get all cities.
     */
    public function allStates()
    {
        $connection = self::msql_connect();

        try{
            $sql = $connection->prepare('SELECT * FROM gereciar_pessoas.user_states where deleted_at is null;');
            $sql->execute();
            
        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }

        $fetch_states = $sql->fetchAll();
        $retorno = [];

        foreach($fetch_states as $key => $value){
            $retorno[] = [
                $key => $value
            ];
        }
        
        return $retorno;
    }

    /**
     * Record a city.
     */
    public function store()
    {
        $connection = self::msql_connect();
        
        try{
            $sql = $connection->prepare('insert into gereciar_pessoas.user_states(name, created_at, updated_at) values (:name, :created_at, :updated_at)');
            $sql->BindValue(":created_at", date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->BindValue(":updated_at", date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->BindValue(":name", $this->getStateName(), PDO::PARAM_STR);
            $sql->execute();

        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }

        return json_encode('Success in the insertion the state '.$this->getStateName());

    }

    /**
     * Get a city.
     */
    public function show()
    {
        $connection = self::msql_connect();
        
        try{
            $sql = $connection->prepare('SELECT * FROM gereciar_pessoas.user_states where deleted_at is null and id = :id;');
            $sql->BindValue(":id", $this->getStateId(), PDO::PARAM_INT);
            $sql->execute();
            
        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }
        
        $fetch_state = $sql->fetchAll();
        $retorno = [];

        foreach($fetch_state as $key => $value){
            $retorno[] = [
                $key => $value
            ];
        }
        
        return json_encode($retorno);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        $connection = self::msql_connect();
        
        try{
            $sql = $connection->prepare('update gereciar_pessoas.user_states set name = :name, updated_at = :updated_at where id = :id and deleted_at is null;');
            $sql->BindValue(":updated_at", date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->BindValue(":name", $this->getStateName(), PDO::PARAM_STR);
            $sql->BindValue(":id", $this->getStateId(), PDO::PARAM_INT);
            $sql->execute();

        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }

        return json_encode('Success in the update the state to '.$this->getStateName());
    }

    /**
     * Remove the specified resource from storage with soft delet.
     */
    public function destroy()
    {
        $connection = self::msql_connect();
        
        try{
            $sql = $connection->prepare('update gereciar_pessoas.user_states set deleted_at = :deleted_at where id = :id and deleted_at is null;');
            $sql->BindValue(":deleted_at", date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->BindValue(":id", $this->getStateId(), PDO::PARAM_INT);
            $sql->execute();

        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }

        return json_encode('Success in the deleting the state');

    }
}