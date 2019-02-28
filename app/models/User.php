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

  public static function nbUser()
  {
      $statement = App::get('dbh')->prepare("SELECT COUNT(*) FROM user");
  }

  public static function pseudoAlreadyTaken($pesudo)
  {

  }
}
