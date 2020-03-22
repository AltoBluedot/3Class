<!DOCTYPE HTML>
<HEAD>
 
 <?php
/*
        authors:
        Piotr Bienkowski
        Bartosz Kostarczyk
        Mateusz Mazurczak
    */
    session_start();
    session_regenerate_id();
    session_save_path();
    include "db.php";
    if(isset($_SESSION['gsidkLOG']))
    { 
        header("Location: admin.php");
    }

    if(isset($_GET['n']))
    {
        if($_GET['n'] == 1)
        {
            echo "<script>";
            echo "alert('Wylogowano');";
            echo "location.replace('login.php');";
            echo "</script>";
        }
    }
    if(isset($_POST['log']))
    {
        $login = htmlentities($_POST['login']);
        $password = htmlentities($_POST['password']);
       
        $sql = sprintf("SELECT admini._id, admini._imie, admini._nazwisko, admini._mail, admini._haslo FROM admini WHERE _mail = '%s'", 
        mysqli_real_escape_string($conn, $login));
        $result = $conn->query($sql);
        if ($result->num_rows > 0) 
        {
            $row = $result->fetch_assoc();
            $id = $row['_id'];
            
            if(password_verify($password, $row['_haslo']))
            {
                $_SESSION['gsidkID'] = $id;
                $_SESSION['gsidkLOG'] = 123;
                $_SESSION['gsidkIMIE'] = $row['_imie'];
                $_SESSION['gsidkNAZWISKO'] = $row['_nazwisko'];
                $_SESSION['gsidkMAIL'] = $row['_mail'];
                $sql = "SELECT szkoly._id, szkoly._nazwa, szkoly._key FROM szkoly WHERE _admin_id = $id";
                $result2 = $conn->query($sql);
                if ($result2->num_rows > 0) 
                {
                    $row2 = $result2->fetch_assoc();
                    $_SESSION['gsidkNAZWASZKOLY'] = $row2['_nazwa'];
                    $_SESSION['gsidkIDSZKOLY'] = $row2['_id'];
                    $_SESSION['gsidkKEY'] = $row2['_key'];
                    header("Location: odswierz1.php");
                }
                else{
                echo "<script>";
                echo "alert('Nie odnaleziono szkoly dla tego opiekuna');";
                echo "</script>";
                }
            }
            else
            {
                echo "<script>";
                echo "alert('Podane dane nie sa prawidlowe1');";
                echo "</script>";
            }
        } 
        else 
        {
            echo "<script>";
            echo "alert('Podane dane nie sa prawidlowe2');";
            echo "</script>";
        }
        $result->close();
    }

?>

	<TITLE>3Class</TITLE>
	
	<link href="img/logos/Pulsar.png" rel="icon">
	<link href="css/login.css" rel="stylesheet">
	
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
	
	<div id="midbox">
		<img src="img/logos/3Goost.png">
		<form action="?" method="post">
			<input class="txtin" name="login"    type="text"     placeholder="Login" autocomplete="off">
			<input class="txtin" name="password" type="password" placeholder="Hasło" autocomplete="off">
			
			<input class="okform" type="submit" name="log" value="Zaloguj">
		</form>
	</div>
	
	<script src="js/general.js"></script>
</BODY>
