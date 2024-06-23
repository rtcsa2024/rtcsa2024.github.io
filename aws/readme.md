


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
  `ieee_type` varchar(255) NOT NULL,
  `ieee_num` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `over_page_length` varchar(255) NOT NULL,
  `extra_reception_tickets` varchar(255) NOT NULL,
  `extra_banquet_tickets` varchar(255) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `manuscriptTitle` varchar(255) NOT NULL,
  `authorRegistration` varchar(255) NOT NULL,
  `dietary` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `kgmob_auth_registrant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sign_date` varchar(255) NOT NULL,
  `trade_id` varchar(255) NOT NULL,
  `pay_method` varchar(255) NOT NULL,
  `stat` varchar(255) NOT NULL,
  `rescode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `eximbay_try_registrant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `affiliation` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `ieee_type` varchar(255) NOT NULL,
  `ieee_num` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `over_page_length` varchar(255) NOT NULL,
  `extra_reception_tickets` varchar(255) NOT NULL,
  `extra_banquet_tickets` varchar(255) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `manuscriptTitle` varchar(255) NOT NULL,
  `authorRegistration` varchar(255) NOT NULL,
  `dietary` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `eximbay_auth_registrant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `transaction_date` varchar(255) NOT NULL,
  `card_number4` varchar(255) NOT NULL,
  `card_number1` varchar(255) NOT NULL,
  `stat` varchar(255) NOT NULL,
  `rescode` varchar(255) NOT NULL,
  `resmsg` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);


## etc
- mysql -u root -p
- mysql password : RTCSA2024@pay@cau
- use rtcsa2024_paymentServer;
- ssh -i 2024_rtcsa.pem ec2-user@54.160.128.164