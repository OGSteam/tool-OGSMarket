<?php
/***************************************************************************
*	filename	: debug2.php
*	desc.		:
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 17/12/2005
*	modified	: 28/12/2005 23:56:40
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

ob_start();
phpinfo();
$info = ob_get_contents();
ob_end_clean();
preg_match_all("=<body[^>]*>(.*)</body>=siU", $info, $tab);
$val_phpinfo = $tab[1][0];
$val_phpinfo = str_replace('<td class="e">', '<td class="c">', $val_phpinfo);
$val_phpinfo = str_replace('<td class="v">', '<td class="c">', $val_phpinfo);


?>

<table width="80%" align="center">
	<tr>
		<td width="100%" align="center" border="1">
			<?php
			echo $val_phpinfo;
			?>
		</td>
	</tr>
</table>

<?php
require_once("views/page_tail.php");
?>
