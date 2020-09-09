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
  'AD'   => '<b>Access Denied!</b>',
  'EF'   => '<b>Empty Fields!</b> please fill out all inputs.',
  'AT'   => '<b>Username is already taken!</b>',
  'ET'   => '<b>Email is already taken!</b>',
  'WP'   => '<b>Wrong Password!</b>',
  'UENR' => '<b>Username / Email not registered!</b>',
  'IUE'  => '<b>Invalid Username or Email!</b>',
  'IM'   => '<b>Invalid Matricule!</b>',
  'IE'   => '<b>Invalid Email address (@x.y)!</b>',
  'IN'   => '<b>Invalid "Nom"</b> no special characters! (!@#$%& ...)',
  'IP'   => '<b>Invalid "Prenom"</b> no special characters! (!@#$%& ...)',
  'IU'   => '<b>Invalid Username</b>, no special characters! (!@#$%& ...)',
  'IPP'  => '<b>Invalid Password</b>, no special characters! (!@#$%& ...)',
  'PDNM' => '<b>Passwords do not match!</b>',
  'IG'   => '<b>Invalid Groupe!</b>',
  'ID'   => '<b>Invalid Deplome!</b>',
  'IPO'  => '<b>Invalid Poste!</b>',
  'IPN'  => '<b>Invalid Phone Number!</b>',
  'IR'   => '<b>Invalid Recours!</b>',
  'IDD'  => '<b>Invalid Description (No special characters)!</b>',
  'CT'   => '<b>Please choose the type of user!</b>',
  'UN'   => '<b>Username / Email Unauthorized, contact the Administration!</b>',

  // Success Messages //
  'RS'   => '<b>Registered Successfully!</b>',
  'US'   => '<b>Updated Successfully!</b>',
  'DS'   => '<b>Deleted Successfully!</b>',
  'VS'   => '<b>Validated Successfully!</b>',
  'RFS'  => '<b>Refused Successfully!</b>',
  'PC'   => '<b>Password Changed Successfully!</b>',
  'UD'   => '<b>User Deleted Successfully!</b>',

  // File related Messages //
  'FS'   => '<b>File is too large to be uploaded!</b>',
  'FE'   => '<b>Error encountered while uploading your file!</b>',
  'FT'   => '<b>File type is invalid!</b>',

  // Recours related Messages //
  'RR'   => '<b>Recours has already been refused!</b>',
  'RRS'  => '<b>Recours has been refused successfully!</b>',
  'RV'   => '<b>Recours has already been validated!</b>',
  'RVS'  => '<b>Recours has been validated successfully!</b>',
  'RA'   => '<b>Recours has been added successfully!</b>',
  'RU'   => '<b>Recours has been updated successfully!</b>',
  'RD'   => '<b>Recours has been deleted successfully!</b>'
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
