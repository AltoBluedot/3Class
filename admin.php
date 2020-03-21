<?php
/*
        authors:
        Piotr Bienkowski
        Bartosz Kostarczyk
        Mateusz Mazurczak
    */
    session_start();
    
    if(!isset($_SESSION['gsidkLOG']))
    { 
        header("Location: login.php");
    }
    if($_SESSION['gsidkLOG'] != 123)
    {
        header("Location: login.php");
    }

    $idSzkoly = $_SESSION['gsidkIDSZKOLY'];
    $key = $_SESSION['gsidkKEY'];
?>


<!DOCTYPE HTML>
<HEAD>
	<TITLE>3Class</TITLE>
	
	<link href="img/logos/Pulsar.png" rel="icon">
	<link href="css/admin.css" rel="stylesheet">
	
	<link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,600,700&display=swap" rel="stylesheet">
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	
</HEAD>
<BODY id="main" style="border-radius: 10px;" class="no-scroll">
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
			<img src="img/logos/3Goost.png" draggable="false" class="appico">
		</div>
		
		<p class="info">Administracja Formularzami</p>
		
		<a href="https://3class.new-cyb.org/wolontariusze.php?key=<?php echo $key; ?>" class="nostyle">
			<div class="param">
				<img src="img/icons/form.png" class="wicon">
				<div class="sdat">
					<p class="stitle" id="1m">Link dla wolontariuszy</p>
					<p class="sdetail">Link do rejestracji dla Wolontariuszy.</p>
				</div>
			</div>
		</a>
		
		<a href="https://3class.new-cyb.org/uczniowie.php?key=<?php echo $key; ?>" class="nostyle">
			<div class="param">
				<img src="img/icons/form.png" class="wicon">
				<div class="sdat">
					<p class="stitle" id="2m">Link dla uczniów</p>
					<p class="sdetail">Link do rejestracji dla uczniów</p>
				</div>
			</div>
		</a>
		
		<p class="info">Widok Uczniów</p>
		
		<a href="/students.php" class="nostyle">
			<div class="param">
				<img src="img/icons/student.png" class="wicon">
				<div class="sdat">
					<p class="stitle" id="1m">Uczniowie</p>
					<p class="sdetail">Zarządzaj uczniami otrzymującymi korepetycje.</p>
				</div>
			</div>
		</a>
		
		<a href="/odswierz4.php" class="nostyle">
			<div class="param">
				<img src="img/icons/student.png" class="wicon">
				<div class="sdat">
					<p class="stitle" id="2m">Wolontariusze</p>
					<p class="sdetail">Zarządzaj uczniami dającymi korepetycje.</p>
				</div>
			</div>
		</a>
		
		
		<p class="info">Widok Dni</p>
		
		<a href="/table.php?id=0" class="nostyle">
		<div class="param">
			<img src="img/icons/cal.png" class="wicon" id="0i">
			<div class="sdat">
				<p class="stitle" id="0h">Poniedziałek</p>
				<p class="sdetail" id="0c">Przeglądaj informacje z tego dnia</p>
			</div>
		</div>
		</a>
		
		<a href="/table.php?id=1" class="nostyle">
		<div class="param">
			<img src="img/icons/cal.png" class="wicon" id="0i">
			<div class="sdat">
				<p class="stitle" id="0h">Wtorek</p>
				<p class="sdetail" id="0c">Przeglądaj informacje z tego dnia</p>
			</div>
		</div>
		</a>
		
		<a href="/table.php?id=2" class="nostyle">
		<div class="param">
			<img src="img/icons/cal.png" class="wicon" id="0i">
			<div class="sdat">
				<p class="stitle" id="0h">Środa</p>
				<p class="sdetail" id="0c">Przeglądaj informacje z tego dnia</p>
			</div>
		</div>
		</a>
		
		<a href="/table.php?id=3" class="nostyle">
		<div class="param">
			<img src="img/icons/cal.png" class="wicon" id="0i">
			<div class="sdat">
				<p class="stitle" id="0h">Czwartek</p>
				<p class="sdetail" id="0c">Przeglądaj informacje z tego dnia</p>
			</div>
		</div>
		</a>
		
		<a href="/table.php?id=4" class="nostyle">
		<div class="param">
			<img src="img/icons/cal.png" class="wicon" id="0i">
			<div class="sdat">
				<p class="stitle" id="0h">Piątek</p>
				<p class="sdetail" id="0c">Przeglądaj informacje z tego dnia</p>
			</div>
		</div>
		</a>
		
		<a href="/table.php?id=5" class="nostyle">
		<div class="param">
			<img src="img/icons/cal.png" class="wicon" id="0i">
			<div class="sdat">
				<p class="stitle" id="0h">Sobota</p>
				<p class="sdetail" id="0c">Przeglądaj informacje z tego dnia</p>
			</div>
		</div>
		</a>
		
		<a href="/table.php?id=6" class="nostyle">
		<div class="param">
			<img src="img/icons/cal.png" class="wicon" id="0i">
			<div class="sdat">
				<p class="stitle" id="0h">Niedziela</p>
				<p class="sdetail" id="0c">Przeglądaj informacje z tego dnia</p>
			</div>
		</div>
		</a>
		
		<p class="info">Opcje Konta</p>
		
		<a href="/editAdmin.php" class="nostyle">
		<div class="param">
			<img src="img/icons/lock.png" class="wicon" id="0i">
			<div class="sdat">
				<p class="stitle" id="0h">Zmiana Hasła</p>
				<p class="sdetail" id="0c">Zmień hasło na inne</p>
			</div>
		</div>
		</a>
		<a href="/odswierz2.php" class="nostyle">
		<div class="param">
			<img src="img/icons/house.png" class="wicon" id="0i">
			<div class="sdat">
				<p class="stitle" id="0h">Wyloguj się</p>
				<p class="sdetail" id="0c">Bezpiecznie zamyka sesje</p>
			</div>
		</div>
		</a>
		
		<p class="info" style="color: black;">Made by Piotr Bieńskowski, Bartek Kostarczyk &amp; Mateusz Mazurczak with 💕</p>
		
		<div class="spacer"></div>
	</div>
	
	<script src="js/general.js"></script>
</BODY>
