# Dashboard recours

Website to manage recourse in a university

![Azure DevOps coverage](https://img.shields.io/azure-devops/coverage/swellaby/opensource/12)
![Packagist PHP Version Support (specify version)](https://img.shields.io/packagist/php-v/symfony/symfony/v2.1.4)
![PHP-MySQL](https://img.shields.io/badge/php--mysql-required-yellow)

Dashboard recours is a website that can manage recours concerning IT department in a univerity!

![demo](./Plugins/demo.gif)

## Installation

> `PHP` version 5 is required
1. Run this to clone this repo and make `./script` command executable:
```bash
$ git clone https://github.com/nemo256/DashRecours
$ cd DashRecours
$ chmod +x script.sh
```
2. This will generate the database with its tables and populate them:
```bash
$ ./script.sh -u [MYSQL-username] -p [MYSQL-password] -d [DB-NAME]
```
3. Launch a local server on PORT 3000 (run as `sudo` for superuser privileges):
```bash
$ sudo php -S localhost:3000
```
4. For more informations run:
```bash
$ ./script.sh -h
```

## Don't have mysql password? (default username = root)

*_NOTE: if [DB-NAME] is not specified 'PFE' is the default value!_*
```bash
$ sudo ./script.sh -d [DB-NAME]
```

## Usage

1. A `Student` can add, update, remove a recourse.
2. A `Teacher` can validate, refuse a recourse,
3. An `Administrator` can manage `Students` and `Teachers`.

## Issues you might run into

For linux users that may have to change ownership of this project for files and images to be uploaded correctly!
```bash
$ sudo chown -R www-data:www-data [PATH-TO-DIR]/DashRecours
```

Please make sure you have mysql running on your computer before running (./script.sh):
```bash
$ mysql -u [USERNAME] -p[PASSWORD]
$ mysql --help  # If any problem occures running the command above.
```
