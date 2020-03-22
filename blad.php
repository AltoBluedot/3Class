<?php
/*
        authors:
        Piotr Bienkowski
        Bartosz Kostarczyk
        Mateusz Mazurczak
    */
?><!DOCTYPE HTML>
<HEAD>
	<TITLE>3CLASS</TITLE>
	
	<link href="img/logos/3class-logo.jpg" rel="icon">
	<link href="css/style.css" rel="stylesheet">
	<script src="js/general.js"></script>
	
	<link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,600,700&display=swap" rel="stylesheet">
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
</HEAD>
<BODY id="main" style="border-radius: 10px;">
	<div id="oldbrowser" style="display: none;"></div>
	
	<script>
		//GimmeNiceIntro
		body = document.getElementById("main");
		body.style.opacity = 0;
		
		setTimeout(function() {
			body.style.opacity = 1;
		}, 0);
	</script>
	
	<div class="weatherinfo" id="sli">
		<div class="appinfo">
			<img src="img/logos/3class-logo.jpg" draggable="false" class="appico"><p class="name"><span style="color: #5bba4e">Goost</span> Forms</p>
		</div>
		<p class="name">
            Błąd:
        </p>
        Aby uzupełnić formularz wejdź przez link od Nauczyciela<br/>
        Skontaktuj się z Nauczycielem
		
		<p class="info" style="color: black;">Made by Piotr Bieńskowski, Bartek Kostarczyk &amp; Mateusz Mazurczak with 💕</p>

		<div class="spacer"></div>
	</div>
	
	<script src="js/general.js"></script>
</BODY>
