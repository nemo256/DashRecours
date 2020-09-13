<?php

require_once ('.workingDir.info.php');
basename(dirname(__FILE__)) != $projectDir ?
  $level = 2 :
  $level = 1;

require_once (dirname(__FILE__, $level) . '/Include/db.php');
require_once (dirname(__FILE__, $level) . '/Include/main.php');

// -- -- -- -- -- //
// Visitor class  //
// -- -- -- -- -- //

class visitor extends database 
{
  private $info;

  public function __construct($info)
  {
    if (!is_array($info))
      $this->id = $info;
    elseif (!isset($info['id']))
    {
      $this->info = $info;

      // checking all infos here //
      if (isset($info['location']))
      {
        $this->checkEmptyFields($info['location']);
        $this->checkUsername($info['location']);
        $this->checkEmail($info['location']);
        $this->checkPwd($info['location']);
        $this->checkPwdMatch($info['location']);
        $this->checkIfTaken($info['location']);
      }
      else
      {
        $this->checkEmptyFields();
        $this->checkUsername();
        $this->checkEmail();
        $this->checkPwd();
        $this->checkPwdMatch();
        $this->checkIfTaken();
      }
      $this->hashPwd();
    } 
    else
    {
      $this->info = $info;

      $this->checkEmptyFieldsPR();
      $this->checkEmail('P');
      $this->checkNom();
      $this->checkPrenom();
      if (isset($this->info['pwd']))
        { $this->checkPwd('P'); $this->checkPwdMatch('P'); }
    }
  }

  // checking for any empty fields //
  private function checkEmptyFields($loc = 'R')
  {
    if (empty($this->info['username']) || empty($this->info['email']) || empty($this->info['pwd']) || empty($this->info['pwd2']))
      redirect(
        $GLOBALS['MSG']['EF'], 
        'danger', 
        $GLOBALS['LOC'][$loc], 
        '?user='.$this->info['username'].'&mail='.$this->info['email']
      );
  }

  // checking for any empty fields for updating! //
  private function checkEmptyFieldsPR()
  {
    if (empty($this->info['nom']) || empty($this->info['prenom']) || empty($this->info['email']))
      redirect(
        $GLOBALS['MSG']['EF'], 
        'danger', 
        $GLOBALS['LOC']['P'], 
        '?emptyFields'
      );
  }

  // checking if nom is valid //
  private function checkNom()
  {
    if (checkAlphaNoSpace($this->info['nom']))
      redirect (
        $GLOBALS['MSG']['IN'], 
        'danger', 
        $GLOBALS['LOC']['P'], 
        '?invalidNom'
      );
  }

  // checking if prenom is valid //
  private function checkPrenom()
  {
    if (checkAlphaNoSpace($this->info['prenom']))
      redirect (
        $GLOBALS['MSG']['IP'], 
        'danger', 
        $GLOBALS['LOC']['P'], 
        '?invalidPrenom'
      );
  }

  // checking if the username is valid //
  private function checkUsername($loc = 'R')
  {
    if (checkAlphaNum($this->info['username']))
      redirect (
        $GLOBALS['MSG']['IU'], 
        'danger', 
        $GLOBALS['LOC'][$loc], 
        '?mail='.$this->info['email']
      );
  }

  // checking if the email is valid //
  private function checkEmail($loc = 'R')
  {
    if (checkMail($this->info['email']))
      redirect (
        $GLOBALS['MSG']['IE'], 
        'danger', 
        $GLOBALS['LOC'][$loc], 
        '?user='.$this->info['username']
      );
  }

  // checking if the password is valid //
  private function checkPwd($loc = 'R')
  {
    if (checkAlphaNum($this->info['pwd']))
      redirect (
        $GLOBALS['MSG']['IPP'], 
        'warning', 
        $GLOBALS['LOC'][$loc], 
        '?user='.$this->info['username'].'&mail='.$this->info['email']
      );
  }

  // checking if passwords match//
  private function checkPwdMatch($loc = 'R')
  {
    if ($this->info['pwd'] !== $this->info['pwd2'])
      redirect (
        $GLOBALS['MSG']['PDNM'], 
        'danger', 
        $GLOBALS['LOC'][$loc], 
        '?user='.$this->info['username'].'&mail='.$this->info['email']
      );
  }

  // Getting all users from DB! //
  public function getUsers()
  {
    $query = 'select * from users';
    $statement = $this->connect()->prepare($query);
    $statement->execute();
    return $statement->fetchALL();
  }

  // checking if already registered //
  private function checkIfTaken($loc = 'R')
  {
    $users = $this->getUsers();
    foreach ($users as $key => $user)
    {
      // Username Taken //
      if ($this->info['username'] == $user['username'])
        redirect (
          $GLOBALS['MSG']['UT'], 
          'danger', 
          $GLOBALS['LOC'][$loc], 
          '?mail='.$this->info['email']
        );

      // Email Taken //
      elseif ($this->info['email'] == $user['email'])
        redirect (
          $GLOBALS['MSG']['ET'], 
          'danger', 
          $GLOBALS['LOC'][$loc], 
          '?user='.$this->info['username']
        );
    }
  }

  public function getId()
  {
    $query = 'select * from users';
    $statement = $this->connect()->prepare($query);
    $statement->execute([]);
    return count($statement->fetchALL()) + 1;
  }

  // Hash password //
  private function hashPwd()
  {
    $this->info['pwd'] = password_hash($this->info['pwd'], PASSWORD_DEFAULT);
  }

  // Inserting a `visitor` / `user` //
  public function insert()
  {
    $query = "insert into users(username, email, pwd) values (?,?,?)";
    $statement = $this->connect()->prepare($query);
    $statement->execute([
      $this->info['username'],
      $this->info['email'],
      $this->info['pwd']
    ]);

    // Redirecting with success message! //
    if (!isset($this->info['location']))
      redirect (
        $GLOBALS['MSG']['RS'], 
        'success', 
        $GLOBALS['LOC']['L'], 
        '?registeredSuccessfully'
      );
  }

  // Updating a `visitor` \ `user` //
  public function update($picture)
  {
    if (!empty($this->info['pwd']))
    {
      $this->hashPwd();
      $query = "update users set email = ?, photo = ?, pwd = ? where id = ?";
    }
    else
      $query = "update users set email = ?, photo = ? where id = ?";
    $statement = $this->connect()->prepare($query);
    if (!empty($this->info['pwd']))
      $statement->execute([
        $this->info['email'],
        $picture,
        $this->info['pwd'],
        $this->info['id']
      ]);

    else
      $statement->execute([
        $this->info['email'],
        $picture,
        $this->info['id']
      ]);
  }
}



?>
