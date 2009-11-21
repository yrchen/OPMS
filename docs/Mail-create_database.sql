CREATE TABLE mail_alias(
id int( 11 ) unsigned NOT NULL AUTO_INCREMENT ,
alias varchar( 128 ) NOT NULL default '',
destination varchar( 128 ) NOT NULL default '',
PRIMARY KEY ( id ) 
) TYPE = MYISAM ;

CREATE TABLE mail_relocated(
id int( 11 ) unsigned NOT NULL AUTO_INCREMENT ,
email varchar( 128 ) NOT NULL default '',
destination varchar( 128 ) NOT NULL default '',
PRIMARY KEY ( id ) 
) TYPE = MYISAM ;#

CREATE TABLE mail_transport(
id int( 11 ) unsigned NOT NULL AUTO_INCREMENT ,
domain varchar( 128 ) NOT NULL default '',
destination varchar( 128 ) NOT NULL default '',
PRIMARY KEY ( id ) ,
UNIQUE KEY domain( domain ) 
) TYPE = MYISAM ;

CREATE TABLE mail_users(
id int( 11 ) unsigned NOT NULL AUTO_INCREMENT ,
email varchar( 128 ) NOT NULL default '',
clear varchar( 128 ) NOT NULL default '',
name tinytext NOT NULL ,
uid int( 11 ) unsigned NOT NULL default '1011',
gid int( 11 ) unsigned NOT NULL default '1011',
homedir tinytext NOT NULL ,
maildir tinytext NOT NULL ,
quota tinytext NOT NULL ,
access enum( 'Y', 'N' ) NOT NULL default 'Y',
postfix enum( 'Y', 'N' ) NOT NULL default 'Y',
PRIMARY KEY ( id ) ,
UNIQUE KEY email( email ) 
) TYPE = MYISAM ;

CREATE TABLE mail_virtual(
id int( 11 ) unsigned NOT NULL AUTO_INCREMENT ,
email varchar( 128 ) NOT NULL default '',
destination varchar( 128 ) NOT NULL default '',
PRIMARY KEY ( id ) 
) TYPE = MYISAM ;

CREATE TABLE mail_access(
id int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
source varchar( 128 ) NOT NULL default '',
access varchar( 128 ) NOT NULL default '',
TYPE enum( 'recipient', 'sender', 'client' ) NOT NULL default 'recipient',
PRIMARY KEY ( id ) 
) TYPE = MYISAM;
