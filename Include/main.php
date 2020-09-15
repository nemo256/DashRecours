<?php

// -- -- -- -- -- -- //
// Locations table   //
// -- -- -- -- -- -- //

$LOC = array
(
  'L'  => 'Location: ../Pages/login.php',
  'LO' => 'Location: ../Include/logout.inc.php',
  'R'  => 'Location: ../Pages/register.php',
  'RF' => 'Location: ../registerFULL.php',
  'H'  => 'Location: ../index.php',
  'P'  => 'Location: ../profile.php',
  'D'  => 'Location: ../dashboard.php',
  'C'  => 'Location: ../charts.php'
);

// -- -- -- -- -- //
// Messages table //
// -- -- -- -- -- //

$MSG = array
(
  // Error Messages //
  'AD'   => '<b>Accès Refusé!</b>',
  'EF'   => '<b>Champs vides! </b> veuillez remplir toutes les entrées.',
  'UT'   => "<b>Nom d'utilisateur déjà pris!</b>",
  'ET'   => '<b>Cet email est déjà pris!</b>',
  'WP'   => '<b>Mot de passe incorrect!</b>',
  'UENR' => "<b>Nom d'utilisateur / Email non enregistré!</b>",
  'IUE'  => "<b>Nom d'utilisateur ou e-mail invalide!</b>",
  'IM'   => '<b>Matricule invalide!</b>',
  'IE'   => '<b>Adresse e-mail non valide (@x.y)!</b>',
  'IN'   => '<b>Nom invalide</b> pas de caractères spéciaux (!@#$%& ...)',
  'IP'   => '<b>Prenom invalide</b> pas de caractères spéciaux! (!@#$%& ...)',
  'IU'   => "<b>Nom d'utilisateur invalide</b>",
  'IPP'  => '<b>Mot de passe invalide</b>',
  'PDNM' => '<b>Mots de passe ne correspondent pas!</b>',
  'IG'   => '<b>Groupe invalide!</b>',
  'ID'   => '<b>Deplome invalide!</b>',
  'IPO'  => '<b>Poste invalide!</b>',
  'IPN'  => '<b>Numéro de téléphone invalide!</b>',
  'IS'   => '<b>Sexe invalide!</b>',
  'IR'   => '<b>Recours invalide!</b>',
  'IDD'  => '<b>Description invalide (pas de caractères spéciaux)!</b>',
  'CT'   => "<b>Veuillez choisir le type d'utilisateur!</b>",
  'UN'   => "<b>Nom d'utilisateur / Email non autorisé, contactez l'administration!</b>",

  // Success Messages //
  'RS'   => '<b>Enregistré avec succès!</b>',
  'US'   => '<b>Mis à jour avec succés!</b>',
  'DS'   => '<b>Supprimé avec succès!</b>',
  'VS'   => '<b>Validé avec succès!</b>',
  'RFS'  => '<b>Refusé avec succès!</b>',
  'PC'   => '<b>Mot de passe changé avec succès!</b>',
  'UD'   => "<b>Utilisateur supprimé avec succès!</b>",

  // File related Messages //
  'FS'   => '<b>Le fichier est trop grand!</b>',
  'FE'   => '<b>Erreur rencontrée lors du téléchargement de fichier!</b>',
  'FT'   => '<b>Type de fichier invalide!</b>',

  // Recours related Messages //
  'RR'   => '<b>Recours a déjà été refusé!</b>',
  'RRS'  => '<b>Recours a été refusé avec succès!</b>',
  'RV'   => '<b>Recours a déjà été validé!</b>',
  'RVS'  => '<b>Recours a été validé avec succès!</b>',
  'RA'   => '<b>Recours a été ajouté avec succès!</b>',
  'RU'   => '<b>Recours a été mis à jour avec succès!</b>',
  'RD'   => '<b>Recours a été supprimé avec succès!</b>'
);

// -- -- -- -- -- -- -- //
// Required types table //
// -- -- -- -- -- -- -- //

$requiredTypes = array
(
  // profile picture //
  'photo'      => array('jpg', 'jpeg', 'png', 'ico', 'svg'),

  // attachment for new 'recours' //
  'attachment' => array(
      'jpg', 'jpeg', 'png', 'ico', 'svg', 'pdf', 'c',
      'cpp', 'html', 'js', 'jar', 'cs', 'php', 'css',
      'sass', 'mat', 'obj', 'asm', 'oom', 'doc', 'docx',
      'txt', 'tex', 'zip', 'xml', 'py', 'odp', 'ppt',
      'pptx', 'h', 'sh', 'swift', 'xls', 'xlsx', 'scss'
    )
);

// -- -- -- -- -- //
// File handling  //
// -- -- -- -- -- //

class file
{
  public function __construct($info, $name, $maxSize)
  {
    $this->fileOldName = $name;
    // Error 4 means no file has been submitted! //
    if ($_FILES[$name]['error'] == 4)
    {
      if (!empty($info['photo']) && $info['photo'] != '<null>' && $info['photo'] != './Icons/account2.png' && isset($info['updatePR']))
      {
        $this->OldName = dirname(__FILE__, 2) . '/Pics/' . basename($info['photo']);
        $this->fileExt = explode('.', basename($info['photo']));
        $this->fileExt = strtolower(end($this->fileExt));
        $this->fileNameNew = $info['nom'] . '_' . $info['prenom'] . '.' . $this->fileExt;
        $this->NewName = dirname(__FILE__, 2) . '/Pics/' . $this->fileNameNew;
        // Renaming the previous photo! //
        rename ($this->OldName, $this->NewName);
      }
      else
        $this->fileNameNew = '';
    }
    else
    {
      // initializing vars for later usage! //
      $this->requiredTypes = $name == 'file' ? 
        $GLOBALS['requiredTypes']['photo'] :
        $GLOBALS['requiredTypes']['attachment'];
      $this->dirName = $name == 'file' ? 
        dirname(__FILE__, 2) . '/Pics/' :
        dirname(__FILE__, 2) . '/Files/';
      $this->location = $name == 'file' ? 
        $GLOBALS['LOC']['RF'] :
        $GLOBALS['LOC']['P'];
      $this->maxSize = $maxSize;

      $this->fileName = $_FILES[$name]['name'];
      $this->fileTmpName = $_FILES[$name]['tmp_name'];
      $this->fileSize = $_FILES[$name]['size'];
      $this->fileError = $_FILES[$name]['error'];
      $this->fileType = $_FILES[$name]['type'];

      $this->fileExt = explode('.', $this->fileName);
      $this->fileExt = strtolower(end($this->fileExt));

      // checking all file informations! //
      $this->checkFileExt($this->requiredTypes);
      $this->checkFileError();
      $this->checkFileSize();

      // generating a file name (exclusive for photo and attachment)
      // file is photo in my case and attachment is for 'recours' //
      if ($name == 'file')
        $this->fileNameNew = $info['nom'] . '_' . $info['prenom'] . '.' . $this->fileExt;
      else
        $this->fileNameNew = strtolower($info['nom']) . '_' . strtolower($info['prenom']) . '_' . $info['speciality'] . '-' . $info['groupe'] . '_' . $info['module'] . '_' . $info['typeE'] . '.' . $this->fileExt;

      $this->fileDestination = $this->dirName . $this->fileNameNew;
    }
  }

  // For moving actual files! //
  public function moveFile()
  {
    if ($_FILES[$this->fileOldName]['error'] != 4)
      move_uploaded_file($this->fileTmpName, $this->fileDestination);
  }

  // To get the uploaded file's name! //
  public function getFileName() { return $this->fileNameNew; }

  // check if file extension is allowed! //
  private function checkFileExt($allowedTypes)
  {
    if (!in_array($this->fileExt, $allowedTypes))
      redirect (
        $GLOBALS['MSG']['FT'], 
        'warning', 
        $this->location, 
        '?error=fileType'
      );
  }

  // check for any errors! //
  private function checkFileError()
  {
    if ($this->fileError !== 0)
      redirect (
        $GLOBALS['MSG']['FE'], 
        'warning', 
        $this->location, 
        '?error=fileError'
      );
  }

  // check for any errors! //
  private function checkFileSize()
  {
    if ($this->fileSize > $this->maxSize)
      redirect (
        $GLOBALS['MSG']['FS'], 
        'warning', 
        $this->location, 
        '?error=fileSize'
      );
  }
}


// Email verification //
function checkMail($var)
{
  if (!filter_var($var, FILTER_VALIDATE_EMAIL))
    return true;
  else
    return false;
} 

// AlphaNoSpace verification //
function checkAlphaNoSpace($var)
{
  if (!preg_match('/^[a-zA-Z\s]+$/', $var))
    return true;
  else
    return false;
} 

// Numeric verification //
function checkNum($var)
{
  if (!preg_match('/^[Z0-9]*$/', $var))
    return true;
  else
    return false;
} 

// AlphaNumeric verification //
function checkAlphaNum($var)
{
  if (!preg_match('/^[a-zA-Z0-9]*$/', $var))
    return true;
  else
    return false;
} 

// For redirecting and updating the session message (alerts) //
function redirect ($message, $type, $location, $urlAppend)
{
  $_SESSION['message'] = $message;
  $_SESSION['type'] = $type;

  header($location . $urlAppend);
  exit();
}


?>
