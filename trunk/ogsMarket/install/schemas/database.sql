##
## Table utilisateur
##

CREATE TABLE `market_user` (
	`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur utilisateur',
	`name` VARCHAR( 30 ) NOT NULL COMMENT 'Nom utilisateur',
	`password` VARCHAR( 32 ) NOT NULL COMMENT 'md5 du mot de passe',
	`regdate` INT( 11 ) NOT NULL COMMENT 'Date de creation',
	`lastvisit` INT( 11 ) NOT NULL COMMENT 'Derni�re visite',
	`countconnect` INT( 11 ) NOT NULL COMMENT 'Decompte du nombre de connexion',
	`email` VARCHAR( 250 ) NOT NULL COMMENT 'Email',
	`msn` VARCHAR( 100 ) NOT NULL COMMENT 'Email MSN',
	`pm_link` VARCHAR( 30 ) NOT NULL COMMENT 'Lien Message Prive',
	`irc_nick` VARCHAR( 30 ) NOT NULL COMMENT 'Nick IRC',
	`avatar_link` varchar(100) NOT NULL COMMENT 'Lien Avatar',
	`note` VARCHAR( 250) NOT NULL COMMENT 'Description User',
	`account_type` VARCHAR( 10 ) NOT NULL DEFAULT 'internal' COMMENT 'Type de comptes',
	`is_admin` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT 'Administrateur',
	`is_moderator` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT 'Mod�rateur',
	`is_active` ENUM('0','1') NOT NULL DEFAULT '1' COMMENT 'Est Actif',
	`alert_mail` enum('0','1') NOT NULL default '1',
	`skin` VARCHAR(50) NOT NULL DEFAULT 'skin/' COMMENT 'Skin de l utilisateur',
	`modepq` enum('p','q') NOT NULL DEFAULT 'p' COMMENT 'Pr�s�lection saisie',
	`deliver` VARCHAR( 255 ) NOT NULL DEFAULT '0' COMMENT 'Livrable',
	`refunding` VARCHAR( 255 ) NOT NULL DEFAULT '0' COMMENT 'Payable'
);


##
## Table des univers
##


CREATE TABLE `market_univers` (
	`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur Univers',
	`info` VARCHAR( 255 ) NOT NULL COMMENT 'Description',
	`name` VARCHAR( 40 ) NOT NULL COMMENT 'Nom userfriendly de l''univers',
	`g` INT(3) NOT NULL
);


##
## Table des Trades
##

CREATE TABLE `market_trade` (
	`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur de l''�change',
	`traderid` INT( 11 ) NOT NULL COMMENT 'Identificateur de l''utilisateur ',
	`universid` INT( 11 ) NOT NULL COMMENT 'Identificateur de l''univers de l''�change',
	`offer_metal` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Offre en m�tal',
	`offer_crystal` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Offre en crystal',
	`offer_deuterium` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Offre en deuterium',
	`want_metal` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Demande en m�tal',
	`want_crystal` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Demande en crystal',
	`want_deuterium` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Demande en deuterium',
	`creation_date` INT( 11 ) NOT NULL COMMENT 'Date de cr�ation del''offre',
	`expiration_date` INT( 11 ) NOT NULL COMMENT 'Date d''expiration de l''offre',
	`note` TEXT NULL COMMENT 'Note du vendeur pour son offre',
	`deliver` VARCHAR( 255 ) NOT NULL DEFAULT '0' COMMENT 'Livrable',
	`refunding` VARCHAR( 255 ) NOT NULL DEFAULT '0' COMMENT 'Payable',
	`pos_user` INT NOT NULL DEFAULT '0' COMMENT 'Personne qui a r�serv� le trade',
	`pos_date` INT NOT NULL COMMENT 'Date de Reservation',
  `trade_closed` TINYINT(1) DEFAULT '0' COMMENT '1 Si la transaction est terminee'
);


##
## Table des Commentaires
##

CREATE TABLE `market_comment` (
	`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur du commentaire',
	`tradeid` INT( 11 ) NOT NULL COMMENT 'Identificateur du trade auquel se rapporte le commentaire',
	`userid` INT( 11 ) NOT NULL COMMENT 'Identificateur de l''utilisateur',
	`replyed_id` INT( 11 ) NOT NULL COMMENT 'Identificateur eventuel du commentaire auquel on r�pond',
	`post` TEXT NOT NULL COMMENT 'Le corps du commentaire'
);

##
## Table structure for table `sessions`
##

CREATE TABLE `market_sessions` (
	`id` int(11) NOT NULL COMMENT 'Identificateur BD',
	`ip` varchar(13) NOT NULL COMMENT 'Adresse IP',
	`last_connect` int(11) NOT NULL COMMENT 'Derni�re connexion',
	`last_visit` int(11) NOT NULL,
	PRIMARY KEY  (`id`)
);

##
## Tables des Ogspy autorise
##
CREATE TABLE `market_ogspy_auth` (
	`id` INT NOT NULL AUTO_INCREMENT ,
	`url` VARCHAR( 255 ) NOT NULL ,
	`read_access` ENUM( '0', '1' ) DEFAULT '1' NOT NULL ,
	`write_access` ENUM( '0', '1' ) DEFAULT '1' NOT NULL ,
	`active` ENUM( '0', '1' ) DEFAULT '1' NOT NULL ,
	`description` VARCHAR( 255 ) NOT NULL ,
	PRIMARY KEY ( `id` ) ,
	 UNIQUE (`url`)
);



##
## Initialisation de la configuration par defaut (2 tables : config et infos)
##
CREATE TABLE `market_config` (
	`name` VARCHAR( 20 ) NOT NULL COMMENT 'Nom de la variable config',
	`value` VARCHAR( 255 ) NOT NULL COMMENT 'Valeur de la cariable config'
);

CREATE TABLE `market_infos` (
	`name` varchar(20) NOT NULL default '' COMMENT 'Nom de la variable infos',
	`value` longtext NOT NULL COMMENT 'Valeur de la variable infos',
	PRIMARY KEY  (`name`)
);

##mailinglist
INSERT INTO `market_config` ( `name` , `value` ) VALUES ( 'mail_message', 'OGSMarket vous informe ...');
INSERT INTO `market_config` ( `name` , `value` ) VALUES ( 'mail_object', 'OGSMarket');
INSERT INTO `market_config` ( `name` , `value` ) VALUES ( 'mail_expediteur', 'admin@admin');
INSERT INTO `market_config` ( `name` , `value` ) VALUES ( 'mail_nom_expediteur', 'admin');

##menu
INSERT INTO `market_config` ( `name` , `value` ) VALUES('menuprive','Prive');
INSERT INTO `market_config` ( `name` , `value` ) VALUES('menulogout','Logout');
INSERT INTO `market_config` ( `name` , `value` ) VALUES('adresseforum','Adresse de votre forum');
INSERT INTO `market_config` ( `name` , `value` ) VALUES('nomforum','Nom de votre forum');
INSERT INTO `market_config` ( `name` , `value` ) VALUES('menuforum','Forum et IRC');
INSERT INTO `market_config` ( `name` , `value` ) VALUES('menuautre','Divers');

## votre forum
INSERT INTO `market_config` ( `name` , `value` ) VALUES('forum','logout');

## le skin par defaut du serveur
INSERT INTO `market_config` ( `name` , `value` ) VALUES('skin','skin/');

## Nombre maximum de trade par utilisateur et par univers autoris� (0 pour infini, attention au spam)
INSERT INTO `market_config` ( `name` , `value` ) VALUES('max_trade_by_universe','5');

## Dur�e maximum d'un trade (5 jours.... qu'on se retrouve pas avec des trades datant de 3 mois...)
INSERT INTO `market_config` ( `name` , `value` ) VALUES('max_trade_delay_seconds','432000');  

##Purge automatique des trades expires et de leur commentaires (1=oui , 0 = Non)
INSERT INTO `market_config` ( `name` , `value` ) VALUES('autopurgeexpiredtrade','1');   

## Delai apres expiration pour effacer les trades et commentaires
INSERT INTO `market_config` ( `name` , `value` ) VALUES('autopurgeexpiredtrade_delay','86400');   

## Nom du serveur , Afficher en titre de page Web
INSERT INTO `market_config` ( `name` , `value` ) VALUES('servername','OGSMARKET');

##  Type authentification des utilisateurs
## internal,ogspy,punbb,phpbb
INSERT INTO `market_config` ( `name` , `value` )VALUES('users_auth_type','internal');

## Activation automatique du serveur
INSERT INTO `market_config` ( `name` , `value` )VALUES('Activ_auto','1');

## Activation automatique des membres
INSERT INTO `market_config` ( `name` , `value` )VALUES('users_active', '0');

## Information BD pour les authentification non internal
##Base de donnee
INSERT INTO `market_config` ( `name` , `value` )VALUES('users_auth_db','');

## Table dans la base de donnee
INSERT INTO `market_config` ( `name` , `value` )VALUES('users_auth_table','');

## User de cette BD dauthentification
INSERT INTO `market_config` ( `name` , `value` )VALUES('users_auth_dbuser','');

## Url d inscription quand le type n est pas internal
INSERT INTO `market_config` ( `name` , `value` )VALUES('users_inscription_url','');

## Url Server et Mot de passe BD
INSERT INTO `market_config` ( `name` , `value` )VALUES ('users_adr_auth_db', '');
INSERT INTO `market_config` ( `name` , `value` )VALUES('users_auth_dbpassword','');
INSERT INTO `market_config` ( `name` , `value` )VALUES ('market_read_access', '0');
INSERT INTO `market_config` ( `name` , `value` )VALUES ('market_write_access', '0');
INSERT INTO `market_config` ( `name` , `value` )VALUES ('market_password', '');

## Taux de Change
INSERT INTO `market_config` (`name`, `value`) VALUES ('tauxmetal', '1'),('tauxcristal', '2'),('tauxdeuterium', '3');

## Visualisation des offres limitee aux membres
INSERT INTO `market_config` (`name` , `value` ) VALUES ('view_trade', '0');

## Lien du logo Serveur
INSERT INTO `market_config` (`name`, `value`) VALUES ('logo_server', '');
