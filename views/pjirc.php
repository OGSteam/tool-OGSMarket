<?php
/***************************************************************************
*	filename	: pjirc.php
*	desc.		:
*	Author		:	ericalens 
*	created		: 	04/06/2006
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
require_once("views/page_header.php");
?>
<applet name="applet" codebase="pjirc/" code=IRCApplet.class archive="irc.jar,pixx.jar" width=640 height=400>
<param name="CABINETS" value="irc.cab,securedirc.cab,pixx.cab">

<param name="nick" value="<?php if (isset($user_data)) echo $user_data["name"];?>">
<param name="alternatenick" value="OgsmUser???">
<param name="name" value="Java User">
<param name="host" value="irc.sorcery.net">
<param name="gui" value="pixx">
<param name="command1" value="join #OGSMarket">
<param name="style:bitmapsmileys" value="true">
<param name="style:smiley1" value=":) img/sourire.gif">
<param name="style:smiley2" value=":-) img/sourire.gif">
<param name="style:smiley3" value=":-D img/content.gif">
<param name="style:smiley4" value=":d img/content.gif">
<param name="style:smiley5" value=":-O img/OH-2.gif">
<param name="style:smiley6" value=":o img/OH-1.gif">
<param name="style:smiley7" value=":-P img/langue.gif">
<param name="style:smiley8" value=":p img/langue.gif">
<param name="style:smiley9" value=";-) img/clin-oeuil.gif">
<param name="style:smiley10" value=";) img/clin-oeuil.gif">
<param name="style:smiley11" value=":-( img/triste.gif">
<param name="style:smiley12" value=":( img/triste.gif">
<param name="style:smiley13" value=":-| img/OH-3.gif">
<param name="style:smiley14" value=":| img/OH-3.gif">
<param name="style:smiley15" value=":'( img/pleure.gif">
<param name="style:smiley16" value=":$ img/rouge.gif">
<param name="style:smiley17" value=":-$ img/rouge.gif">
<param name="style:smiley18" value="(H) img/cool.gif">
<param name="style:smiley19" value="(h) img/cool.gif">
<param name="style:smiley20" value=":-@ img/enerve1.gif">
<param name="style:smiley21" value=":@ img/enerve2.gif">
<param name="style:smiley22" value=":-S img/roll-eyes.gif">
<param name="style:smiley23" value=":s img/roll-eyes.gif">
<param name="pixx:nickfield" value="true">
<param name="pixx:styleselector" value="true">
<param name="style:highlightlinks" value="true">
<param name="pixx:showchanlist" value="false">
<param name="pixx:showabout" value="false">
</applet>

<FORM>
  <INPUT TYPE=BUTTON VALUE="Smile" onClick="document.applet.setFieldText(document.applet.getFieldText()+':)');document.applet.requestSourceFocus()">
  <INPUT TYPE=BUTTON VALUE="Chanlist" onClick="document.applet.sendString('/list')">
</FORM>
<?php
require_once("views/page_tail.php");

?>
