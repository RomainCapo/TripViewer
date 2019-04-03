<?php

class User extends Model
{
  //Attributes
  private $id;
  private $pseudo;
  private $email;
  private $password;
  private $creation_date;

  //@summary retourne sous forme de tableau un fetchall de la table user
  //@return le résultat de la fonction de la classe model fetchAllUsers()
  public static function fecthAllUsers()
  {
    return parent::fetchAll('user', 'User');
  }

  //@summary retourne sous forme de tableau un fetch de la table user selon un id
  //@return le résultat de la fonction de fetchbyid de la classe model
  public static function fetchUserById()
  {
    return parent::fetchById($id,'user','User');
  }

  public function save() {}

  // Setters
  public function setId($value)
  {
      $this->id = $value;
  }

  public function setPseudo($value)
  {
      $this->pseudo = $value;
  }
  
  public function setEmail($value)
  {
      $this->email = $value;
  } 

  public function setCreationDate($value)
  {
      $this->creation_date = $value;
  }

  // Getters
  public function getId()
  {
      return $this->id;
  }

  public function getPseudo()
  {
      return $this->pseudo;
  }

  public function getEmail()
  {
      return $this->email;
  }

  public function getCreationDate()
  {
      return $this->creation_date;
  }  

  //@summary Vérifie que le pseudo et le mot de passe sont bien liés dans la base de données
  //@param $pseudo, $password  
  //@return true ou false : selon le résultat de la fonction password_verify()
  //@return false : si aucune ligne contenant le pseudo est trouvé
  public static function userPassLinked($pseudo, $password)
  {
      $statement = App::get('dbh')->prepare("SELECT COUNT(id), password FROM user WHERE pseudo = :pseudo");
      $statement->bindParam(':pseudo', $pseudo);
      $statement->execute();
      $res = $statement->fetchAll();

      if($res[0][0] == 1)
      {
          return password_verify($password, $res[0]['password']);
      }
      else
      {
          return false;
      }
  }

  //@summary retourne true ou false selon si le pseudo est déjà pris ou non
  //@param $pseudo : pseudo entré par l'utilisateur
  //@return true : si le pseudo existe déjà dans la base de donnée
  //@return false : si le pseudo n'est pas encore utilisé
  public static function pseudoAlreadyTaken($pseudo)
  {
      $statement = App::get('dbh')->prepare("SELECT COUNT(id) FROM user WHERE pseudo = :pseudo");
      $statement->bindParam(':pseudo', $pseudo);
      $statement->execute();
      $res = $statement->fetchAll();

      return ($res[0][0] == 1) ? true : false;
  }

  //@summary fonction d'ajout à la base de données
  //@param $pseudo, $email, $password
  //@return le résultat de la fonction execute(), donc 0 ou 1 
  public static function registerUser($pseudo, $email, $password)
  {
      $hash_pass = password_hash($password, PASSWORD_DEFAULT); // on hash le password pour plus de sécurité

      $statement = App::get('dbh')->prepare("INSERT INTO user (pseudo, email, password) VALUES (:pseudo, :email, :password)");
      $statement->bindParam(':pseudo', $pseudo);
      $statement->bindParam(':email', $email);
      $statement->bindParam(':password', $hash_pass);
      return $statement->execute();
  }

  //@summary Fonction permettant de récupérer l'id à partir d'un pseudo (Le pseudo est unique)
  //@param $pseudo est le pseudo de l'utilisateur dont on souhaite récupérer l'id
  //@return l'id de l'utilisateur
  public static function getIdByPseudo($pseudo)
  {
      $statement = App::get('dbh')->prepare("SELECT id FROM user WHERE pseudo = :pseudo");
      $statement->bindParam(':pseudo', $pseudo);
      $statement->execute();
      $res = $statement->fetchAll();
      return $res[0]['id'];
  }

  //@summary test si l'utilisateur est connecté sinon le redirige sur le formulaire de login
  public static function userIsConnected()
  {
    if(!isset($_SESSION['login']))
    {
      header('Location: login');
      exit(0);
    }
  }
}
