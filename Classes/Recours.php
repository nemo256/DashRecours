<?php

require_once ('.workingDir.info.php');
basename(dirname(__FILE__)) != $projectDir ?
  $level = 2 :
  $level = 1;

require_once (dirname(__FILE__, $level) . '/Include/db.php');
require_once (dirname(__FILE__, $level) . '/Include/main.php');

// -- -- -- -- -- //
// Recours class  //
// -- -- -- -- -- //

class recours extends database
{
  public function __construct($info)
  {
    if (is_array($info))
    {
      $this->info = $info;

      $this->checkEmptyFields();
      $this->checkEmailENS();
      $this->checkDescription();
      $this->checkIfEnsExists();

      if (isset($info['id']))
      {
        // checking if recours has been treated! //
        $this->checkStatusRecours('Valid&eacute;');
        $this->checkStatusRecours('Refus&eacute;');
      }
    }
    else
      $this->id = $info;
  }

  // Validating special recours inputs! //
  // Checking for empty fields which are required! //
  private function checkEmptyFields()
  {
    if (empty($this->info['emailens']) || empty($this->info['module']) || empty($this->info['typeE']))
      redirect (
        $GLOBALS['MSG']['EF'], 
        'danger', 
        $GLOBALS['LOC']['P'], 
        '?mailens='.$this->info['emailens'].'&mod='.$this->info['module'].'&descc='.$this->info['desc']
      );
  }

  // Checking for valid email (Enseignant)! //
  private function checkEmailENS()
  {
    if (checkMail($this->info['emailens']))
      redirect (
        $GLOBALS['MSG']['IE'] . '<span class="ml-3">(Enseignant)</span>', 
        'danger', 
        $GLOBALS['LOC']['P'], 
        '?mod='.$this->info['module'].'&descc='.$this->info['desc']
      );
  }

  // Checking for valid description (Prevent any input)! //
  private function checkDescription()
  {
    if (checkAlphaNum($this->info['desc']))
      redirect (
        $GLOBALS['MSG']['IDD'],
        'warning', 
        $GLOBALS['LOC']['P'], 
        '?mailens='.$this->info['emailens'].'&mod='.$this->info['module'].'&descc='.$this->info['desc']
      );
  }
  
  // checking if enseignant exists in database! //
  private function checkIfEnsExists()
  {
    $query = "select * from ENS where email = ?";
    $statement = $this->connect()->prepare($query);
    $statement->execute([$this->info['emailens']]);
    $result = $statement->fetchALL()[0];
    if (empty($result))
      redirect (
        $GLOBALS['MSG']['IE'] . '<span class="ml-3">(Enseignant not found)</span>', 
        'warning', 
        $GLOBALS['LOC']['P'], 
        '?mod='.$this->info['module'].'&descc='.$this->info['desc']
      );
    else
      $this->info['idens'] = $result['id'];
  }

  // checking if status recours has already been updated! //
  private function checkStatusRecours($status)
  {
    $rec = "select * from recours where id = ?";
    $rec = $this->connect()->prepare($rec);
    $rec->execute([$this->info['id']]);
    $rec = $rec->fetchALL();

    if (!strcmp($rec[0]['status'], $status))
      redirect (
        $status == 'Refus&eacute;' ?
          $GLOBALS['MSG']['RR'] :
          $GLOBALS['MSG']['RV'],
        'warning', 
        $GLOBALS['LOC']['P'], 
        '?recours=abort'
      );
  }

  // Data related methods! //
  // Inserting a recours! //
  public function insert()
  {
    $query = "insert into recours (idet, idens, emailens, module, typeE, description, attachment, dateR) values (?,?,?,?,?,?,?,?)";
    // Using prepared statements will increase security
    // against sql injection attacks!
    $statement = $this->connect()->prepare($query);
    $statement->execute([
      $this->info['idet'],
      $this->info['idens'],
      $this->info['emailens'],
      $this->info['module'],
      $this->info['typeE'],
      $this->info['desc'],
      $this->info['attachment'],
      $this->info['dateR']
    ]);

    redirect (
      $GLOBALS['MSG']['RA'],
      'success', 
      $GLOBALS['LOC']['P'], 
      '?recours=success'
    );
  }

  // Updating a recours! //
  public function update()
  {
    if (!empty($this->info['attachment']))
      $query = "update recours set idet = ?, idens = ?, emailens = ?, module = ?, typeE = ?, description = ?, attachment = ?, dateR = ? where id = ?";
    else
      $query = "update recours set idet = ?, idens = ?, emailens = ?, module = ?, typeE = ?, description = ?, dateR = ? where id = ?";
    // Using prepared statements will increase security
    // against sql injection attacks!
    $statement = $this->connect()->prepare($query);
    if (!empty($this->info['attachment']))
      $statement->execute([
        $this->info['idet'],
        $this->info['idens'],
        $this->info['emailens'],
        $this->info['module'],
        $this->info['typeE'],
        $this->info['desc'],
        $this->info['attachment'],
        $this->info['dateR'],
        $this->info['id']
      ]);

    else
      $statement->execute([
        $this->info['idet'],
        $this->info['idens'],
        $this->info['emailens'],
        $this->info['module'],
        $this->info['typeE'],
        $this->info['desc'],
        $this->info['dateR'],
        $this->info['id']
      ]);

    redirect (
      $GLOBALS['MSG']['RU'],
      'success', 
      $GLOBALS['LOC']['P'], 
      '?recours=success'
    );
  }

  // Validating a recours! //
  public function validate()
  {
    if (checkNum($this->id))
      $this->errorRecours();

    $result = $this->getRecours();

    if (empty($result))
      $this->errorRecours();
    else if ($_SESSION['id'] != $result['idens'])
      $this->errorRecours();
    else if (!strcmp($result['statusENS'], 'hide'))
      $this->errorRecours();
    else if (!strcmp($result['status'], 'Valid&eacute;'))
      $this->errorRecours();
    else
    {
      $query = 'update recours set status = "Valid&eacute;" where id = ?';
      $statement = $this->connect()->prepare($query);
      $statement->execute([$this->id]);

      // Redirecting with success message! //
      redirect (
        $GLOBALS['MSG']['RVS'],
        'success', 
        $GLOBALS['LOC']['P'], 
        '?recours=success'
      );
    }
  }

  // Refusing a recours! //
  public function refuse()
  {
    if (checkNum($this->id))
      $this->errorRecours();

    $result = $this->getRecours();

    if (empty($result))
      $this->errorRecours();
    else if ($_SESSION['id'] != $result['idens'])
      $this->errorRecours();
    else if (!strcmp($result['statusENS'], 'hide'))
      $this->errorRecours();
    else if (!strcmp($result['status'], 'Refus&eacute;'))
      $this->errorRecours();
    else
    {
      $query = 'update recours set status = "Refus&eacute;" where id = ?';
      $statement = $this->connect()->prepare($query);
      $statement->execute([$this->id]);

      // Redirecting with success message! //
      redirect (
        $GLOBALS['MSG']['RRS'],
        'success', 
        $GLOBALS['LOC']['P'], 
        '?recours=success'
      );
    }
  }

  // Deleting a recours! //
  public function delete()
  {
    if (checkNum($this->id))
      $this->errorRecours();

    $result = $this->getRecours();
    
    if (empty($result))
      $this->errorRecours();
    else if ($_SESSION['TU'] == 'Etudiant' && $_SESSION['id'] != $result['idet'])
      $this->errorRecours();
    else if ($_SESSION['TU'] == 'Enseignant' && $_SESSION['id'] != $result['idens'])
      $this->errorRecours();
    else if ($_SESSION['TU'] == 'Etudiant' && !strcmp($result['statusET'], 'hide'))
      $this->errorRecours();
    else if ($_SESSION['TU'] == 'Enseignant' && !strcmp($result['statusENS'], 'hide'))
      $this->errorRecours();
    else if ($_SESSION['TU'] == 'Enseignant' && !strcmp($result['status'], 'En Cours'))
      $this->errorRecours();
    else
    {
      if ($_SESSION['TU'] == 'Etudiant')
      {
        !strcmp($result['status'], 'En Cours') ?
          $query = 'update recours set statusET = "hide", statusENS = "hide" where id = ?' :
          $query = 'update recours set statusET = "hide" where id = ?';
      }
      else if ($_SESSION['TU'] == 'Enseignant')
        $query = 'update recours set statusENS = "hide" where id = ?';

      $statement = $this->connect()->prepare($query);
      $statement->execute([$this->id]);

      // Redirecting with success message! //
      redirect (
        $GLOBALS['MSG']['RD'],
        'success', 
        $GLOBALS['LOC']['P'], 
        '?recours=success'
      );
    }
  }

  // Method for getting informations regarding all recours! //
  public function getAllRecours()
  {
    $query = 'select * from recours';
    $statement = $this->connect()->prepare($query);
    $statement->execute([]);
    return $statement->fetchALL();
  }

  // Method for fetching recours for each student! //
  public function getAllRecoursET()
  {
    $query = 'select * from recours where idet = ?';
    $statement = $this->connect()->prepare($query);
    $statement->execute([$this->id]);
    return $statement->fetchALL();
  }

  // Method for fetching recours for each teacher! //
  public function getAllRecoursENS()
  {
    $query = 'select * from recours where idens = ?';
    $statement = $this->connect()->prepare($query);
    $statement->execute([$this->id]);
    return $statement->fetchALL();
  }

  // Method for getting informations regarding a recours! //
  public function getRecours()
  {
    $query = 'select * from recours where id = ?';
    $statement = $this->connect()->prepare($query);
    $statement->execute([$this->id]);
    return $statement->fetchALL()[0];
  }

  // function used in ->delete() function for code repetition!
  private function errorRecours()
  {
    redirect (
      $GLOBALS['MSG']['IR'],
      'danger', 
      $GLOBALS['LOC']['P'], 
      '?errorInvalidRecours'
    );
  }
}


?>
