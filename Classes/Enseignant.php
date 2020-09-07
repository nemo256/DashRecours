<?php

require_once ('.workingDir.info.php');
basename(dirname(__FILE__)) != $projectDir ?
  $level = 2 :
  $level = 1;

require_once (dirname(__FILE__, $level) . '/Classes/User.php');

// -- -- -- -- -- -- //
// Enseignant class  //
// -- -- -- -- -- -- //

class enseignant extends user
{
  public function __construct($info)
  {
    if (!is_array($info))
      $this->id = $info;
    elseif (isset($info['updatePR']))
    {
      if (isset($info['idadm']))
      {
        parent::__construct($info);

        $this->checkEmptyFieldsENS('P');
        $this->checkMatricule('P');
        $this->checkDeplome('P');
      }
      else
        $this->info = $info;
    }
    else
    {
      parent::__construct($info);

      $this->checkEmptyFieldsENS();
      $this->checkMatricule();
      $this->checkDeplome();
    }
  }

  public function getInfo()
  {
    $query = 'select * from ENS where id = ?';
    $statement = $this->connect()->prepare($query);
    $statement->execute([$this->id]);
    return $statement->fetchALL()[0];
  }

  public function destroy() {}

  // Validating special enseignant inputs! //
  // Checking for empty fields which are required! //
  private function checkEmptyFieldsENS($loc = 'RF')
  {
    if (empty($this->info['matricule']) || empty($this->info['deplome']) || empty($this->info['grade']))
      redirect (
        $GLOBALS['MSG']['EF'], 
        'danger', 
        $GLOBALS['LOC'][$loc], 
        '?nom='.$this->info['nom'].'&prenom='.$this->info['prenom'].'&ddn='.$this->info['ddn'].'&sex='.$this->info['sexe'].'&add='.$this->info['adresse'].'&tel='.$this->info['tel']
      );
  }

  // Checking for valid id (matricule)! //
  private function checkMatricule($loc = 'RF')
  {
    if (checkAlphaNum($this->info['matricule']))
      redirect (
        $GLOBALS['MSG']['IM'] . '<span class="ml-3">(Enseignant)</span>', 
        'danger', 
        $GLOBALS['LOC'][$loc], 
        '?nom='.$this->info['nom'].'&prenom='.$this->info['prenom'].'&ddn='.$this->info['ddn'].'&sex='.$this->info['sexe'].'&add='.$this->info['adresse'].'&tel='.$this->info['tel']
      );
  }

  // Checking for valid groupe! //
  private function checkDeplome($loc = 'RF')
  {
    if (checkAlphaNoSpace($this->info['deplome']))
      redirect (
        $GLOBALS['MSG']['ID'], 
        'danger', 
        $GLOBALS['LOC'][$loc], 
        '?nom='.$this->info['nom'].'&prenom='.$this->info['prenom'].'&ddn='.$this->info['ddn'].'&sex='.$this->info['sexe'].'&add='.$this->info['adresse'].'&tel='.$this->info['tel']
      );
  }

  // Data related methods! //
  public function insert()
  {
    $query = "insert into ENS (id, username, matricule, nom, prenom, email, ddn, sexe, adresse, tel, deplome, grade, photo) values (?,?,?,?,?,?,?,?,?,?,?,?,?)";
    // Using prepared statements will increase security
    // against sql injection attacks!
    $statement = $this->connect()->prepare($query);
    $statement->execute([
      $this->info['id'], 
      $this->info['username'], 
      $this->info['matricule'], 
      $this->info['nom'], 
      $this->info['prenom'], 
      $this->info['email'], 
      $this->info['ddn'], 
      $this->info['sexe'], 
      $this->info['adresse'], 
      $this->info['tel'], 
      $this->info['deplome'], 
      $this->info['grade'], 
      $this->info['photo']
    ]);

    if (!isset($this->info['idadm']))
      $_SESSION['TU'] = $this->info['type'];

    $_SESSION['message'] = "Registered successfully!";
    $_SESSION['type'] = "success";

    if (!isset($this->info['idadm']))
      header('Location: ../index.php?register=success');
    else
      header('Location: ../profile.php?register=success');
  }

  // Updating teacher infos! //
  public function update()
  {
    $query = "update ENS set nom = ?, prenom = ?, email = ?, photo = ? where id = ?";
    // Using prepared statements will increase security
    // against sql injection attacks!
    $statement = $this->connect()->prepare($query);
    $statement->execute([
      $this->info['nom'],
      $this->info['prenom'],
      $this->info['email'],
      $this->info['photo'],
      $this->info['id']
    ]);

    // Redirecting with success message! //
    if (!isset($info['idadm']))
    {
      if (!empty($this->info['pwd']))
        redirect (
          $GLOBALS['MSG']['PC'], 
          'success', 
          $GLOBALS['LOC']['LO'], 
          '?passwordChanged=true'
        );
      else
      {
        $_SESSION['email'] = $this->info['email'];
        redirect (
          $GLOBALS['MSG']['US'], 
          'success', 
          $GLOBALS['LOC']['P'], 
          '?updatedSuccessfully'
        );
      }
    }
    else
    {
      $_SESSION['message'] = '<b>Updated Successfully!</b>';
      $_SESSION['type'] = 'success';
    }
  }
}


?>
