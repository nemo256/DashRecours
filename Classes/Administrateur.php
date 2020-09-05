<?php

require_once ('.workingDir.info.php');
basename(dirname(__FILE__)) != $projectDir ?
  $level = 2 :
  $level = 1;

require_once (dirname(__FILE__, $level) . '/Classes/User.php');

// -- -- -- -- -- -- -- //
// Administrator class  //
// -- -- -- -- -- -- -- //

class administrateur extends user
{
  public function __construct($info)
  {
    if (!is_array($info))
      $this->id = $info;
    elseif (isset($info['updatePR']))
      $this->info = $info;
    else
    {
      parent::__construct($info);

      $this->checkEmptyFieldsADM();
      $this->checkMatricule();
      $this->checkPoste();
    }
  }

  public function getInfo()
  {
    $query = 'select * from ADM where id = ?';
    $statement = $this->connect()->prepare($query);
    $statement->execute([$this->id]);
    return $statement->fetchALL()[0];
  }

  public function destroy() {}

  // Validating special administrateur inputs! //
  // Checking for empty fields which are required! //
  private function checkEmptyFieldsADM()
  {
    if (empty($this->info['matricule']) || empty($this->info['poste']))
      redirect (
        $GLOBALS['MSG']['EF'], 
        'danger', 
        $GLOBALS['LOC']['RF'], 
        '?nom='.$this->info['nom'].'&prenom='.$this->info['prenom'].'&ddn='.$this->info['ddn'].'&sex='.$this->info['sexe'].'&add='.$this->info['adresse'].'&tel='.$this->info['tel']
      );
  }

  // Checking for valid id (matricule)! //
  private function checkMatricule()
  {
    if (checkAlphaNum($this->info['matricule']))
      redirect (
        $GLOBALS['MSG']['IM'] . '<span class="ml-3">(Administrateur)</span>', 
        'danger', 
        $GLOBALS['LOC']['RF'], 
        '?nom='.$this->info['nom'].'&prenom='.$this->info['prenom'].'&ddn='.$this->info['ddn'].'&sex='.$this->info['sexe'].'&add='.$this->info['adresse'].'&tel='.$this->info['tel']
      );
  }

  // Checking for valid poste! //
  private function checkPoste()
  {
    if (checkAlphaNoSpace($this->info['poste']))
      redirect (
        $GLOBALS['MSG']['IPO'], 
        'danger', 
        $GLOBALS['LOC']['RF'], 
        '?nom='.$this->info['nom'].'&prenom='.$this->info['prenom'].'&ddn='.$this->info['ddn'].'&sex='.$this->info['sexe'].'&add='.$this->info['adresse'].'&tel='.$this->info['tel']
      );
  }

  // Data related methods! //
  public function insert()
  {
    $query = "insert into ADM (id, username, matricule, nom, prenom, email, ddn, sexe, adresse, tel, poste, photo) values (?,?,?,?,?,?,?,?,?,?,?,?)";
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
      $this->info['poste'], 
      $this->info['photo']
    ]);

    $_SESSION['TU'] = $this->info['type'];

    $_SESSION['message'] = "Registered successfully!";
    $_SESSION['type'] = "success";

    header('Location: ../index.php?register=success');
  }

  // Updating administrator infos! //
  public function update()
  {
    $query = "update ADM set nom = ?, prenom = ?, email = ?, photo = ? where id = ?";
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
}
