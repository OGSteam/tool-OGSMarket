<?php
/***************************************************************************
*    filename    : rss.php
*    desc.        :
*    Author        : Jey2k - http://ogsteam.fr/
*    created        : 18/08/2006
***************************************************************************/
if (!defined('IN_OGSMARKET')) {
    die("Hacking attempt");
}
require_once("views/page_header_xml.php");
require_once("includes/ogamecalc.php");
function affiche_icone($ouinon) {
    if ($ouinon == "1")
    {
        echo "<img src=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."/../images/graphic_ok.gif\" width=\"20\"/>";
    } else {
        echo "<img src=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."/../images/graphic_cancel.gif\" width=\"20\"/>";
    }
}
?>
<rss version="2.0">
<channel>
<title><?php echo utf8_encode($server_config["servername"]." - ".$server_config["version"]); ?></title>
<link>http://<?php echo $_SERVER['HTTP_HOST']; ?>/</link>
<description><?php echo utf8_encode($server_config["servername"]." - ".$server_config["version"]); ?></description>
<language>fr-ch</language>


<?php
    foreach ($Trades->trades_array($current_uni["id"], $orderby, false) as $trade) { //boucle pour afficher toutes les offres
?>
<item>
<title><?php 
echo $trade["username"]; 
    // Test si il n'y a qu'une ressource en vente ou en achats !
    if (($trade["offer_metal"] == 0 && $trade["offer_crystal"] == 0) || 
    ($trade["offer_crystal"] == 0 && $trade["offer_deuterium"] == 0 || 
    ($trade["offer_metal"] == 0 && $trade["offer_crystal"] == 0))) {
        echo " vend  ";
        if ($trade["offer_metal"] != 0) echo number_format($trade["offer_metal"])."k de Metal ";
        if ($trade["offer_crystal"] != 0) echo number_format($trade["offer_crystal"])."k de Crystal ";
        if ($trade["offer_deuterium"] != 0) echo number_format($trade["offer_deuterium"])."k de Deuterium ";
    }
elseif (($trade["want_metal"] == 0 && $trade["want_crystal"] == 0) || 
    ($trade["want_crystal"] == 0 && $trade["want_deuterium"] == 0 || 
    ($trade["want_metal"] == 0 && $trade["want_crystal"] == 0))) {
        echo " cherche ";
        if ($trade["want_metal"] != 0) echo number_format($trade["want_metal"])."k de Metal ";
        if ($trade["want_crystal"] != 0) echo number_format($trade["want_crystal"])."k de Crystal ";
        if ($trade["want_deuterium"] != 0) echo number_format($trade["want_deuterium"])."k de Deuterium ";
    }
else echo " organise une vente ";
echo "dans l'".$current_uni["name"]; ?></title>
<link>http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?action=viewtrade&amp;tradeid=".$trade["id"]; ?></link>
<description><![CDATA[
Offre : <?php
 if ($trade["offer_metal"] != 0) echo number_format($trade["offer_metal"])."k de Metal, ";
 if ($trade["offer_crystal"] != 0) echo number_format($trade["offer_crystal"])."k de Crystal, ";
 if ($trade["offer_deuterium"] != 0) echo number_format($trade["offer_deuterium"])."k de Deuterium";
 ?><br />
 Demandes : <?php
 if ($trade["want_metal"] != 0) echo number_format($trade["want_metal"])."k de Metal, ";
 if ($trade["want_crystal"] != 0) echo number_format($trade["want_crystal"])."k de Crystal, ";
 if ($trade["want_deuterium"] != 0) echo number_format($trade["want_deuterium"])."k de Deuterium";
 ?>
 <br />
 Taux :<?php echo taux_echange($trade["offer_metal"], $trade["offer_crystal"], $trade["offer_deuterium"], $trade["want_metal"], $trade["want_crystal"], $trade["want_deuterium"]); ?>
<?php
echo "\n\n<br /><br />Livrable en: "; // Affiche les galaxie avec l'icone
echo "G1"; affiche_icone($trade["deliver_g1"]);
echo "G2"; affiche_icone($trade["deliver_g2"]);
echo "G3"; affiche_icone($trade["deliver_g3"]);
echo "G4"; affiche_icone($trade["deliver_g4"]);
echo "G5"; affiche_icone($trade["deliver_g5"]);
echo "G6"; affiche_icone($trade["deliver_g6"]);
echo "G7"; affiche_icone($trade["deliver_g7"]);
echo "G8"; affiche_icone($trade["deliver_g8"]);
echo "G9"; affiche_icone($trade["deliver_g9"]);

echo "\n\n<br /><br />Payable en: ";
echo "G1"; affiche_icone($trade["refunding_g1"]);
echo "G2"; affiche_icone($trade["refunding_g2"]);
echo "G3"; affiche_icone($trade["refunding_g3"]);
echo "G4"; affiche_icone($trade["refunding_g4"]);
echo "G5"; affiche_icone($trade["refunding_g5"]);
echo "G6"; affiche_icone($trade["refunding_g6"]);
echo "G7"; affiche_icone($trade["refunding_g7"]);
echo "G8"; affiche_icone($trade["refunding_g8"]);
echo "G9"; affiche_icone($trade["refunding_g9"]);
 ?>
<?php

$user2 = $Users->get_user($trade["pos_user"]);
if ($trade["note"] != '')echo " <br /> <br />Note :".$trade["note"];
if ($user2["name"] != '')echo " <br /><br />Offre r&eacute;serv&eacute;e par :".$user2["name"];
?>
]]></description>
<guid>http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?action=viewtrade&amp;tradeid=".$trade["id"]; ?></guid>
</item>
<?php
    }
?>
</channel>
</rss>