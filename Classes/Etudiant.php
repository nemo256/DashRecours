<?php

require_once ('.workingDir.info.php');
basename(dirname(__FILE__)) != $projectDir ?
  $level = 2 :
  $level = 1;

require_once (dirname(__FILE__, $level) . '/Classes/User.php');

// -- -- -- -- -- //
// Etudiant class //
// -- -- -- -- -- //

class etudiant extends user
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

        $this->checkEmptyFieldsET('P');
        $this->checkMatricule('P');
        $this->checkGroupe('P');
      }
      else
      {
        $this->info = $info;

        $this->checkEmptyFieldsPR();
        $this->checkGroupe();
      }
    }
    else
    {
      parent::__construct($info);

      $this->checkEmptyFieldsET();
      $this->checkMatricule();
      $this->checkGroupe();
    }
  }

  public function getInfo()
  {
    $query = 'select * from ET where id = ?';
    $statement = $this->connect()->prepare($query);
    $statement->execute([$this->id]);
    return $statement->fetchALL()[0];
  }

  public function destroy() {}

  // Validating special etudiant inputs! //
  // Checking for empty fields which are required! //
  private function checkEmptyFieldsET($loc = 'RF')
  {
    if (empty($this->info['matricule']) || empty($this->info['speciality']) || empty($this->info['groupe']))
      redirect (
        $GLOBALS['MSG']['EF'], 
        'danger', 
        $GLOBALS['LOC'][$loc], 
        '?nom='.$this->info['nom'].'&prenom='.$this->info['prenom'].'&ddn='.$this->info['ddn'].'&sex='.$this->info['sexe'].'&add='.$this->info['adresse'].'&tel='.$this->info['tel']
      );
  }

  // Checking for empty fields for updating parameters! //
  private function checkEmptyFieldsPR()
  {
    if (empty($this->info['speciality']) || empty($this->info['groupe']))
      redirect (
        $GLOBALS['MSG']['EF'], 
        'danger', 
        $GLOBALS['LOC']['P'], 
        '?nom='.$this->info['nom'].'&prenom='.$this->info['prenom'].'&spc='.$this->info['speciality'].'&grp='.$this->info['groupe']
      );
  }

  // Checking for valid id (matricule)! //
  private function checkMatricule($loc = 'RF')
  {
    if (checkAlphaNum($this->info['matricule']))
      redirect (
        $GLOBALS['MSG']['IM'], 
        'danger', 
        $GLOBALS['LOC'][$loc], 
        '?nom='.$this->info['nom'].'&prenom='.$this->info['prenom'].'&ddn='.$this->info['ddn'].'&sex='.$this->info['sexe'].'&add='.$this->info['adresse'].'&tel='.$this->info['tel']
      );
  }

  // Checking for valid groupe! //
  private function checkGroupe($loc = 'RF', $pr = false)
  {
    if (checkNum($this->info['groupe']) || $this->info['groupe'] > 333)
      redirect (
        $GLOBALS['MSG']['IG'], 
        'danger', 
        $GLOBALS['LOC'][$loc], 
        $pr ?
          '?nom='.$this->info['nom'].'&prenom='.$this->info['prenom'].'&spc='.$this->info['speciality'].'&grp='.$this->info['groupe'] :
          '?nom='.$this->info['nom'].'&prenom='.$this->info['prenom'].'&ddn='.$this->info['ddn'].'&sex='.$this->info['sexe'].'&add='.$this->info['adresse'].'&tel='.$this->info['tel']
      );
  }

  // Data related methods! //
  public function insert()
  {
    $query = "insert into ET (id, username, matricule, nom, prenom, email, ddn, sexe, adresse, tel, speciality, groupe, photo) values (?,?,?,?,?,?,?,?,?,?,?,?,?)";
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
      $this->info['speciality'],
      $this->info['groupe'],
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

  // Updating student infos! //
  public function update()
  {
    $query = "update ET set nom = ?, prenom = ?, email = ?, speciality = ?, groupe = ?, photo = ? where id = ?";
    // Using prepared statements will increase security
    // against sql injection attacks!
    $statement = $this->connect()->prepare($query);
    $statement->execute([
      $this->info['nom'],
      $this->info['prenom'],
      $this->info['email'],
      $this->info['speciality'],
      $this->info['groupe'],
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
      $_SESSION['message'] = '<b>Student Updated Successfully!</b>';
      $_SESSION['type'] = 'success';

      header('Location: ../profile.php');
    }
  }
}


?>
