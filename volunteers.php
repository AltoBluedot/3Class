<?php
    session_start();
    
    if(!isset($_SESSION['gsidkLOG']))
    { 
        header("Location: login.php");
    }
    if($_SESSION['gsidkLOG'] != 123)
    {
        header("Location: login.php");
    }

    if(isset($_GET['n']))
    {
        if($_GET['n'] == 1)
        {
            echo "<script>";
            echo "alert('Wolontariusz został usunięty');";
            echo "location.replace('volunteers.php');";
            echo "</script>";
        }
        if($_GET['n'] == 0)
        {
            echo "<script>";
            echo "alert('Coś poszło nie tak, spróbuj ponownie później...');";
            echo "location.replace('volunteers.php');";
            echo "</script>";
        }
    }


    function makeLine($id ,$name, $surname, $email, $iter, $kom, $przedmioty, $godziny)
    {
        echo "<tr";
        if($iter % 2 == 0)
        {   
            echo " style = 'background-color: lightgrey;'";
        }
        echo ">";
        echo "<td>";
        echo $name;
        echo "</td>";
        echo "<td>";
        echo $surname;
        echo "</td>";
        echo "<td>";
        echo $email;
        echo "</td>";
        echo "<td>";
        echo $kom;
        echo "</td>";
        echo "<td>";
        echo $godziny;
        echo "</td>";
        echo "<td>";
        $przed=explode(";", $przedmioty);
        $i=0;
        while($przed[$i]){
            echo $przed[$i];
            echo " ";
            $i++;
        }
        echo "</td>";
        echo "<td>";
        echo "<a href = 'giveLesson.php?id=".$id."'><img src='img/icons/plus.png'></a>";
        echo "</td>";
        echo "<td>";
        echo "<a href = 'deleteVolunteer.php?id=".$id."'><img src='img/icons/x.png'></a>";
        echo "</td>";
        

        echo "</tr>";
    }
    function makeTable()
    {
        include "db.php";
        echo "<table  style='width:100%'>";
            echo "<th>";
            echo "Imie";
            echo "</th>";
            echo "<th>";
            echo "Nazwisko";
            echo "</th>";
            echo "<th>";
            echo "email";
            echo "</th>";
            echo "<th>";
            echo "Komunikatory";
            echo "</th>";
            echo "<th>";
            echo "Liczba dostępnych godzin";
            echo "</th>";
            echo "<th>";
            echo "Przedmioty";
            echo "</th>";
            echo "<th>";
            echo "Przydziel korepetycje";
            echo "</th>";
            echo "<th>";
            echo "Usuń";
            echo "</th>";

        $idSzkoly = $_SESSION['gsidkIDSZKOLY'];
        $sql = "SELECT * FROM wolontariusze WHERE _szkola_id = $idSzkoly ORDER BY _nazwisko";
        $result = $conn->query($sql);
        $j = 1;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc())
            {
                makeLine($row['_id'],$row['_imie'], $row['_nazwisko'], $row['_email'], $j, $row['_komunikatory'], $row['_przedmioty'], $row['_liczba_godzin']);
                $j++;
            }
        }
        echo "</table>";
    }

?>

<!DOCTYPE html>
<html>
	<head>
		<TITLE>3Class</TITLE>
		
		<link href="img/logos/Pulsar.png" rel="icon">
		<link href="css/tables.css" rel="stylesheet">
		
		<link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,600,700&display=swap" rel="stylesheet">
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	</head>
<body>
<a href = "admin.php"><img src="img/icons/undo.png"></a>


<p class="maint">Wolontariusze:</p>
<?php
    makeTable();
?>

<p class="info" style="color: black;">Made by Piotr Bieńskowski, Bartek Kostarczyk &amp; Mateusz Mazurczak with 💕</p>

<div class="spacer"></div>

</body>
</html>
