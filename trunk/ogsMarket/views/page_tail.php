<?php
/***************************************************************************
*	filename	: page_tail.php
*	desc.		:
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 08/12/2005
*	modified	: 19/01/2006 02:47:19
*	modified	: 04/06/2006 ericalens , Adaptation OGSMarket
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

$php_end = benchmark();
$php_timing = $php_end - $php_start - $sql_timing;
?>
	</td>
</tr>
<tr align="center" width="110">
	<td>&nbsp;</td>
	<td widh="110"><em><?php echo $Universes->count() .' univers'; ?></em></td>
</tr>
<tr align="center">
	<td>&nbsp;</td>
	<td>
		<center>
			<font size="2">
				<i><b><a href="http://ogsteam.fr" target="_blank">OGSMarket</a></b> is a <b>OGSTeam Software</b> &copy; 2010</i><br />v <?php echo $server_config["version"];?><br />
				<i>Temps de génération <?php echo round($php_timing+$sql_timing, 3);?> sec (<b>PHP</b> : <?php echo round($php_timing, 3);?> / <b>SQL</b> : <?php echo round($sql_timing, 3);?>)<br /></i>
			</font>
		</center>
	</td>
</tr>
</table>
</body>
</html>

