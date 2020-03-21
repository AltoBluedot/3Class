<?php 
    session_start();
    include "db.php";
    /*
    if(!isset($_SESSION['gsidkLOG']))
    { 
        header("Location: login.php");
    }
    if($_SESSION['gsidkLOG'] != 123)
    {
        header("Location: login.php");
    }
    */

    if(!isset($_GET['id']))
    {
        header("Location: admin.php");   
    }
    $day = intval($_GET['id']);
    if($day < 0 || $day > 6)
    {
        header("Location: admin.php");  
    }

    $dayName = "_godzPon";

    function makeLine($name, $surname, $email, $tab, $iter)
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
        for($i = 0; $i < 14; $i++)
        {
            echo "<td";
            if($tab[$i] == '1')
            {

            echo " class = 'checked'";
            }
            echo ">";
            if($tab[$i] == '1')
            {
                echo "X";
            }
            echo "</td>";
        }
        echo "</tr>";
    }

    function makeTable($ifPrzedmiot, $dayName)
    {
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

            $sql = "SELECT * FROM wolontariusze";
            $result = $conn->query($sql);
            $i = 0;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc())
                {
                    $temp = $row['_przedmiotyCiag'];
                    echo $temp;
                    if($temp[$ifPrzedmiot] == '1')
                    {
                        makeLine($row['_imie'], $row['_nazwisko'], $row['_email'], $row[$dayName], $i);
                        $i++;
                    }
                }
            }
        echo "</table>";
    }

?>

<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}

.checked{
    background-color: #5bba4e;
}
</style>



</head>
<body>
<a href = "admin.php"><button>Wróć</button></a>
<h2>Poniedziałek</h2>


<p>Matematyka:</p>
<?php
    makeTable(1, $dayName);
?>