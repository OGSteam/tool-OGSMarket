<?php
/***************************************************************************
*	filename	: 	univers.php
*	desc.		:
*	Author		:	ericalens
*	created		: 	05/06/2006
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	exit('Hacking attempt');
}

class cUniverses
{
	private $Universes = array();

	// Retourne le nombre d'univers crees
	public function count()
	{
		global $db;

		$result = $db->sql_query('SELECT COUNT(*) FROM '.TABLE_UNIVERS);
		$rowcount = $db->sql_fetch_row($result);

		return $rowcount[0];
	}


	// Ajoute un nouvel univers et renvoie un tableau sur ce nouvel univers
	public function insert_new($info, $name, $g)
	{
		global $db;

		// Variables manquantes
		if ($name == '' && $info == '')
			return 'Il manque des informations !';

		// L'univers existe deja
		$result = $db->sql_query('SELECT COUNT(*) FROM '.TABLE_UNIVERS.' WHERE name = \''.$db->sql_escape_string($name).'\'');
		$rowcount = $db->sql_fetch_row($result);

		if ($rowcount[0] != 0)
			return 'Cet univers existe d&eacute;j&agrave;';

		// Insertion dans la BDD
		$sql = 'INSERT INTO '.TABLE_UNIVERS.' (\'info\', \'name\', \'g\')
				VALUES(\''. $db->sql_escape_string($info).'\', \''.$db->sql_escape_string($name).'\', \''.intval($g).'\')';

		// Renvoie des resultats
		if ($db->sql_query($sql) != false)
		{
			$newvalues = array(
				'id'	=> $db->sql_insertid(),
				'info'	=> $info,
				'name'	=> $name,
				'ng'	=> $g);

			return 'Le nouvel univers a bien &eacute;t&eacute; cr&eacute;&eacute;.';
		}
		else
		{
			$error = $db->sql_error();

			return 'Erreur MySQL ('.$error['code'].') : "'.$error['message'].'".';
		}
	}


	// Retourne un tableau de tout les univers de la BDD
	public function universes_array()
	{
		global $db;

		$this->Universes = array();
		$result = $db->sql_query('SELECT * FROM '.TABLE_UNIVERS.' ORDER BY name ASC');

		while (list($id, $info, $name, $g) = $db->sql_fetch_row($result))
		{
			$this->Universes[] = array(
				'id'	=> $id,
				'info'	=> $info,
				'name'	=> $name,
				'g'		=> $g);
		}

		return $this->Universes;
	}


	// Recuperation d'un univers a partir de son ID sous forme de tableau, renvoie false si pas trouve
	public function get_universe($universeid)
	{
		global $db;

		$result = $db->sql_query('SELECT * FROM '.TABLE_UNIVERS.' WHERE id = \''.intval($universeid).'\'');

		if (list($id, $info, $name, $g) = $db->sql_fetch_row($result))
		{
			$uni = array(
				'id'	=> $id,
				'info'	=> $info,
				'name'	=> $name,
				'g'		=> $g);

			return $uni;
		}

		return false;
	}


	// Effacement d'un univers a partir de son ID
	public function delete_universe($universeid)
	{
		global $db;

		$sql = 'DELETE FROM '.TABLE_UNIVERS.' WHERE id = \''.intval($universeid).'\'';

		if ($db->sql_query($sql) != false)
			return 'L\'univers a bien &eacute;t&eacute; supprim&eacute;.';
		else
			return 'L\'univers n\'a pas &eacute;t&eacute; supprim&eacute; !';
	}


	// Modification d'un univers
	public function edit_universe($universeid, $universeinfo, $universename, $g)
	{
		global $db;

		$sql = 'UPDATE '.TABLE_UNIVERS.'
				SET
					info = \''. $universeinfo.'\',
					name = \''. $universename.'\',
					g = \''. intval($g).'\'
				WHERE id = \''. intval($universeid).'\'';

		if ($db->sql_query($sql) != false)
			return 'L\'univers a bien &eacute;t&eacute; modifi&eacute;.';
		else
			return 'L\'univers n\'a pas &eacute;t&eacute; modifi&eacute; !';
	}


	// Retourne un univers au format XML
	public function get_universe_xml($universe)
	{
		$univers_xml = "\n\t".'<universe>';
		$univers_xml .= "\n\t\t".'<id>'.$universe['id'].'</id>';
		$univers_xml .= "\n\t\t".'<url>'.$universe['info'].'</url>';
		$univers_xml .= "\n\t\t".'<name>'.$universe['name'].'</name>';
		$univers_xml .= "\n\t".'</universe>';

		return $univers_xml;
	}


	// Fonction utile mais on sait pas a quoi elle sert =D
	public function init_current_uni()
	{
		global $pub_uni, $_COOKIE;

		if (isset($_COOKIE['ogsmarket_session']))
		{
			$cookie = unserialize(stripslashes($_COOKIE['ogsmarket_session']));
			setcookie('ogsmarket_uni', $pub_uni, $cookie['validate']);
		}
		else
			setcookie('ogsmarket_uni', $pub_uni, time() + 3600*24);
	}
}
// Creation d'un objet cUniverses
$Universes = new cUniverses();
