<?php
	/***************************************************************************
	*	filename	: message.php
	*	desc.		:
	*	Author		: Kyser - http://www.ogsteam.fr/
	*	created		: 09/12/2005
	*	modified	: 22/06/2006 00:13:20
	*	modified	: 22/09/2007 00:00:00
	***************************************************************************/

	if (!defined('IN_OGSMARKET'))
	 	die ('Hacking attempt');
	
	require_once ('views/page_header.php');
?>

<table align="center">
	<tr>
		<td class="c"><div align="center"><?php echo $message; ?></div></td>
	</tr>
</table>

<?php require_once ('views/page_tail.php');
if ($retour != "") redirection($retour);
 ?>
