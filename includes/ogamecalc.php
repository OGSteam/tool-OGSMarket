<?php
/***********************************************************************
 * filename	:	ogamecalc.php
 * desc.	:	Fonctions diverses relatives a ogame
 * created	: 	jeudi 22 juin 2006, 04:13:11 (UTC+0200)
 * *********************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

function taux_echange($M,$C,$D,$OM,$OC,$OD) {
	
	if ($M > 0 && $C == 0 && $D == 0) { $sens="offre"; }
	elseif ($M == 0 && $C > 0 && $D == 0) $sens="offre";
	elseif ($M == 0 && $C == 0 && $D > 0) $sens="offre";
	elseif ($M > 0 && $C > 0 && $D == 0) $sens="demande";
	elseif ($M == 0 && $C > 0 && $D > 0) $sens="demande";
	elseif ($M > 0 && $C == 0 && $D > 0) $sens="demande";
	elseif ($M > 0 && $C > 0 && $D > 0)  $sens = "nul";
		
	switch ($sens){
		case "offre":
			if ($M) {
				$ret="1M :";
				if ($OC) {
					$ret .= " ".number_format($OC/$M,2)."C  ";
				}
				if ($OD){
		
					$ret .= " ".number_format($OD/$M,2)."D  ";
				}
			}elseif ($C) {
				$ret="1C :";
				if ($OM) {
					$ret .= " ".number_format($OM/$C,2)."M  ";
				}
				if ($OD){
		
					$ret .= " ".number_format($OD/$C,2)."D  ";
				}
			}elseif ($D){
				$ret="1D :";
				if ($OM) {
					$ret .= " ".number_format($OM/$D,2)."M  ";
				}
				if ($OC){
		
					$ret .= " ".number_format($OC/$D,2)."C  ";
				}
			}else $ret ="Pas de taux calculable";
		Break;
	
		case "demande":
			if ($OM) {
				$ret="1M :";
				if ($C) {
					$ret .= " ".number_format($C/$OM,2)."C  ";
				}
				if ($D){
		
					$ret .= " ".number_format($D/$OM,2)."D  ";
				}
			}elseif ($OC) {
				$ret="1C :";
				if ($M) {
					$ret .= " ".number_format($M/$OC,2)."M  ";
				}
				if ($D){
		
					$ret .= " ".number_format($D/$OC,2)."D  ";
				}
			}elseif ($OD){
				$ret="1D :";
				if ($M) {
					$ret .= " ".number_format($M/$OD,2)."M  ";
				}
				if ($C){
		
					$ret .= " ".number_format($C/$OD,2)."C  ";
				}
			}else $ret ="Pas de taux calculable";
		break;
	
		case "nul":
			$ret ="Pas de taux calculable";
		break;
	}	
		return $ret;
}

function rapport($M,$C,$D,$OM,$OC,$OD) {
	
	if ($M > 0 && $C == 0 && $D == 0) $sens = "offre";
	elseif ($M == 0 && $C > 0 && $D == 0) $sens = "offre";
	elseif ($M == 0 && $C == 0 && $D > 0) $sens = "offre";
	elseif ($M > 0 && $C > 0 && $D == 0) $sens = "demande";
	elseif ($M == 0 && $C > 0 && $D > 0) $sens = "demande";
	elseif ($M > 0 && $C == 0 && $D > 0) $sens = "demande";
	elseif ($M > 0 && $C > 0 && $D > 0)  $sens = "nul";

	switch ($sens){
		case "offre":
			if ($M) {
				$ret="Coeff : ";
				if ($OC) {
					$ret .= "- C = ".number_format(($OC/$M)*100,0)." % du M -";
				}
				if ($OD){
		
					$ret .= "- D = ".number_format(($OD/$M)*100,0)." % du M -";
				}
			}elseif ($C) {
				$ret="Coeff :";
				if ($OM) {
					$ret .= "- M = ".number_format(($OM/$C)*100,0)." % du C -";
				}
				if ($OD){
		
					$ret .= "- D = ".number_format(($OD/$C)*100,0)." % du C -";
				}
			}elseif ($D){
				$ret="Coeff :";
				if ($OM) {
					$ret .= "- M = ".number_format(($OM/$D)*100,0)." % du D -";
				}
				if ($OC){
		
					$ret .= "- C = ".number_format(($OC/$D)*100,0)." % du D -";
				}
			}else $ret ="Pas de taux calculable";
		break;
	
		case "demande":
			if ($OM) {
				$ret="Coeff : ";
				if ($C) {
					$ret .= "- C = ".number_format(($C/$OM)*100,0)." % du M -";
				}
				if ($D){
		
					$ret .= "- D = ".number_format(($D/$OM)*100,0)." % du M -";
				}
			}elseif ($OC) {
				$ret="Coeff :";
				if ($M) {
					$ret .= "- M = ".number_format(($M/$OC)*100,0)." % du C -";
				}
				if ($D){
		
					$ret .= "- D = ".number_format(($D/$OC)*100,0)." % du C -";
				}
			}elseif ($OD){
				$ret="Coeff :";
				if ($M) {
					$ret .= "- M = ".number_format(($M/$OD)*100,0)." % du D -";
				}
				if ($C) {
		
					$ret .= "- C = ".number_format(($C/$OD)*100,0)." % du D -";
				}
			}else $ret ="Pas de taux calculable";
		break;
		
		case "nul":
			$ret ="Pas de taux calculable";
		break;
	}
	return $ret;
}
?>