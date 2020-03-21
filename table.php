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
    

    

    if(!isset($_GET['id']))
    {
        header("Location: admin.php");   
    }
    $day = intval($_GET['id']);
    if($day < 0 || $day > 6)
    {
        header("Location: admin.php");  
    }


    if($day == 0)
    {
        $dayName = "_godzPon";
        $dayName2 = "Poniedziałek";
    }
    else if($day == 1)
    {
        $dayName = "_godzWt";
        $dayName2 = "Wtorek";
    }
    else if($day == 2)
    {
        $dayName = "_godzSr";
        $dayName2 = "Środa";
    }
    else if($day == 3)
    {
        $dayName = "_godzCzw";
        $dayName2 = "Czwartek";
    }
    else if($day == 4)
    {
        $dayName = "_godzPt";
        $dayName2 = "Piątek";
    }
    else if($day == 5)
    {
        $dayName = "_godzSob";
        $dayName2 = "Sobota";
    }
    else if($day == 6)
    {
        $dayName = "_godzNd";
        $dayName2 = "Niedziela";
    }


    function makeLine($name, $surname, $email, $tab, $iter, $idWol,$day)
    {
        include "db.php";
        echo "<tr";
        if($iter % 2 == 0)
        {   
            echo " class = 'shade'";
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
        for($i = 0; $i < 14; $i++)
        {
            echo "<td";
            if($tab[$i] == '1')
            {

            echo " class = 'checked'";
            }
            if($tab[$i] == '2')
            {
                $temp=$i+7;
                $sql = "SELECT * FROM godziny WHERE _id_wolontariusz='$idWol' AND _dzien_tyg='$day' AND _godzina='$temp'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $idUcz = $row['_id_uczen'];
                    $przedmiot = $row['_przedmiot'];
                    $sql = "SELECT _imie , _nazwisko FROM uczniowie WHERE _id='$idUcz'";
                    $result2 = $conn->query($sql);
                    if ($result2->num_rows > 0) {
                        $row2 = $result2->fetch_assoc();
                        $imieUcz = $row2['_imie'];
                        $nazwiskoUcz = $row2['_nazwisko'];
                        echo " title='$imieUcz $nazwiskoUcz:$przedmiot' ";
                    }
                }
                
                echo " class = 'red'";
            }
            echo ">";
            echo "X";
            echo "</td>";
        }
        echo "</tr>";
    }
    function makeTable($ifPrzedmiot, $dayName, $day)
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
            echo '<th>7</th>';
            echo '<th>8</th>';
            echo '<th>9</th>';
            echo '<th>10</th>';
            echo '<th>11</th>';
            echo '<th>12</th>';
            echo '<th>13</th>';
            echo '<th>14</th>';
            echo '<th>15</th>';
            echo '<th>16</th>';
            echo '<th>17</th>';
            echo '<th>18</th>';
            echo '<th>19</th>';
            echo '<th>20</th>';
        $idszkoly=$_SESSION['gsidkIDSZKOLY'];
        $sql = "SELECT * FROM wolontariusze WHERE _szkola_id=$idszkoly ORDER BY _nazwisko";
        $result = $conn->query($sql);
        $j = 1;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc())
            {
                $temp = $row['_przedmiotyCiag'];
                $tab = $row[$dayName];
                $idWol = $row['_id'];
                for($i = 0; $i < strlen($tab); $i++)
                {
                    if($tab[$i] != '0')
                    {
                        if($temp[$ifPrzedmiot] == '1')
                        {
                            makeLine($row['_imie'], $row['_nazwisko'], $row['_email'], $row[$dayName], $j, $idWol,$day);
                            $j++;
                        }
                    break;
                    }
                }
                
            }
        }
            
        echo "</table>";
    }

?>

<!DOCTYPE html>
<html>
	<head>
		<TITLE>Pulsar</TITLE>
		
		<link href="img/logos/Pulsar.png" rel="icon">
		<link href="css/tables.css" rel="stylesheet">
		
		<link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,600,700&display=swap" rel="stylesheet">
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	</head>
<body>
<a href = "admin.php"><img src="img/icons/undo.png"></a>
<p class="maint"><?php echo $dayName2 ?>:</p>


<p>Matematyka:</p>
<?php
    makeTable(0, $dayName, $day);
?>

<p>Polski:</p>
<?php
    makeTable(1, $dayName, $day);
?>

<p>Biologia:</p>
<?php
    makeTable(2, $dayName, $day);
?>

<p>Fizyka:</p>
<?php
    makeTable(3, $dayName, $day);
?>

<p>Chemia:</p>
<?php
    makeTable(4, $dayName, $day);
?>

<p>Geografia:</p>
<?php
    makeTable(5, $dayName, $day);
?>

<p>Historia:</p>
<?php
    makeTable(6, $dayName, $day);
?>

<p>Informatyka:</p>
<?php
    makeTable(7, $dayName, $day);
?>

<p>Angielski:</p>
<?php
    makeTable(8, $dayName, $day);
?>

<p>Niemiecki:</p>
<?php
    makeTable(9, $dayName, $day);
?>

<p>Francuski:</p>
<?php
    makeTable(10, $dayName, $day);
?>

<p>Hiszpański:</p>
<?php
    makeTable(11, $dayName, $day);
?>

<p>AnalizaDanych:</p>
<?php
    makeTable(12, $dayName, $day);
?>

<p>Architektura:</p>
<?php
    makeTable(13, $dayName, $day);
?>

<p>Druk3D:</p>
<?php
    makeTable(14, $dayName, $day);
?>

<p>Elektronika:</p>
<?php
    makeTable(15, $dayName, $day);
?>

<p>Film:</p>
<?php
    makeTable(16, $dayName, $day);
?>

<p>Fotografia:</p>
<?php
    makeTable(17, $dayName, $day);
?>

<p>HistoriaSztuki:</p>
<?php
    makeTable(18, $dayName, $day);
?>

<p>Astronomia:</p>
<?php
    makeTable(19, $dayName, $day);
?>

<p class="info" style="color: black;">Made by Piotr Bieńskowski, Bartek Kostarczyk &amp; Mateusz Mazurczak with 💕</p>
</body>