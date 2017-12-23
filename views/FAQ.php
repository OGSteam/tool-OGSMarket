<?php
/***********************************************************************
 * filename	:	FAQ.php
 * desc.	:
 * created	: 	11/07/06 Mirtador
 *
 * *********************************************************************/
if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
//définition des variable
$Utype = $server_config["users_auth_type"];
$NForum = $server_config["nomforum"];
$AForum = $server_config["adresseforum"];
$servername = $server_config["servername"];

require_once("views/page_header.php");
?>
<table width="90%">
	<tr>
		<td class="c" align="center"><b>Tutoriel OGSMarket</b></td>
	</tr>
	<tr>
		<th>
			<span style="color: sienna;"><strong><span class="bbu">
			<span style="font-family: Tahoma;">Pour proposer une offre:</span></span></strong></span><br>
			<br>

			<?php if ($Utype == "internal") { ?>
				<strong>Première chose à faire: s'inscrire sur la cartographie: <font color="#FF0000"><?php echo $servername; ?></font><br><br>
				<img alt="http://img364.imageshack.us/img364/9620/faq00mx8.jpg" src="http://img364.imageshack.us/img364/9620/faq00mx8.jpg" width="402" height="279"><br>
				Rien de très compliqué<br><br>
			<?php } else { ?>
				<strong>Première chose à faire: s'inscrire sur le forum de <?php echo $NForum; ?>:
				<a href="<?php echo $AForum; ?>"><?php echo $AForum; ?></a></strong><br>
				<strong>L'administrateur a  décidé de ne pas donner a ce OGmarket un propre base de donnée de membres.</strong><br>
				<br>
				<a href="http://membres.lycos.fr/tibbo30/TutoOGSMarket/OGSMarket02bis.JPG">
				<img class="postimg" src="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket02bis.JPG" alt="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket02bis.JPG" width="825" height="355"></a><br>
				<strong>Comme vous le voyez rien de rébarbatif, ni de personnel, seulement une
				adresse email valide.</strong><br>
				<br>
			<?php
				}
			?>
			<strong>Une fois inscrit, logez vous...</strong><br>
			<br>
			<img class="postimg" src="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket06.JPG" alt="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket06.JPG" width="154" height="166"><br>
			<br>
			<strong>...et choisissez votre univers dans le menu déroulant en haut à gauche
			de l'écran.</strong><br>
			<br>
			<img class="postimg" src="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket07.JPG" alt="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket07.JPG" width="150" height="150"><br>
			<br>
			<strong>Cliquez alors sur &quot;<span style="color: orangered;">Nouvelle offre</span>&quot;.</strong><br>
			<br>
			<img class="postimg" src="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket08.JPG" alt="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket08.JPG" width="118" height="178"><br>
			<br>
			<br>
			<strong>Un tableau apparaît alors:</strong><br>
			<br>
			&nbsp; &nbsp; *<strong>Dans la colonne &quot;<span style="color: orangered;">Offres</span>&quot; de
			gauche mettez ce que vous proposez en kilo (1000 devient 1, 1234 devient 1,234
			etc...). <br>
			&nbsp; &nbsp; *Dans le colonne &quot;<span style="color: orangered;">Demandes</span>&quot; saisissez
			ce que vous désirez en échange, toujours en kilo. </strong><br>
			&nbsp; &nbsp; *<strong>Changer le durée de l'offre dans la case &quot;<span style="color: orangered;">Expiration</span>&quot;
			si voulez que celle ci apparaissent plus de 24 sur le serveur.</strong><br>
			&nbsp; &nbsp; *<strong>Un champ &quot;<span style="color: orangered;">Note</span>&quot; est
			disponible si vous voulez donner des informations supplémentaires, du genre
			&quot;Promo du siècle&quot;, &quot;Affaire à saisir&quot;...</strong><br>
			<br>
			<strong>Cliquez enfin sur &quot;<span style="color: orangered;">Envoyer</span>&quot; pour
			mettre votre offre en ligne.</strong><br>
			<br>
			<img class="postimg" src="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket09.JPG" alt="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket09.JPG" width="478" height="508"><br>
			<br>
			<strong>Il est bien sur important de remplir de son &quot;<span style="color: orangered;">Profil</span>&quot;
			(dans le menu de gauche) afin que l'acheteur puisse vous contacter.<br>
			<br>
			Il est à noter que l'acheteur voit le taux de change dans la fenêtre principale,
			donc pas d'entourloupe possible...</strong><br>
			<br>
			<img class="postimg" src="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket10.JPG" alt="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket10.JPG" width="277" height="43"><br>
			<br>
			<strong>Vous pouvez utiliser ce logiciel afin de vous aider dans vos
			conversions: <a href="http://juper.free.fr/fear/ORC.exe">ORC</a></strong> <em>
			(peut être faudrait il l'intégrer...)</em><br>
			<br>
			<strong>Il ne vous reste maintenant plus qu'à patienter.</strong><br>
			<br>
			<br>
			<hr>Note de l'auteur (itea)
			<hr>
			<em>(tuto en cours de création, et en attente de la version définitive)</em><br>
			<br>
			Voilà, je me suis permis de faire un petit tuto pour expliquer rapidement le
			principe.<br>
			Cependant, j'attend pour rédiger la partie &quot;Choisir une offre&quot; car celle ci
			n'est pas encore opérationnelle. Mais cela ne devrait pas tarder si j'en juge
			l'effervescence que OGSMarket a créée.<br>
			J'attend vos critiques <a href="https://forum.ogsteam.fr/">ICI</a>, surtout qu'il s'agit de mon premier tutorial.</p>
		</th>
	</tr>
</table>

<?php
require_once("views/page_tail.php");
?>
