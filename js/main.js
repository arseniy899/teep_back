	var loadingSpinner = null;
	$(".keep").hide();
	$('[item]').click(function() 
	{
	  var item = $(this).attr('item');
	  sessionStorage.setItem('item', item);
	  $(".keep").hide();
	  $("#" + item).show();
	  return false;
	});
	function executeAsync(func) 
	{
		setTimeout(func, 0);
	}
	var item = sessionStorage.getItem('item');
	if (item) {
	  $("#" + item).show();
	}
	function sleep(milliseconds)
	{
		var start = new Date().getTime();
		for (var i = 0; i < 1e7; i++)
		{
			if ((new Date().getTime() - start) > milliseconds)
			{
				break;
			}
		}
	}
	function log_i(tag, value)
	{
		if(value instanceof Array || value instanceof Object)
			value = JSON.stringify(value);
		console.log("I/"+tag+": "+value);
	}
	function log_obj(tag, value)
	{
		if(value instanceof Array || value instanceof Object)
		{
			console.log("I/"+tag+": ");
			console.log(value);
		}
		else
			console.log("I/"+tag+": "+value);
	}
	
	function proceedLinkBg(url, params)
	{
		console.log("proceedLinkBg/params",params);
		$.ajax({
			type: "POST",
			url: url,
			success: function success(data)
			{
				var obj = jQuery.parseJSON(data).responce;
				Toast.showAjaxRes(obj);
			},
			//ContentType : "application/text; charset=utf-8",
			//dataType: "json",
			async: false,
			cache : false,
			data: params
			//data: {'data':JSON.stringify(values)},
		});
	}

	function ShowLoading()
	{
		if(loadingSpinner != null)
			return;
		loadingSpinner = document.createElement("div");
		loadingSpinner.innerHTML = `
			<div class="sk-fading-circle">
			  <div class="sk-circle1 sk-circle"></div>
			  <div class="sk-circle2 sk-circle"></div>
			  <div class="sk-circle3 sk-circle"></div>
			  <div class="sk-circle4 sk-circle"></div>
			  <div class="sk-circle5 sk-circle"></div>
			  <div class="sk-circle6 sk-circle"></div>
			  <div class="sk-circle7 sk-circle"></div>
			  <div class="sk-circle8 sk-circle"></div>
			  <div class="sk-circle9 sk-circle"></div>
			  <div class="sk-circle10 sk-circle"></div>
			  <div class="sk-circle11 sk-circle"></div>
			  <div class="sk-circle12 sk-circle"></div>
			</div>
		`;
		loadingSpinner.style = "width: 100vw; height: 100vh;position:fixed;left:0px;top: 0px;z-index:10000000;background-color:#000C;display: flex;align-items: center;";
		document.body.appendChild(loadingSpinner);
	}
	function DismissLoading()
	{
		if(loadingSpinner != null)
			loadingSpinner.remove();
		loadingSpinner = null;
	}
	function hide(d)
	{
		HideContent(d);
	}
	
	function show(d)
	{
		ShowContent(d);
	}
	function HideContent(d)
	{
		if(isElementDOM(d))
			var div = d;
		else
			var div = document.getElementById(d);
		div.style.display = "none";
	}
	function ShowContent(d)
	{
		if(isElementDOM(d))
			var div = d;
		else
			var div = document.getElementById(d);
		div.style.display = "block";
	}
	function isElementDOM(element) {
		return element instanceof Element || element instanceof HTMLDocument;  
	}
	function isShown( elem ) {
		//return  window.getComputedStyle(elem).display !== "none";
		return !!( elem.offsetWidth || elem.offsetHeight || elem.getClientRects().length );
	};
	function hexToRgb(hex) {
		if(hex.length == 4 && hex.startsWith('#'))
			hex = hex[1]+hex[1]+hex[2]+hex[2]+hex[3]+hex[3];
		else if(hex.length == 3 && !hex.startsWith('#'))
			hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
		
		log_i("HEXtoRGB/","INP:"+hex);
		var result = /^#?([A-Fa-f\d]{2})([A-Fa-f\d]{2})([A-Fa-f\d]{2})$/i.exec(hex);
		return result ? {
			r: parseInt(result[1], 16),
			g: parseInt(result[2], 16),
			b: parseInt(result[3], 16)
		} : {r: 0, g: 0, b: 0};
	}
	function rgbToHex(r, g, b) {
	  return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
	}
	function isWhiteContrastColorText(hex) {
		// randomly update
		var color = hexToRgb(hex)
		
		// http://www.w3.org/TR/AERT#color-contrast
		var o = Math.round(((parseInt(color.r) * 299) +
						  (parseInt(color.g) * 587) +
						  (parseInt(color.b) * 114)) / 1000);
		return (o < 180);
	}
	function ReverseDisplay(d)
	{
		if(isElementDOM(d))
			var div = d;
		else
			var div = document.getElementById(d);
		
		if (!isShown(div))
			div.style.display = "block";
		else
			div.style.display = "none";
		
	}
	var $link;
	Number.prototype.pad = function(size) {
		var s = String(this);
		while (s.length < (size || 2)) {s = "0" + s;}
		return s;
	}
	function formatDate(date)
	{
		var dd = date.getDate().pad(2);
		var mm = (date.getMonth() + 1).pad(2); // 0 is January, so we must add 1
		var yyyy = date.getFullYear();

		return dd + "." + mm + "." + yyyy;
	}
	function formatDateServ(date)
	{
		var dd = date.getDate().pad(2);
		var mm = (date.getMonth() + 1).pad(2); // 0 is January, so we must add 1
		var yyyy = date.getFullYear();

		return  yyyy+ "." + mm + "." + dd;
	}
	/*$(document).click(function(event) {
	   $link = $(this);
	});*/
	$(document).ready(function() {
		$("div#loadingAlert").css('visibility', 'hidden');
		
		/*$('[onclick]').each(function() {
			$link = $(this);
			var handler = $(this).prop('onclick');
			$(this).removeProp('onclick');
			$(this).click(handler);
		});*/
		
		var elements = document.getElementsByClassName('api-link');
		for(var i = 0, len = elements.length; i < len; i++) {
			elements[i].onclick = function () 
			{
				var xhttp;
				xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					
				if (this.readyState == 4 && this.status == 200) {
					var ajaxRes = JSON.parse(this.responseText).responce;
					Toast.showAjaxRes(ajaxRes);
				}
				};
				xhttp.open("POST", this.href, true);
				//xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				trackOutboundLink(this.href); return false;
			}
		}
		$(document)
			.ajaxStart(function () 
			{
				ShowLoading();
			})
			.ajaxStop(function () {
				DismissLoading();
			});
		//$('#cart-head').addClass("table");
	} );
	function logout()
	{
		var xhttp;
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			
		if (this.readyState == 4 && this.status == 200) {
			var ajaxRes = JSON.parse(this.responseText).responce;
			Toast.showAjaxRes(ajaxRes);
			if(ajaxRes.error == 0)
				window.location.href = "";
		}
		};
		xhttp.open("POST", "api/user.auth.exit.php", true);
		xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xhttp.send();
	}
	function round(number, increment, offset) {
		return Math.round((number - offset) / increment ) * increment + offset;
	}
	