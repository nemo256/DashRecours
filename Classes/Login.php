<?php

require_once ('.workingDir.info.php');
basename(dirname(__FILE__)) != $projectDir ?
  $level = 2 :
  $level = 1;

require_once (dirname(__FILE__, $level) . '/Include/db.php');
require_once (dirname(__FILE__, $level) . '/Include/main.php');

// -- -- -- -- //
// Login class //
// -- -- -- -- //

class login extends database 
{
  public function __construct($info)
  {
    $this->info = $info;

    // checking all infos here //
    $this->checkEmptyFields();
    $this->checkUsernameEmail();
    $this->checkAllInfo();
  }

  // checking for any empty fields //
  private function checkEmptyFields()
  {
    if (empty($this->info['username']) || empty($this->info['pwd']))
      redirect(
        $GLOBALS['MSG']['EF'], 
        'danger', 
        $GLOBALS['LOC']['L'], 
        '?user='.$this->info['username']
      );
  }

  // checking if the username or email is valid //
  private function checkUsernameEmail()
  {
    if (checkAlphaNum($this->info['username']) && checkMail($this->info['email']))
      redirect (
        $GLOBALS['MSG']['IUE'], 
        'danger', 
        $GLOBALS['LOC']['L'], 
        '?invalidUsernameEmail'
      );
  }

  // checking if all infos are correct! //
  private function checkAllInfo()
  {
    $query = 'select * from users';
    $statement = $this->connect()->prepare($query);
    $statement->execute();
    foreach ($statement->fetchALL() as $key => $row)
    {
      if ($this->info['username'] == $row['username'] || $this->info['username'] == $row['email'])
      {
        $pwdCheck = password_verify($this->info['pwd'], $row['pwd']);
        if (!$pwdCheck)
          redirect (
            $GLOBALS['MSG']['WP'], 
            'danger', 
            $GLOBALS['LOC']['L'], 
            '?user='.$this->info['username']
          );
        else
        {
          $_SESSION['id'] = $row['id'];
          $_SESSION['username'] = $row['username'];
          $_SESSION['email'] = $row['email'];
          $_SESSION['TU'] = $row['type'];
          header("Location: ../index.php?login=success");
          exit();
        }
      }
    }

    // Username not found in database!
    redirect (
      $GLOBALS['MSG']['UENR'], 
      'danger', 
      $GLOBALS['LOC']['L'], 
      '?notRegistered'
    );
  }
}



?>
