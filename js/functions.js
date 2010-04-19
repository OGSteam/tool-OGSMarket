/* Fonction qui inverse l'etat de checkbox */

function inverse(idOfCheckBox)
{
	var checkboxes = $$('input[name^="' + idOfCheckBox + '"]');
	
	checkboxes.each(function(element)
	{
		if (element.checked)
			element.checked = false;
		else
			element.checked = true;
	});
}


/* Code executer apres le chargement de la page */

Event.observe(window, 'load', function()
{
	/* Page "Nouvelle offre" -- Inversion des galaxie */
	
	$$('input[id^="inverse"]').each(function(element)
	{
		element.observe('click', function()
		{
			inverse(element.id.split('-')[1]);
		});
	});
	
	
	/* Date pour le menu */
	
	var date, hour, min, sec, day, day_number, month,
		days = new Array('Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'),
		months = new Array('Jan', 'Fév', 'Mars', 'Avril', 'Mai', 'Juin', 'Jul', 'Août', 'Sep', 'Oct', 'Nov', 'Déc');
	
	new PeriodicalExecuter(function()
	{
		date = new Date,
		hour = date.getHours(),
		min = date.getMinutes(),
		sec = date.getSeconds(),
		day = days[date.getDay()],
		day_number = date.getDate(),
		month = months[date.getMonth()];
		
		if (sec < 10) sec = '0' + sec;
		if (min < 10) min = '0' + min;
		if (hour < 10) hour = '0' + hour;
		
		$('datetime').update(day + ' ' + day_number + ' ' + month +  ' ' + hour + ':' + min + ':' + sec);
	}, 1);
	
	
	/* Pop-up pour la creation/edition des marches */
	
	// Creation
	$('create_market').observe('click', function()
	{
		$('new_market').style.display = 'block';
		$('admin_maction').value = 'admin_new_univers_execute';
	});
	
	// Edition
	$$('input[id*="edit_market_"]').each(function(element)
	{
		var id = element.id.split('_')[2];
		
		element.observe('click', function()
		{
			$('new_market').style.display = 'block';
			
			$('admin_mid').value = id;			
			$('admin_maction').value = 'admin_edit_univers_execute';
			
			$('admin_mname').value = $('name_' + id).textContent;
			$('admin_minfo').value = $('info_' + id).textContent;
			$('admin_mg').value = $('g_' + id).textContent;
			
			$('action').value = 'Modifier';
		});
	});
	
	// Cache la pop-up
	$('hide_new_market').observe('click', function()
	{
		$('new_market').hide();
	});
});
