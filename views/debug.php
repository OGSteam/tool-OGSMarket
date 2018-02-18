<?php
/***************************************************************************
*	filename	: debug.php
*	desc.		: 
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 21/11/2005
*	modified	: 26/12/2005 21:09:27

***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

// Liste des Variables de session
echo '<TABLE BORDER=0 CELLPADDING=3 CELLSPACING=1 WIDTH=600 BGCOLOR="#000000" ALIGN="CENTER">';
echo '<tr bgcolor="#9999CC"><td class="c" colspan="2">Variables de session</td></tr>';

if (isset($_SESSION))
  foreach ($_SESSION as $key=>$value)
  {
    if (is_array($value))
    {
      echo "<tr bgcolor=\"#CCCCCC\"><td nowrap bgcolor=\"#CCCCFF\">$key</td><td>";
      foreach ($value as $inckey=>$incval)
        echo "[$inckey]=>$incval<br />"; 
        echo '</td></tr>';
    }
    else  
      echo "<tr bgcolor=\"#CCCCCC\"><td nowrap bgcolor=\"#CCCCFF\">$key</td><td>$value</td></tr>";
  }

// Liste des variables passées dans l'URL. NB : Il n'y a pas de gestion des tableaux dans ce cas
echo '<tr  bgcolor="#9999CC"><td class="c" colspan="2">Variables passées en URL</td></tr>';
if (isset($_GET))
  foreach ($_GET as $key=>$value)
  {
    echo "<tr><th nowrap>$key</th><th>$value</td></th>";
  }

// Liste des variables transmises par formulaire
echo '<tr  bgcolor="#9999CC"><td class="c" colspan="2">Variables passées par formulaire</td></tr>';
if (isset($_POST))
  foreach ($_POST as $key=>$value)
  {
    if (is_array($value))
    {
      echo "<tr><th nowrap>$key</th><th>";
      foreach ($value as $inckey=>$incval)
	echo "[$inckey]=>$incval<br />"; 
	echo '</th></tr>';
    }
   else  
     echo "<tr><th nowrap>$key</td><th>$value</th></tr>";
  }
// Liste des variables transmises par Cookies
echo '<tr  bgcolor="#9999CC"><td class="c" colspan="2">Variables passées par Cookies</td></tr>';
if (isset($_COOKIE))
    foreach ($_COOKIE as $key=>$value)
    {
        if (is_array($value))
        {
            echo "<tr><th nowrap>$key</th><th>";
            foreach ($value as $inckey=>$incval)
                echo "[$inckey]=>$incval<br />";
            echo '</th></tr>';
        }
        else
            echo "<tr><th nowrap>$key</td><th>$value</th></tr>";
    }
echo '</table>';
?>
