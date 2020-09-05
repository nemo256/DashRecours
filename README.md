# Dashboard recours

Website to manage recourse in a university

![Azure DevOps coverage](https://img.shields.io/azure-devops/coverage/swellaby/opensource/12)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/symfony/symfony)
![Mozilla Add-on](https://img.shields.io/amo/dw/dustman)

Dashboard recours is a website that can manage recours concerning IT department in a univerity!

![demo](./Plugins/demo.gif)

## Installation

```bash
$ ./script.sh -u [MYSQL-username] -p [MYSQL-password] -d [DB-NAME]
```

## Don't have mysql password? (default username = root)

**_NOTE: if [DB-NAME] is not specified 'PFE' is the default value!_**
```bash
$ ./script.sh -d [DB-NAME]
```

## Usage

> `PHP` version 5 is required
1. Run this to make `./script` command executable:
```bash
$ sudo git clone https://github.com/nemo256/DashRecours /var/www/html/project_dir  # for linux users
$ cd project_dir  # this working directory
$ sudo chmod +x script.sh
```
2. This will generate the database with its tables and populate them:
```bash
$ sudo ./script.sh  # sudo for superuser priveleges!
```
3. If you run into any problems using script.sh please run:
```bash
$ ./script.sh -h
```
for more information on using the script!

## Issues you might run into

For linux users that may have to change ownership of this project for files and images to be copied correctly!
```bash
$ sudo chown -R www-data:www-data /var/www/html/project_dir
```

Please make sure you have mysql running on your computer before running:
```bash
$ sudo ./script.sh
```
