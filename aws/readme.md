{\rtf1\ansi\ansicpg1252\cocoartf2761
\cocoatextscaling0\cocoaplatform0{\fonttbl\f0\fswiss\fcharset0 Helvetica;\f1\fnil\fcharset0 Menlo-Regular;}
{\colortbl;\red255\green255\blue255;\red70\green137\blue204;\red24\green24\blue24;\red194\green126\blue101;
\red140\green211\blue254;\red202\green202\blue202;\red193\green193\blue193;}
{\*\expandedcolortbl;;\cssrgb\c33725\c61176\c83922;\cssrgb\c12157\c12157\c12157;\cssrgb\c80784\c56863\c47059;
\cssrgb\c61176\c86275\c99608;\cssrgb\c83137\c83137\c83137;\cssrgb\c80000\c80000\c80000;}
\paperw11900\paperh16840\margl1440\margr1440\vieww11520\viewh8400\viewkind0
\pard\tx566\tx1133\tx1700\tx2267\tx2834\tx3401\tx3968\tx4535\tx5102\tx5669\tx6236\tx6803\pardirnatural\partightenfactor0

\f0\fs24 \cf0 # ee\
\
\
# Installing Server\
1. \
\
2. Installing MySql\
https://jinhos-devlog.tistory.com/entry/MySQL-8-Community-Edition-%EC%84%A4%EC%B9%98-%EC%A4%91-%EC%98%A4%EB%A5%98\
\
# database modify\
1. Create database rtcsa2024_paymentServer;\
\
2. Create table\
\
\pard\pardeftab720\partightenfactor0

\f1 \cf2 \cb3 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec2 VALUES\cf4 \strokec4  ('\cf5 \strokec5 $name\cf4 \strokec4 ', '\cf5 \strokec5 $email\cf4 \strokec4 ', '\cf5 \strokec5 $affiliation\cf4 \strokec4 ', '\cf5 \strokec5 $country\cf4 \strokec4 ', '\cf5 \strokec5 $acm_type\cf4 \strokec4 ', '\cf5 \strokec5 $acm_num\cf4 \strokec4 ')"\cf6 \strokec6 ;\cf7 \cb1 \strokec7 \
\pard\tx566\tx1133\tx1700\tx2267\tx2834\tx3401\tx3968\tx4535\tx5102\tx5669\tx6236\tx6803\pardirnatural\partightenfactor0

\f0 \cf0 \kerning1\expnd0\expndtw0 \outl0\strokewidth0 \
\
CREATE TABLE `kgmob_try_registrant` (\
  `id` int(11) NOT NULL AUTO_INCREMENT,\
  `name` varchar(255) NOT NULL,\
  `email` varchar(255) NOT NULL,\
\pard\tx566\tx1133\tx1700\tx2267\tx2834\tx3401\tx3968\tx4535\tx5102\tx5669\tx6236\tx6803\pardirnatural\partightenfactor0
\cf0   `affiliation` varchar(255) NOT NULL,\
  `country` varchar(255) NOT NULL,\
  `acm_type` varchar(255) NOT NULL,\
  `acm_num` varchar(255) NOT NULL,\
\pard\tx566\tx1133\tx1700\tx2267\tx2834\tx3401\tx3968\tx4535\tx5102\tx5669\tx6236\tx6803\pardirnatural\partightenfactor0
\cf0   PRIMARY KEY (`id`)\
);\
\
\
## etc\
- mysql password : RTCSA2024@pay@cau\
- ssh I 2024_rtcsa.pem ec2-user@54.160.128.164}