<?php
/***********************************************************************
 * filename	:	Convertisseur.php
 * desc.	:	Fichier principal
 * created	: 	06/11/2006	Mirtador
 * edited	:	04/07/2007	Ninety
 * *********************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

require_once ('views/page_header.php');

$tauxm = $server_config['tauxmetal'];
$tauxc = $server_config['tauxcristal'];
$tauxd = $server_config['tauxdeuterium'];

/* Si Tradeid, on prérempli les champs*/

if(isset($pub_tradeid)){

    $trade = $Trades->trades_array("uniquetrade",$pub_tradeid);
    $metal = $trade['offer_metal'] * 1000;
    $cristal = $trade['offer_crystal'] * 1000;
    $deut = $trade['offer_deuterium'] *1000;

    $percentM = $trade['want_metal'];
    $percentC = $trade['want_crystal'];
    $percentD = $trade['want_deuterium'];
}

?>
<script>
    $(document).ready(function() {

        const config_taux_metal = '<?php echo($tauxm); ?>';
        const config_taux_cristal = '<?php echo($tauxc); ?>';
        const config_taux_deut = '<?php echo($tauxd); ?>';
        const trade_id = '<?php if(isset($pub_tradeid)) echo($pub_tradeid); else echo 0; ?>';
        const trade_metal = '<?php if(isset($metal)) echo($metal); else echo 0; ?>';
        const trade_cristal = '<?php if(isset($cristal)) echo($cristal); else echo 0; ?>';
        const trade_deut = '<?php if(isset($deut)) echo($deut); else echo 0; ?>';
        const trade_wanted_metal = '<?php if(isset($percentM)) echo($percentM); else echo 0; ?>';
        const trade_wanted_cristal = '<?php if(isset($percentC)) echo($percentC); else echo 0; ?>';
        const trade_wanted_deut = '<?php if(isset($percentD)) echo($percentD); else echo 0; ?>';

        function check_percentage_ok(){

            var total_percentage = parseInt($('#combienm').val()) + parseInt($('#combienc').val()) + parseInt($('#combiend').val());
            if(total_percentage != 100)
            {
                $('#metalwanted').val('-');
                $('#cristalwanted').val('-');
                $('#deutwanted').val('-');

                return false;
            }
            return true;
        }

        function calculate_expected_ressources(){

            let metal_sold = parseInt($('#metal').val(), 10);
            let cristal_sold = parseInt($('#cristal').val(), 10);
            let deuterium_sold = parseInt($('#deuterium').val(), 10);
            let taux_m = parseFloat($('#tauxm').val());
            let taux_c = parseFloat($('#tauxc').val());
            let taux_d = parseFloat($('#tauxd').val());
            let wanted_metal_m = $('#combienm').val();
            let wanted_metal_c = $('#combienc').val();
            let wanted_metal_d = $('#combiend').val();

            let metal_asked = Math.round((wanted_metal_m / 100)*( metal_sold + cristal_sold *(taux_c/taux_m) + deuterium_sold *(taux_d /taux_m)));
            let cristal_asked = Math.round((wanted_metal_c / 100)*( cristal_sold + metal_sold *(taux_m/taux_c) + deuterium_sold *(taux_d /taux_c)));
            let deut_asked = Math.round((wanted_metal_d / 100)*( deuterium_sold + metal_sold *(taux_m/taux_d) + cristal_sold *(taux_c /taux_d)));


            $('#metalwanted').text(metal_asked);
            $('#cristalwanted').text(cristal_asked);
            $('#deutwanted').text(deut_asked);

            let total_wanted = metal_asked + cristal_asked + deut_asked;

            if(total_wanted > 0){
                let required_pt = Math.ceil(total_wanted / 5000);
                let required_gt = Math.ceil(total_wanted / 25000);
                $('#required_pt').text(required_pt);
                $('#required_gt').text(required_gt);
            }
            if(check_percentage_ok()){
                generate_bbcode(metal_sold,cristal_sold,deuterium_sold,taux_m,taux_c,taux_d,metal_asked,cristal_asked,deut_asked);
            }

        }

        function check_taux(){

            let taux_m = parseFloat($('#tauxm').val());
            let taux_c = parseFloat($('#tauxc').val());
            let taux_d = parseFloat($('#tauxd').val());

            if (taux_m > taux_c || taux_m > taux_d || taux_c > taux_d)
            {
                $('#tauxm').val(config_taux_metal);
                $('#tauxc').val(config_taux_cristal);
                $('#tauxd').val(config_taux_deut);

            }
        }

        function generate_bbcode(metal_sold, cristal_sold, deuterium_sold, taux_m = 0, taux_c = 0, taux_d = 0, metal_asked, cristal_asked, deut_asked ){

            let trader_nb_pt = Math.ceil((metal_sold + cristal_sold +deuterium_sold)/5000);
            let trader_nb_gt = Math.ceil((metal_sold + cristal_sold +deuterium_sold)/25000);

            let receiver_nb_pt = Math.ceil((metal_asked + cristal_asked + deut_asked)/5000);
            let receiver_nb_gt = Math.ceil((metal_asked + cristal_asked + deut_asked)/25000)

            let bbcodetext = '';
            bbcodetext += '[align=center][size=18][b][color=red]Offre via OGSMarket[/color][/b][/size]';
            bbcodetext += '\n';
            bbcodetext += '\n';
            bbcodetext += '[i][b][color=green]Votre vendeur Offre[/color][/b][/i]\n';
            bbcodetext += 'Métal : [b]' + metal_sold + '[/b]\n';
            bbcodetext += 'Cristal : [b]' + cristal_sold + '[/b]\n';
            bbcodetext += 'Deutérium : [b]' + deuterium_sold + '[/b]\n';
            bbcodetext += 'Le nombre de transporteurs requis sera de ' + trader_nb_pt + 'PT ou ' + trader_nb_gt + ' GT (Hors Carburant)\n' ;
            bbcodetext += '\n';
            bbcodetext += '[i][b][color=green]Demande[/color][/b][/i]\n';
            bbcodetext += 'Métal : [b]' + metal_asked + '[/b]\n';
            bbcodetext += 'Cristal : [b]' + cristal_asked + '[/b]\n';
            bbcodetext += 'Deutérium : [b]' +deut_asked + '[/b]\n';
            bbcodetext += 'Le nombre de transporteurs requis sera de ' + receiver_nb_pt + 'PT ou ' + receiver_nb_gt + ' GT (Hors Carburant)\n' ;
            bbcodetext += '\n';
            if(taux_m !== 0 && taux_c !== 0 && taux_d !== 0 )
            {
                bbcodetext += 'Le taux constaté est (M/C/D) : [b]' + taux_m + ' / ' + taux_c +' / ' + taux_d + '[/b]\n';
            }
            bbcodetext += '[size=10][url=https://ogspy.fr/market]OGSMarket - Plateforme de Commerce[/url][/size]';
            bbcodetext += '[/align]';

            $('#bbcode').val(bbcodetext);

        }

        $('.convertisseur').change(function() {
                if(trade_id != 0 ){
                    $('#metal').val(parseInt(trade_metal));
                    $('#cristal').val(parseInt(trade_cristal));
                    $('#deuterium').val(parseInt(trade_deut));
                    $('#metalwanted').val(parseInt(trade_wanted_metal));
                    $('#cristalwanted').val(parseInt(trade_wanted_cristal));
                    $('#deutwanted').val(parseInt(trade_wanted_deut));

                    generate_bbcode(trade_metal,trade_cristal,trade_deut,0,0,0,trade_wanted_metal,trade_wanted_cristal,trade_wanted_deut);

                }
                check_taux();
                check_percentage_ok();                     
                calculate_expected_ressources();
            }
        )

    });
</script>

<p>Le générateur de ressources permet de préparer votre offre pour les acheteurs. Le total de GT/PT nécessaires est une indication et n'inclue pas le carburant.</p>


<table align="center" class="convertisseur">
	<tr>
		<td class="c" align="center" colspan="8"><b>Convertisseur de ressources<b></td>
	</tr>
	<tr>
		<th>Ressources</th>
		<th>Quantit&eacute;s Vendues (Unit&eacute;s)</th>
		<th>Taux</th>
		<th>Pourcentage</th>
        <th>Ressources demandées</th>
        <th>PT Nécessaires</th>
        <th>GT Nécessaires</th>
	</tr>
	<tr>
		<th>M&eacute;tal</th>
		<th><input type="text" id="metal" name="metal" value="0" tabindex="1" /></th>
		<th><input type="text" id="tauxm" name="tauxm" value="<?php echo $tauxm; ?>" tabindex="4" /></th>
		<th><input type="text" id="combienm" name="combienm" value="0" tabindex="7" /></th>
        <th><span id="metalwanted">0</span></th>
        <th id="required_pt" rowspan="3">0</th>
        <th id="required_gt" rowspan="3">0</th>
	</tr>
	<tr>
		<th>Cristal</th>
		<th><input type="text" id="cristal" name="cristal" value="0" tabindex="2" /></th>
		<th><input type="text" id="tauxc" name="tauxc" value="<?php echo $tauxc; ?>" tabindex="5" /></th>
		<th><input type="text" id="combienc" name="combienc" value="0" tabindex="8" /></th>
        <th><span id="cristalwanted">0</span></th>

	</tr>
	<tr>
		<th>Deut&eacute;rium</th>
		<th><input type="text" id="deuterium" name="deuterium" value="0" tabindex="3" /></th>
		<th><input type="text" id="tauxd" name="tauxd" value="<?php echo $tauxd; ?>" tabindex="6" /></th>
		<th><input type="text" id="combiend" name="combiend" value="100" tabindex="9" /></th>
        <th><span id="deutwanted">0</span></th>

	</tr>
</table>

<br>
<br>
<table align="center" width="60%">
	<tr>
		<td class="c" align="center"><b>Offre en BBCode pour les forums</b></td>
	</tr>
	<tr>
		<th>
            <textarea id="bbcode" rows="15" cols="20">Veuillez compléter votre offre et les pourcentages souhaités dans le tableau ci-dessus</textarea>
		</th>
	</tr>
</table>
<?php
require_once("views/page_tail.php");
?>