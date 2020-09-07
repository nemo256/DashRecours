<?php

require_once ('.workingDir.info.php');
basename(dirname(__FILE__)) != $projectDir ?
  $level = 2 :
  $level = 1;

require_once (dirname(__FILE__, $level) . '/Include/db.php');
require_once (dirname(__FILE__, $level) . '/Include/main.php');

// -- -- -- -- //
// User class  //
// -- -- -- -- //

abstract class user extends database
{
  protected $info;

  // Constructing a general user //
  public function __construct($info)
  {
    $this->info = $info;

    // Checking all submitted informations! //
    if (isset($info['idadm']))
    {
      $this->checkEmptyFields('P');
      $this->checkName('P');
      $this->checkFname('P');
      $this->checkEmail('P');
      $this->checkTel('P');
    }
    else
    {
      $this->checkEmptyFields();
      $this->checkName();
      $this->checkFname();
      $this->checkEmail();
      $this->checkTel();
    }
  }
  
  // Sadly php does not support Constructor overloading //
  // Abstract methods for polymorphic child classes //
  abstract protected function getInfo();
  abstract protected function insert();
  abstract protected function update();
  abstract protected function destroy($userID);

  // updating user //
  public function updateUsers()
  {
    $query = "update users set type = ?, email = ?, photo = ? where id = ?";
    $statement = $this->connect()->prepare($query);
    $statement->execute([
      $this->info['type'],
      $this->info['email'],
      $this->info['photo'],
      $this->info['id']
    ]);
  }

  // Verification methods! //
  // checking for any empty fields //
  protected function checkEmptyFields($loc = 'RF')
  {
    if (empty($this->info['nom']) || empty($this->info['prenom']) || empty($this->info['ddn']) || empty($this->info['adresse']) || empty($this->info['tel']) || empty($this->info['sexe']) || empty($this->info['type']))
      redirect (
        $GLOBALS['MSG']['EF'], 
        'danger', 
        $GLOBALS['LOC'][$loc], 
        '?nom='.$this->info['nom'].'&prenom='.$this->info['prenom'].'&ddn='.$this->info['ddn'].'&sex='.$this->info['sexe'].'&add='.$this->info['adresse'].'&tel='.$this->info['tel']
      );
  }

  // checking if the name is valid //
  protected function checkName($loc = 'RF')
  {
    if (checkAlphaNoSpace($this->info['nom']))
      redirect (
        $GLOBALS['MSG']['IN'], 
        'danger', 
        $GLOBALS['LOC'][$loc], 
        '?prenom='.$this->info['prenom'].'&ddn='.$this->info['ddn'].'&sex='.$this->info['sexe'].'&add='.$this->info['adresse'].'&tel='.$this->info['tel']
      );
  }

  // checking if the first name is valid //
  protected function checkFname($loc = 'RF')
  {
    if (checkAlphaNoSpace($this->info['prenom']))
      redirect (
        $GLOBALS['MSG']['IP'], 
        'danger', 
        $GLOBALS['LOC'][$loc], 
        '?nom='.$this->info['nom'].'&ddn='.$this->info['ddn'].'&sex='.$this->info['sexe'].'&add='.$this->info['adresse'].'&tel='.$this->info['tel']
      );
  }

  // checking if the email is valid //
  protected function checkEmail($loc = 'RF')
  {
    if (checkMail($this->info['email']))
      redirect (
        $GLOBALS['MSG']['IE'], 
        'danger', 
        $GLOBALS['LOC'][$loc], 
        '?nom='.$this->info['nom'].'&prenom='.$this->info['prenom'].'&ddn='.$this->info['ddn'].'&sex='.$this->info['sexe'].'&add='.$this->info['adresse'].'&tel='.$this->info['tel']
      );
  }

  // checking if the phone number is valid //
  protected function checkTel($loc = 'RF')
  {
    if (checkNum($this->info['tel']))
      redirect (
        $GLOBALS['MSG']['IPN'], 
        'danger', 
        $GLOBALS['LOC'][$loc], 
        '&nom='.$this->info['nom'].'&prenom='.$this->info['prenom'].'&ddn='.$this->info['ddn'].'&sex='.$this->info['sexe'].'&add='.$this->info['adresse']
      );
  }
}


?>
