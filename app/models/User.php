<?php

namespace app\models;

use app\helpers\ConnectionMsql;

use PDO;
use PDOException;

date_default_timezone_set('America/Sao_Paulo');

/**
** Declare the interface ImplementUser.
**/
interface ImplementUser{

    /**
    ** Implements Setters.
    **/
    public function setUserPassword(string $user_state_id);
    public function setUserEmail(string $user_city_id);
    public function setUserName(string $user_city_id);
    public function setUserId(string $user_city_id);

    /**
    ** Implements Getters.
    **/
    public function getUserPassword();
    public function getUserEmail();
    public function getUserName();
    public function getUserId();

    /**
    ** Implements Get all user.
    **/
    public function allUsers();

    /**
    ** Implements Record a user.
    **/
    public function store();

    /**
    ** Implements Get a user.
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

class User extends ConnectionMsql implements ImplementUser
{
    /**
    ** Define Setters and Getters.
    **/
    private $user_name = '';
    private $email = '';
    private $password = '';
    private $id = '';

    public function setUserPassword($password)
    {
        $this->password = $password;
    }

    public function setUserEmail($email)
    {
        $this->email = $email;
    }

    public function setUserName($nome)
    {
        $this->user_name = $nome;
    }

    public function setUserId($id)
    {
        $this->id = $id;
    }

    public function getUserPassword()
    {
        return $this->password;
    }

    public function getUserEmail()
    {
        return $this->email;
    }

    public function getUserName()
    {
        return $this->user_name;
    }

    public function getUserId()
    {
       return $this->id;
    }

    /**
    ** Set variables.
    **/
    function __construct($fields)
    {
        (!empty($fields['password'])) ? $this->setUserPassword($fields['password']) : null;
        (!empty($fields['email'])) ? $this->setUserEmail($fields['email']) : null;
        (!empty($fields['name'])) ? $this->setUserName($fields['name']) : null;
        (!empty($fields['id'])) ? $this->setUserId($fields['id']) : null;
    }
 
    /**
    ** Get all users.
    **/
    public function allUsers()
    {
        $connection = self::msql_connect();

        try{
            $sql = $connection->prepare('SELECT * FROM gereciar_pessoas.users where deleted_at is null;');
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
        
        return $retorno;
    }

    /**
    ** Record a city.
    **/
    public function store()
    {
        $connection = self::msql_connect();
        
        try{
            $sql = $connection->prepare('insert into gereciar_pessoas.users(name, email, password, created_at, updated_at) values (:name, :email, :password, :created_at, :updated_at)');
            $sql->BindValue(":created_at", date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->BindValue(":updated_at", date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->BindValue(":email", $this->getUserEmail(), PDO::PARAM_STR);
            $sql->BindValue(":password", $this->getUserPassword(), PDO::PARAM_STR);
            $sql->BindValue(":name", $this->getUserName(), PDO::PARAM_STR);
            $sql->execute();

        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }

        return json_encode('Success in the insertion the state '.$this->getUserName());

    }

    /**
    ** Get a city.
    **/
    public function show()
    {
        $connection = self::msql_connect();
        
        try{
            $sql = $connection->prepare('SELECT * FROM gereciar_pessoas.users where deleted_at is null and id = :id;');
            $sql->BindValue(":id", $this->getUserId(), PDO::PARAM_INT);
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
            $sql = $connection->prepare('update gereciar_pessoas.users set name = :name, email = :email, password = :password, updated_at = :updated_at where id = :id and deleted_at is null;');
            $sql->BindValue(":updated_at", date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->BindValue(":name", $this->getUserName(), PDO::PARAM_STR);
            $sql->BindValue(":email", $this->getUserEmail(), PDO::PARAM_STR);
            $sql->BindValue(":password", $this->getUserPassword(), PDO::PARAM_STR);
            $sql->BindValue(":id", $this->getUserId(), PDO::PARAM_INT);
            $sql->execute();

        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }

        return json_encode('Success in the update the state to '.$this->getUserName());
    }

    /**
    ** Remove the specified resource from storage with soft delet.
    **/
    public function destroy()
    {
        $connection = self::msql_connect();
        
        try{
            $sql = $connection->prepare('update gereciar_pessoas.users set deleted_at = :deleted_at where id = :id and deleted_at is null;');
            $sql->BindValue(":deleted_at", date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $sql->BindValue(":id", $this->getUserId(), PDO::PARAM_INT);
            $sql->execute();

        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }

        return json_encode('Success in the deleting the user');
    }

}