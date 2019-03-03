<?php

class User extends Model
{
  //Attributes
  private $id;
  private $pseudo;
  private $email;
  private $password;
  private $creation_date;

  public static function fecthAllUsers()
  {
    return parent::fetchAll('user', 'User');
  }

  public static function fetchUserById()
  {
    return parent::fetchById($id,'user','User');
  }

  public function save()
  {
    
  }

  public static function userPassLinked($pseudo, $password)
  {
      $statement = App::get('dbh')->prepare("SELECT COUNT(id), password FROM user WHERE pseudo = :pseudo");
      $statement->bindParam(':pseudo', $pseudo);
      $statement->execute();
      $res = $statement->fetchAll();  

      //die(var_dump($res));

      if($res[0][0] == 1)
      {
          return password_verify($password, $res[0]['password']);
      }
      else
      {
          return false;
      }
  }

  public static function pseudoAlreadyTaken($pseudo)
  {
      $statement = App::get('dbh')->prepare("SELECT COUNT(id) FROM user WHERE pseudo = :pseudo");
      $statement->bindParam(':pseudo', $pseudo);
      $statement->execute();
      $res = $statement->fetchAll();  
      
      return ($res[0][0] == 1) ? true : false;
  }

  public static function registerUser($pseudo, $email, $password)
  {
      $hash_pass = password_hash($password, PASSWORD_DEFAULT);

      $statement = App::get('dbh')->prepare("INSERT INTO user (pseudo, email, password) VALUES (:pseudo, :email, :password)");
      $statement->bindParam(':pseudo', $pseudo);
      $statement->bindParam(':email', $email);
      $statement->bindParam(':password', $hash_pass);
      return $statement->execute();
  }
}
