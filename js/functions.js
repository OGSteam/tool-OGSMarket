/* Fonction qui inverse l'etat de checkbox */

function inverse(idOfCheckBox)
{
	var checkboxes = $("[name^=\"" + idOfCheckBox + "\"]");
	checkboxes.each(function(index, element)
	{
		if (element.checked) {
			element.checked = false;
        }
		else {
			element.checked = true;
        }
	});
}

function untick_all(idOfCheckBox)
{
    var checkboxes = $("[name^=\"" + idOfCheckBox + "\"]");

    checkboxes.each(function(index, element)
    {
            element.checked = false;
    });
}


function tick_all(idOfCheckBox)
{
    var checkboxes = $("[name^=\"" + idOfCheckBox + "\"]");

    checkboxes.each(function(index, element)
    {
            element.checked = true;
    });
}



/* Code executer apres le chargement de la page */

$( window ).on("load", function() {

	/* Page "Nouvelle offre" -- Inversion des galaxie */
	
	$("[id^=inverse]").each(function( index, element)
	{
        $( this ).click( function()
		{
			inverse(element.id.split("-")[1]);
		});
	});

	
	/* Pop-up pour la creation/edition des marches */
	
	// Creation

	$("#create_market").click( function()
	{
		$("#new_market").show();
        $("#admin_maction").val("admin_new_univers_execute");

	});
	
	// Edition

	$("[id^=edit_market_]").each(function(index, element)
	{
		var id = element.id.split("_")[2];

        $( this ).click( function()
		{
			$("#new_market").show();
			
			$("#admin_mid").val(id);
			$("#admin_maction").val("admin_edit_univers_execute");
			
			$("#admin_mname").val ($("#name_" + id).text());
			$("#admin_minfo").val ($("#info_" + id).text());
			$("#admin_mg").val ($("#g_" + id).text());
			
			$("#action").val("Modifier");
		});
	});
	
	// Cache la pop-up
	$("#hide_new_market").click( function()
	{
		$("#new_market").hide();
	});
});
