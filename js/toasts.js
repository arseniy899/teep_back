class Toast
{
	static showAjaxRes(code, text)
	{
		if(code instanceof Object)
			Toast.showAjaxResObj(code);
		else
		{
			if(code == 0)
				Lobibox.notify('success', {
					size: 'mini',
					delay: 3000,
					onClick: function()
					{
						var str = JSON.stringify(result.data, null, 2);
						Lobibox.alert("info", {msg: str});
					},  
					msg: 'Операция прошла успешно!'
					});
			else
				Lobibox.notify('error', {
					size: 'mini',
					delay: 7000, 
					msg: `ОШИБКА: <br />#${code}: ${text}`
					});
		}
	}
	static showAjaxResObj(result)
	{
		if(result.error == 0)
			Lobibox.notify('success', {
				size: 'mini',
				delay: 3000,
				onClick: function()
				{
					var str = JSON.stringify(result.data, null, 2);
					Lobibox.alert("info", {msg: str});
				}, 
				msg: 'Операция прошла успешно!'
				});
		else if(result.message != undefined)
			Lobibox.notify('error', {
				size: 'mini',
				closeOnClick : false,
				onClick: function()
				{
					Lobibox.alert("error", {msg: 
`Ошибка: #${result.error}<br />
Название: ${result.desc}<br />
Подробнее:<br />
${result.message}`
					});
				},
				delay: 10000, 
				msg: `ОШИБКА: <br />#${result.error}: ${result.desc}`
				});
		else
		{
			var maxLen = 35;
			var shortText = result.desc.length > maxLen ? result.desc.substring(0, maxLen - 3) + "..." : result.desc;
			Lobibox.notify('error', {
				size: 'mini',
				delay: 7000, 
				onClick: function()
				{
					if(result.desc.length > maxLen)
					{
						Lobibox.alert("error", {width: 800,msg: `<pre>${result.desc}</pre>`});
						
					}
				},
				msg: `ОШИБКА: <br />#${result.error}: ${shortText}`
				});
		}
			
	}
	static showToast(text, obj)
	{
		//if(obj.)
	}
	
	static showHTML(html)
	{
		var toast_track = document.getElementById("toast-track");
		toast_track.innerHTML = html;
	}
}

function closeMessage(el) {
	el.addClass('is-hidden');
}

$('.js-messageClose').on('click', function(e) {
	closeMessage($(this).closest('.Message'));
});

$('#js-helpMe').on('click', function(e) {
	alert('Help you we will, young padawan');
	closeMessage($(this).closest('.Message'));
});

$('#js-authMe').on('click', function(e) {
	alert('Okelidokeli, requesting data transfer.');
	closeMessage($(this).closest('.Message'));
});

$('#js-showMe').on('click', function(e) {
	alert("You're off to our help section. See you later!");
	closeMessage($(this).closest('.Message'));
});

$(document).ready(function() {
	setTimeout(function() {
		closeMessage($('#js-timer'));
	}, 5000);
});