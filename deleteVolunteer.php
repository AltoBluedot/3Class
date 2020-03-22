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

    if(!isset($_GET['id']))
    {
        header("Location: admin.php");
    }
    $id = (int)($_GET['id']);
    $sId = $_SESSION['gsidkIDSZKOLY'];

    $sql = "SELECT _imie, _nazwisko FROM wolontariusze WHERE _id = $id AND _szkola_id = $sId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) 
    {
        $row = $result->fetch_assoc();
        $name = $row['_imie'];
        $surname = $row['_nazwisko'];
    } 
    else 
    {
        header("Location: volunteers.php?n=0");
    }


    if(isset($_POST['delete']))
    {
        $sql = "DELETE FROM godziny WHERE _id_wolontariusz = $id";

        if ($conn->query($sql) === TRUE) 
        {
            $sql = "DELETE FROM wolontariusze WHERE _id = $id AND _szkola_id = $sId";
            if ($conn->query($sql) === TRUE) 
            {
                header("Location: volunteers.php?n=1");
            } 
            else 
            {

                header("Location: volunteers.php?n=0");
            }
        } 
        else 
        {

            header("Location: volunteers.php?n=0");
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
			<p class="name">Czy napewno chcesz usunąć Wolontariusza:</p>
            Imie: <?php echo $name; ?><br />
            Nazwisko: <?php echo $surname; ?><br />

		</div>
        <br />
        <br />
        <br />
		
		<form action="?id=<?php echo $id; ?>" method="post">
			<input type="submit" name = "delete" value="Usuń" class="mainbut">
		</form>
        <br />
		<a href = "volunteers.php"><button class="mainbut" style = "background-color: silver" >Anuluj</button></a>

        <p class="info" style="color: black;">Made by Piotr Bieńskowski, Bartek Kostarczyk &amp; Mateusz Mazurczak with 💕</p>

		<div class="spacer"></div>
	</div>
	
	<script src="js/general.js"></script>
</BODY>
