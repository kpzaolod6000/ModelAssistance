CREATE TABLE `director` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(60) NOT NULL,
    `surname` varchar(60) NOT NULL,
    `gender` varchar(50) NULL,
    `email` varchar(50) NOT NULL,
    `created_on` date NOT NULL,
    `modified_on` date NOT NULL,
    PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `classroom` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `created_on` date NOT NULL,
    `modified_on` date NOT NULL,
    PRIMARY KEY(id)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `schedule` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `hour_ini` varchar(30) NOT NULL,
    `hour_end` varchar(30) NOT NULL,
    `type` varchar(60) NOT NULL,
    `days` varchar(60) NOT NULL,
    `id_asignature` int(11) NOT NULL,
    `id_classroom` int(11) NOT NULL,
    `id_teacher` int(11) NOT NULL,
    `created_on` date NOT NULL,
    `modified_on` date NOT NULL,
    PRIMARY KEY(id)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


  CREATE TABLE `teachers` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `names` varchar(60) NOT NULL,
    `surnames` varchar(60) NOT NULL,
  	`email` varchar(60) NOT NULL,
    `gender` char(1) NULL,
  	`created_on` date NOT NULL,
    `modified_on` date NOT NULL,
    PRIMARY KEY(id)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

  CREATE TABLE `students` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `cui` varchar(60) NOT NULL,
  	`names` varchar(60) NOT NULL,
    `surnames` varchar(60) NOT NULL,
    `email` varchar(60) NULL,
    `gender` char(1) NULL,
    `created_on` date NOT NULL,
    `modified_on` date NOT NULL,
    PRIMARY KEY(id)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

  CREATE TABLE `Asignatures` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `code` varchar(30) NULL,
    `names` varchar(255) NOT NULL,
    `group` varchar(60) NULL,
  	`mode` varchar(60) NULL,
  	`pre_requeriments` varchar(60) NULL,
    `created_on` date NOT NULL,
    `modified_on` date NOT NULL,
    PRIMARY KEY(id)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

  CREATE TABLE `assistances_teacher` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  	`hour_ini` varchar(30) NOT NULL,
  	`hour_end` varchar(30) NOT NULL,
  	`state` varchar(30) NOT NULL,
  	`advanced` varchar(60) NOT NULL,
  	`id_teacher` int(11) NOT NULL,
  	`id_asignature` int(11) NOT NULL,
    `created_on` date NOT NULL,
    `modified_on` date NOT NULL,
    PRIMARY KEY(id)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

  CREATE TABLE `assistances_student` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `hour_ini` varchar(30) NULL,
    `hour_end` varchar(30) NULL,
    `state` varchar(30) NOT NULL,
    `id_student` int(11) NOT NULL,
    `id_teacher` int(11) NOT NULL,
    `id_asignature` int(11) NOT NULL,
    `created_on` date NOT NULL,
    `modified_on` date NOT NULL,
    PRIMARY KEY(id)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


  CREATE TABLE `asig_teacher` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `id_teacher` int(11) NOT NULL,
    `id_asignature` int(11) NOT NULL,
    `created_on` date NOT NULL,
    `modified_on` date NOT NULL,
    PRIMARY KEY(id)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


  CREATE TABLE `asig_student` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `id_student` int(11) NOT NULL,
    `id_asignature` int(11) NOT NULL,
    `created_on` date NOT NULL,
    `modified_on` date NOT NULL,
    PRIMARY KEY(id)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;