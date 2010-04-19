<?php
	/***************************************************************************
	*	filename		:	xml.php
	*	Author		:	ericalens 
	*	created		: 	04/06/2006
	*	editer		:	28/09/2007
	***************************************************************************/
	
	if (!defined('IN_OGSMARKET'))
	 	die ('Hacking attempt');
	
	header ('Content-type: application/rss+xml');	
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';
	if ($sub == "univers"){
		echo "\n	<market>\n";
		echo "		<universes_list>\n";
		foreach($Universes->universes_array() as $universe){
			echo "			".$Universes->get_universe_xml($universe)."\n";
		}
		echo "		</universes_list>\n";
		echo "	</market>";
	}
	elseif ($sub == "trade"){
		if(!isset($pub_sortby)) $pub_sortby = "";
		echo "\n	<market>\n";
		switch ($server_config["market_read_access"]){
			case "0":
				echo "<access><TYPE>Public</TYPE><RESULT>OK</RESULT></access>";
				affiche_liste($pub_sortby,$current_uni);
				break;
			case "1":
				if(!isset($pub_marketpwd)) $pub_marketpwd = "";
				if (cModMarket::checkMD5Password($pub_marketpwd)) {
					echo "<access><TYPE>Password</TYPE><RESULT>OK</RESULT></access>";
					affiche_liste($pub_sortby,$current_uni);
				} else {
					echo "<access><TYPE>Password</TYPE><RESULT>NOK</RESULT></access>";
				}
				break;
			case "2":
				if(!isset($pub_ogspyurl)) $pub_ogspyurl = "";
				if (cModMarket::checkURLAuth($pub_ogspyurl,'read')){
					echo "<access><TYPE>URI</TYPE><RESULT>OK</RESULT></access>";
					affiche_liste($pub_sortby,$current_uni);
				} else {
					echo "<access><TYPE>URI</TYPE><RESULT>NOK:".$pub_ogspyurl."</RESULT></access>";
				}
				break;
			case "3":
				if(!isset($pub_marketpwd)) $pub_marketpwd = "";
				if(!isset($pub_ogspyurl)) $pub_ogspyurl = "";
				if ((cModMarket::checkURLAuth($pub_ogspyurl,'read'))&&(cModMarket::checkMD5Password($pub_marketpwd))) {
					echo "<access><TYPE>URI</TYPE><RESULT>OK</RESULT></access>";
					affiche_liste($pub_sortby,$current_uni);
				} else {
					echo "<access><TYPE>URI</TYPE><RESULT>NOK</RESULT></access>";
				}
				break;
			default:
				echo "<ERROR>Mauvais type identification</ERROR>";
		}
		echo "	</market>";
	}
	elseif ($sub == "ping"){
		echo "\n	<market>\n";
		echo "		<ping>ok</ping>\n";
		echo "	</market>\n";
	}