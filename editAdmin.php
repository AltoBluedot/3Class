<?php
/*
        authors:
        Piotr Bienkowski
        Bartosz Kostarczyk
        Mateusz Mazurczak
    */
    session_start();
    include "db.php";
    if(!isset($_SESSION['gsidkLOG']))
    { 
        header("Location: login.php");
    }
    if($_SESSION['gsidkLOG'] != 123)
    {
        header("Location: login.php");
    }

    $adminId = $_SESSION['gsidkID'];
    if(isset($_POST['save']))
    {
        $passwordOld = htmlentities($_POST['passwordOld']);
        $password1 = htmlentities($_POST['password1']);
        $password2 = htmlentities($_POST['password2']);

        $sql = sprintf("SELECT _haslo FROM admini WHERE _id = %d", 
        intval($adminId));
        $result = $conn->query($sql);
        if ($result->num_rows > 0) 
        {
            $row = $result->fetch_assoc();
            if(password_verify($passwordOld, $row['_haslo']))
            {
                if($password1 == $password2)
                {
                    $password1 = password_hash($password1, PASSWORD_DEFAULT);
                    $sql = "UPDATE admini SET _haslo = '$password1' WHERE _id = $adminId";
                    if ($conn->query($sql) === TRUE) 
                    {
                        echo "<script>";
                        echo "alert('Hasło zostało zmienione');";
                        echo "</script>";
                    }
                    else 
                    {
                        echo "<script>";
                        echo "alert('Coś poszło nie tak, spróbuj ponownie poźniej…');";
                        echo "</script>";
                    }
                }
                else
                {
                    echo "<script>";
                    echo "alert('Hasła nie są identyczne');";
                    echo "</script>";
                }
            }
            else
            {
                echo "<script>";
                echo "alert('Podane hasło nie jest poprawne');";
                echo "</script>";
            }
        }
        else
        {
            echo "<script>";
            echo "alert('Coś poszło nie tak, spróbuj ponownie później...');";
            echo "</script>";
        }
    }
    

    
?>

<!DOCTYPE HTML>
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
        <div class="appinfo">
			<p class="name">Zmień hasło:</p>
		</div>
		
		<form action="?" method="post">
			<input type="password" class="minput" placeholder="STARE HASŁO" name="passwordOld" autocomplete="off">
			<input type="password" class="minput" placeholder="NOWE HASŁO" name="password1" autocomplete="off">
            <input type="password" class="minput" placeholder="POWTÓRZ HASŁO" name="password2" autocomplete="off">
            <br />
			<input type="submit" name = "save" value="Zmień" class="mainbut">
		</form>
        <br />
		<a href = "admin.php"><button class="mainbut" style = "background-color: silver" >Anuluj</button></a>

        <p class="info" style="color: black;">Made by Piotr Bieńskowski, Bartek Kostarczyk &amp; Mateusz Mazurczak with 💕</p>

		<div class="spacer"></div>
	</div>
	
	<script src="js/general.js"></script>
</BODY>
