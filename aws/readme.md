


# Installing Server
1. TBA
2. Installing MySql

https://jinhos-devlog.tistory.com/entry/MySQL-8-Community-Edition-%EC%84%A4%EC%B9%98-%EC%A4%91-%EC%98%A4%EB%A5%98

# database modify
1. Create database

CREATE DATABASE rtcsa2024_paymentServer;

2. Create table

CREATE TABLE `kgmob_try_registrant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `affiliation` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `acm_type` varchar(255) NOT NULL,
  `acm_num` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `kgmob_succ_registrant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `affiliation` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `acm_type` varchar(255) NOT NULL,
  `acm_num` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `kgmob_failed_registrant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `affiliation` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `acm_type` varchar(255) NOT NULL,
  `acm_num` varchar(255) NOT NULL,
  `rescode` varchar(255) NOT NULL,
  `resmsg` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `eximbay_try_registrant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `affiliation` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `acm_type` varchar(255) NOT NULL,
  `acm_num` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `eximbay_succ_registrant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `affiliation` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `acm_type` varchar(255) NOT NULL,
  `acm_num` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `eximbay_failed_registrant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `affiliation` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `acm_type` varchar(255) NOT NULL,
  `acm_num` varchar(255) NOT NULL,
  `rescode` varchar(255) NOT NULL,
  `resmsg` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

## etc
- mysql password : RTCSA2024@pay@cau
- ssh -i 2024_rtcsa.pem ec2-user@54.160.128.164