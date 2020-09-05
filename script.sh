#!/bin/bash

# -- -- -- -- #
#  Functions  #
# -- -- -- -- #

# Help function to display various options!
Help()
{
  # Display Help
  echo "Usage:   script [OPTION]"
  echo
  echo "Example: script -u root -pMyPassCode -d DB"
  echo "         script -d DB"
  echo "Locally: ./script.sh -u root -d DB"
  echo
  echo "Description: A simple script to generate a database with multiple tables and populate them."
  echo
  echo "NOTE: 'USER' and 'PASS' are mysql username and password!"
  echo "      Use 'DB_NAME' to generate your custom database name"
  echo "      otherwise 'DB_NAME' will be set to 'PFE' by default!"
  echo
  echo "Options:"
  echo "  -h     Print this Help."
  echo "  -u     MySQL Username."
  echo "  -p     MySQL Password."
  echo "  -d     MySQL database name to be created."
  echo
}

# Function to display error on database connection! #
DisplayError()
{
  # Display Error
  echo "Error connecting to mysql please check your username and password!"
  echo "Try connecting to mysql to check first!"
  echo
  echo "Example commands:"
  echo "  'mysql -u root -p', 'mysql -u test123' depends on your configuration!"
  echo
  echo "If that does not work 'man mysql' for more help!"
}

# Function to be executed when database is found! #
DatabaseFound()
{
  while true; do
    echo 'Database '$DB_NAME' found!'
    read -p 'Do you really wish to DELETE all contents in '$DB_NAME'? [Y/n]' answer
    case $answer in
      [Yy] )
        if [ -z "$PASS" ]
        then
          mysql -u $USER -e "drop database $DB_NAME" > /dev/null 2>&1
        else
          mysql -u $USER -p$PASS -e "drop database $DB_NAME" > /dev/null 2>&1
        fi
        break;;
      [Nn] )
        echo 'Canceling configuration...'
        echo 'Exiting...'
        exit;;
      * ) echo "Please answer [Yy/Nn].";;
    esac
  done
}

# Generating an info.php file that contains database info! #
GenerateInfoFile()
{
# sed trick to append into the last line! #
# because both php and bash use '$' to define variables! #
cat > .env.info.php <<\EOF
<?php
abstract class info
{
  protected $HOST = 
EOF
sed -i '$ s/$/"localhost";/' .env.info.php
# Line #2
cat >> .env.info.php <<\EOF
  protected $USER = 
EOF
sed -i '$ s/$/"'${USER}'";/' .env.info.php
# Line #3
cat >> .env.info.php <<\EOF
  protected $PASS = 
EOF
sed -i '$ s/$/"'${PASS}'";/' .env.info.php
# Line #4
cat >> .env.info.php <<\EOF
  protected $DB_NAME = 
EOF
sed -i '$ s/$/"'${DB_NAME}'";/' .env.info.php
# Closing php tag!
cat >> .env.info.php <<\EOF
}
?>
EOF
}

# -- -- -- -- -- #
#  Main Program  #
# -- -- -- -- -- #

while getopts ":u:p:d:h" option
do
  case $option in
    u) # fetching Username
       USER=${OPTARG};;
    p) # fetching Password
       PASS=${OPTARG};;
    d) # fetching Database Name
       DB_NAME=${OPTARG};;
    h) # display Help
       Help
       exit;;
    *) # incorrect option
       echo "Error: Invalid option"
       echo "Try 'script -h' for more informations."
       exit;;
  esac
done

# Set default database name if no argument was found! #
[ -z "$USER" ] && USER="root"
[ -z "$DB_NAME" ] && DB_NAME="PFE"

if [ -z "$PASS" ]
then
  # if password is empty generating with a mysql -u USER command! #
  if mysql -u $USER -e exit > /dev/null 2>&1
  then
    if mysql -u $USER $DB_NAME -e exit > /dev/null 2>&1
    then
      DatabaseFound
    fi
    mysql -u $USER -e "create database $DB_NAME" > /dev/null 2>&1
    mysql -u $USER -e "use $DB_NAME" > /dev/null 2>&1

    echo 'Generating tables...'
    mysql -u $USER -D $DB_NAME < ./Populate/populate.sql > /dev/null 2>&1
    echo 'Tables Generated successfully!'
    # FileGen! #
    GenerateInfoFile
  else
    DisplayError
  fi
else
  # Generating everything if USER and PASS are present! #
  if mysql -u $USER -p$PASS -e exit > /dev/null 2>&1
  then
    if mysql -u $USER -p$PASS $DB_NAME -e exit > /dev/null 2>&1
    then
      DatabaseFound
    fi
    mysql -u $USER -p$PASS -e "create database $DB_NAME" > /dev/null 2>&1
    mysql -u $USER -p$PASS -e "use $DB_NAME" > /dev/null 2>&1

    echo 'Generating tables...'
    mysql -u $USER -p$PASS -D $DB_NAME < ./Populate/populate.sql > /dev/null 2>&1
    echo 'Tables Generated successfully!'
    # FileGen! #
    GenerateInfoFile
  else
    DisplayError
  fi
fi


