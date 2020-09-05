<?php

require_once ('.workingDir.info.php');
basename(dirname(__FILE__)) != $projectDir ?
  $level = 2 :
  $level = 1;

require_once (dirname(__FILE__, $level) . '/.env.info.php');

abstract class database extends info
{
  protected function connect()
  {
    $dsn = 'mysql:host=' . $this->HOST. ';dbname=' . $this->DB_NAME;
    $pdo = new PDO($dsn, $this->USER, $this->PASS);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
  }
}

?>
