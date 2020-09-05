-- This script will be used for preparing the database
-- for all user tables and more informations to be saved!

-- This script will also populate the databases tables with
-- existing informations :
-- Informations will be found in this directory './Populate/'
-- It will contain various comma ',' seperated content inside
-- files that are going to be imported into their appropriate tables!

/* -- -- -- -- */
/* Users table */
/* -- -- -- -- */

create table `users` (
  `id` bigint auto_increment primary key not null,
  `username` text not null,
  `email` text not null,
  `type` enum('Visitor', 'Etudiant', 'Enseignant', 'Administrateur'),
  `photo` text,
  `pwd` longtext not null
) ENGINE = InnoDB DEFAULT CHARSET = latin1;


/* -- -- -- -- -- */
/* Etudiant table */
/* -- -- -- -- -- */

create table `ET` (
  `id` bigint not null,
  `username` text not null,
  `matricule` text not null,
  `nom` text not null,
  `prenom` text not null,
  `email` text not null,
  `ddn` text not null,
  `sexe` enum('Male', 'Female', 'Autre') not null,
  `adresse` text not null,
  `tel` bigint not null,
  `speciality` enum('L1-MI', 'L2-INFO', 'L3-ISIL', 'L3-SI', 'M1-ILTI', 'M1-SIR', 'M1-TI', 'M2-ILTI', 'M2-SIR', 'M2-TI') not null,
  `groupe` smallint not null,
  `photo` text
) ENGINE = InnoDB DEFAULT CHARSET = latin1;


/* -- -- -- -- -- -- */
/* Enseignant table  */
/* -- -- -- -- -- -- */

create table `ENS` (
  `id` bigint not null,
  `username` text not null,
  `matricule` text not null,
  `nom` text not null,
  `prenom` text not null,
  `email` text not null,
  `ddn` text not null,
  `sexe` enum('Male', 'Female', 'Autre') not null,
  `adresse` text not null,
  `tel` bigint not null,
  `deplome` text not null,
  `grade` enum('MAA', 'MAB', 'MCA', 'MCB', 'PROF') not null,
  `photo` text
) ENGINE = InnoDB DEFAULT CHARSET = latin1;


/* -- -- -- -- -- -- -- */
/* Administrateur table */
/* -- -- -- -- -- -- -- */

create table `ADM` (
  `id` bigint not null,
  `username` text not null,
  `matricule` text not null,
  `nom` text not null,
  `prenom` text not null,
  `email` text not null,
  `ddn` text not null,
  `sexe` enum('Male', 'Female', 'Autre') not null,
  `adresse` text not null,
  `tel` bigint not null,
  `poste` text not null,
  `photo` text
) ENGINE = InnoDB DEFAULT CHARSET = latin1;


/* -- -- -- -- -- */
/* Recours table  */
/* -- -- -- -- -- */

create table `recours` (
  `id` bigint primary key auto_increment not null,
  `idet` bigint not null,
  `idens` bigint not null,
  `emailens` text not null,
  `module` text not null,
  `typeE` enum('Examin', 'Test') not null,
  `description` mediumtext,
  `status` enum('En Cours', 'Valid&eacute;', 'Refus&eacute;') default 'En Cours' not null,
  `statusET` enum('hide', 'show') default 'show' not null,
  `statusENS` enum('hide', 'show') default 'show' not null,
  `attachment` mediumtext,
  `dateR` text not null
) ENGINE = InnoDB DEFAULT CHARSET = latin1;


-- Code to populate each table! --

-- Users table --
load data local infile './Populate/Users.txt'
replace into table `users`
fields terminated by ','
lines terminated by '\n';

-- Etudiant table --
load data local infile './Populate/Etudiant.txt'
replace into table `ET`
fields terminated by ','
lines terminated by '\n';

-- Enseignant table --
load data local infile './Populate/Enseignant.txt'
replace into table `ENS`
fields terminated by ','
lines terminated by '\n';

-- Administrateur table --
load data local infile './Populate/Administrateur.txt'
replace into table `ADM`
fields terminated by ','
lines terminated by '\n';

-- Recours table --
load data local infile './Populate/Recours.txt'
replace into table `recours`
fields terminated by ','
lines terminated by '\n';
