<?php
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

    if(!isset($_SESSION['zaladowaniUczniowie']))
    { 
        $sql="SELECT _id FROM uczniowie";
        $result = $conn->query($sql);
        $rows=$result->num_rows;
        $_SESSION['rows']=$rows;
        $acuallyid=-1;
        for($i=0;$i<$rows;$i++)
        {
            if($response2 = @$conn->query("SELECT _id, _imie, _nazwisko, _email FROM uczniowie WHERE _id>$acuallyid LIMIT 1"))
            {
                $data2 = $response2->fetch_assoc();
                $_SESSION['idUGive'][$i]=$data2['_id'];
                $_SESSION['imieGive'][$i]=$data2['_imie'];
                $_SESSION['nazwiskoGive'][$i]=$data2['_nazwisko'];
                $_SESSION['emailGive'][$i]=$data2['_emial'];

                $acuallyid = $data2['_id'];
            }
            else
            {
                header('Location: index.php?info=database_err');
            }$response2->close();
        }
        $_SESSION['zaladowaniUczniowie']=1;
    }


    if(isset($_POST['give']))
    {
        $adate = date('N');
        if($adate==1)
        $adate=6;
        else
        $adate=$adate-2;
        $idwolontariusza=$id;
        $day = htmlentities($_POST['dzien']);
        $dzien = $day;
        $godzina = htmlentities($_POST['godzina']);
        $idUczen = htmlentities($_POST['uczen']);
        $przedmiot = htmlentities($_POST['przedmiot']);
        if($godzina<7||$godzina>20){
            unset($_POST['give']);
            echo "<script>";
            echo "alert('Błędna godzina');";
            echo "location.replace('giveLesson.php?id=$id');";
            echo "</script>";
        }
        $godzina=$godzina-7;
        if($adate==$dzien){
            unset($_POST['give']);
            echo "<script>";
            echo "alert('Rejestracje można prowadzić na maksymalnie 5 dni do przodu');";
            echo "location.replace('giveLesson.php?id=$id');";
            echo "</script>";
        }
        else{

            if($day == 0)
                $day = "_godzPon";
        
            else if($day == 1)
                $day = "_godzWt";

            else if($day == 2)
                $day = "_godzSr";

            else if($day == 3)
                $day = "_godzCzw";

            else if($day == 4)
                $day = "_godzPt";

            else if($day == 5)
                $day = "_godzSob";

            else if($day == 6)
                $day = "_godzNd";

            else{
                unset($_POST['give']);
                echo "<script>";
                echo "alert('Błędny format dnia tygodnia');";
                echo "</script>";
                header("Location: giveLesson.php?id=$id");
            }
        

            $sql = "SELECT * FROM wolontariusze WHERE _id=$idwolontariusza";
            $result0 = $conn->query($sql);
            $rows=$result0->num_rows; 
            if($rows>0){
                $data2 = $result0->fetch_assoc(); 
                $ileGodzin = $data2['_liczba_godzin'];
                $ciag = $data2[$day]; 

                if($ileGodzin>0)
                {
                    if($ciag[$godzina]=='1'){
                        $ciag[$godzina]='2';
                        $ileGodzin--;
                        $sql = "UPDATE wolontariusze SET _liczba_godzin=$ileGodzin, $day='$ciag' WHERE _id=$idwolontariusza";
                        if ($conn->query($sql) === TRUE) 
                        {
                            $godzina=$godzina+7;
                            $sql = "INSERT INTO godziny (_dzien_tyg, _godzina, _id_wolontariusz, _id_uczen, _przedmiot) VALUES ('$dzien','$godzina','$idwolontariusza','$idUczen','$przedmiot')";

                            if ($conn->query($sql) === TRUE) 
                            {
                                echo "<script>";
                                echo "alert('Przydzieliłeś korepetycje wolontariuszowi');";
                                echo "location.replace('table.php');";
                                echo "</script>";
                            } 
                            else 
                            {
                                echo "<script>";
                                echo "alert('problem z bazą napisz do nasz na mail: 3class.management@gmail.com');";
                                echo "location.replace('odswierz3.php');";
                                echo "</script>";
                            }
                        } 
                        else 
                        {
                            echo "<script>";
                            echo "alert('problem z bazą napisz do nasz na mail: 3class.management@gmail.com');";
                            echo "location.replace('odswierz3.php');";
                            echo "</script>";
                        }
                    }
                    else if($ciag[$godzina]==2){
                        unset($_POST['give']);
                        echo "<script>";
                        echo "alert('Wolontariusz już jest zajęty o tej godzinie');";
                        echo "location.replace('giveLesson.php?id=$id');";
                        echo "</script>";
                    }
                    else{
                        unset($_POST['give']);
                        echo "<script>";
                        echo "alert('Wolontariusz nie jest dostępny o tej godzinie');";
                        echo "location.replace('giveLesson.php?id=$id');";
                        echo "</script>";
                    }
                }
                else{
                    unset($_POST['give']);
                    echo "<script>";
                    echo "alert('Wolontariusz nie ma już wolnych godzin w tym tygodniu');";
                    echo "location.replace('giveLesson.php?id=$id');";
                    echo "</script>";
                }
            
            }
            else{
                echo "<script>";
                echo "alert('problem z bazą napisz do nasz na mail: 3class.management@gmail.com');";
                echo "location.replace('odswierz3.php');";
                echo "</script>";
            }
        }

    }

?>

<!DOCTYPE HTML>
<HEAD>
	<TITLE>Goost Forms</TITLE>
	
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
			<p class="name">Wybierz kiedy chcesz przydzielić korepetycje dla ucznia:</p>
            Imie: <?php echo $name; ?><br />
            Nazwisko: <?php echo $surname; ?><br />
		</div>
        <form action="?id=<?php echo $id; ?>" method="post">
            <div class="appinfo">
			    <p class="infosx">Podaj dzień tygodnia(0-6)</p>
                <input type="text" class="minput" placeholder="Dzień tygodnia" name="dzien" autocomplete="off">
                <p class="infosx">Podaj godzinę rozpoczęcia korepetycji(7-20)</p>
                <input type="text" class="minput" placeholder="Godzina" name="godzina" autocomplete="off">
                <div class="custom-select">
                    <select name="uczen">
                        <option value="0" name="uczen">Wybierz ucznia:</option>
                        <?php
                        $rows=$_SESSION['rows'];
                        for($i=0;$i<$rows;$i++)
                        {
                            $id=$_SESSION['idUGive'][$i];
                            $imie=$_SESSION['imieGive'][$i];
                            $nazwiskoGive=$_SESSION['nazwiskoGive'][$i];
                            $email=$_SESSION['emailGive'][$i];
                            $calosc=$imie." ".$nazwisko." ".$email;
                            echo<<<end
                            <option value="$id" name="szkola">$calosc</option>
end;
                        }
                        ?>
                    </select>
                </div> 
                <div class="custom-select">
                    <select name="przedmiot">
                        <option value="0" name="przedmiot">Lista Szkół:</option>
                        <option value="Matematyka" name="przedmiot">Matematyka</option>
                        <option value="Polski" name="przedmiot">Polski</option>
                        <option value="Biologia" name="przedmiot">Biologia</option>
                        <option value="Fizyka" name="przedmiot">Fizyka</option>
                        <option value="Chemia" name="przedmiot">Chemia</option>
                        <option value="Geografia" name="przedmiot">Geografia</option>
                        <option value="Historia" name="przedmiot">Historia</option>
                        <option value="Informatyka" name="przedmiot">Informatyka</option>
                        <option value="Angielski" name="przedmiot">Angielski</option>
                        <option value="Niemiecki" name="przedmiot">Niemiecki</option>
                        <option value="Francuski" name="przedmiot">Francuski</option>
                        <option value="Hiszpanski" name="przedmiot">Hiszpanski</option>
                        <option value="AnalizaDanych" name="przedmiot">AnalizaDanych</option>
                        <option value="Architektura" name="przedmiot">Architektura</option>
                        <option value="Druk3D" name="przedmiot">Druk3D</option>
                        <option value="Elektronika" name="przedmiot">Elektronika</option>
                        <option value="Film" name="przedmiot">Film</option>
                        <option value="Fotografia" name="przedmiot">Fotografia</option>
                        <option value="HistoriaSztuki" name="przedmiot">HistoriaSztuki</option>
                        <option value="Astronomia" name="przedmiot">Astronomia</option>
                    </select>
                </div>
		    </div>
        <br />
        <br />
			<input type="submit" name = "give" value="Przydziel" class="mainbut">
		</form>
        <br />
		<a href = "volunteers.php"><button class="mainbut" style = "background-color: silver" >Anuluj</button></a>

        <p class="info" style="color: black;">Made by Piotr Bieńskowski, Bartek Kostarczyk &amp; Mateusz Mazurczak with 💕</p>

		<div class="spacer"></div>
	</div>
	
	<script src="js/general.js"></script>
</BODY>