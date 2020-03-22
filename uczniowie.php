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
require "db.php";
$key=htmlentities($_GET['key']);
$query = sprintf("SELECT _id FROM szkoly WHERE _key='%s'",
$conn->real_escape_string($key));
$result0=$conn->query($query);
$rows=$result0->num_rows; 
if($rows>0){
    $data2 = $result0->fetch_assoc(); 
    $_SESSION['idszkoly']=$data2['_id']; 
}
else{
    echo "<script>";
    echo "alert('Zły link');";
    echo "location.replace('blad.php');";
    echo "</script>";
}

if(isset($_POST['action']))
{
    $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=<SECRET_KEY>&response='.$_POST['g-recaptcha-response']);
        
    $odpowiedz = json_decode($sprawdz);
        
    if ($odpowiedz->success==false)
    {
        unset($_POST['action']);
        echo "<script>";
        echo "alert('Jestes robotem');";
        echo "</script>";
        header('Location: index.php');
    }    
    //$response3=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Lcl_OIUAAAAAM-dDD6TVuhCtrlginws5Wn6-R8L&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
    /*if($response3['success'] == false){
      echo "<script>";
      echo "alert('Jestes robotem');";
      echo "</script>";
      header('Location: index.php');
      unset($_POST['action']);
    }*/
    else{
        $name = htmlentities($_POST['name']);
        $surname = htmlentities($_POST['surname']);
        $email = htmlentities($_POST['email']);
        $klasa = htmlentities($_POST['klasa']);
        $komunikatory = htmlentities($_POST['komunikatory']);
        $notatka = htmlentities($_POST['notatka']);
        $przedmioty = htmlentities($_POST['przedmioty']);
        $szkola_id = $_SESSION['idszkoly'];

        $ciagPrzed="";
        $ciagPrzedC="";
        for($i=1;$i<21;++$i){
            if(isset($_POST['przed'.strval($i)])){
            $temp=$_POST['przed'.strval($i)];
            $ciagPrzed=$ciagPrzed.$temp.';';
            $ciagPrzedC=$ciagPrzedC.'1';
        }
        else{
        $ciagPrzedC=$ciagPrzedC.'0';
        }
        }

        $sql = sprintf("INSERT INTO uczniowie (_imie, _nazwisko, _email, _szkola_id, _klasa, _komunikatory, _notatka, _przedmioty, _przedmiotyCiag)
        VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                  $conn->real_escape_string($name),
                  $conn->real_escape_string($surname),
                  $conn->real_escape_string($email),
                  $conn->real_escape_string($szkola_id),
                  $conn->real_escape_string($klasa),
                  $conn->real_escape_string($komunikatory),
                  $conn->real_escape_string($notatka),
                  $conn->real_escape_string($ciagPrzed),
                  $conn->real_escape_string($ciagPrzedC));
        if ($conn->query($sql) === TRUE)
        {
        echo "<script>";
        echo "alert('Konto zostało dodane, opiekun szkoły do której się zgłosiłeś dostał informacje o twoim zgłoszeniu i będzie cię informował na bierząco');";
        echo "location.replace('odswierz3.php');";
        echo "</script>";
        }
        else
        {
        echo "<script>";
        echo "alert('Coś poszło nie tak, spróbuj ponownie później...');";
        echo "location.replace('odswierz3.php');";
        echo "</script>";
        }
    }
}
?>
<!DOCTYPE HTML>
<HEAD>
    <TITLE>3CLASS</TITLE>

    <link href="img/logos/3class-logo.jpg" rel="icon">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/jquery.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,600,700&display=swap" rel="stylesheet">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</HEAD>
<BODY id="main" style="border-radius: 10px;">
    <div id="oldbrowser" style="display: none;"></div>

    <script>
        //GimmeNiceIntro
        body = document.getElementById("main");
        body.style.opacity = 0;

        setTimeout(function () {
            body.style.opacity = 1;
        }, 0);
    </script>

    <div class="weatherinfo" id="sli">
        <div class="appinfo">
            <img src="img/logos/3class-logo.jpg" draggable="false" class="appico"><p class="name"><span style="color: #5bba4e">Goost</span> Forms</p>
        </div>

        <form action="?key=<?php echo $key; ?>" method="post">
            <p class="infosx">Witaj uczniu podstawówki, potrzebujesz bezpłatnych korepetycji? Tutaj znajdziesz pomoc :)</p>
            <input type="text" class="minput" placeholder="Imię" name="name" autocomplete="off" required>
            <input type="text" class="minput" placeholder="Nazwisko" name="surname" autocomplete="off" required>
            <input type="text" class="minput" placeholder="E-mail" name="email" autocomplete="off" required>

            <p class="infos">Z której jesteś klasy?</p>
            <div class="gridmaker">
                <label class="container">
                    4
                    <input type="radio" name="klasa" value="4">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    5
                    <input type="radio" name="klasa" value="5">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    6
                    <input type="radio" name="klasa" value="6">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    7
                    <input type="radio" name="klasa" value="7">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    8
                    <input type="radio" name="klasa" value="8">
                    <span class="checkmark"></span>
                </label>
            </div>

            <p class="infos">Poprzez jakie komunikatory (np. Discord, Skype, Messenger) możesz się komunikować?</p>
            <input type="text" class="minput" placeholder="Komunikatory" name="komunikatory" autocomplete="off">

            <p class="infos">Powiedz nam, z jakich przedmiotów potrzebujesz korepetycji.</p>
            <div class="gridmaker">
                <label class="container">
                    Matematyka
                    <input type="checkbox" name="przed1" value="Matematyka">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    Polski
                    <input type="checkbox" name="przed2" value="Polski">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    Biologia
                    <input type="checkbox" name="przed3" value="Biologia">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    Fizyka
                    <input type="checkbox" name="przed4" value="Fizyka">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    Chemia
                    <input type="checkbox" name="przed5" value="Chemia">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    Geografia
                    <input type="checkbox" name="przed6" value="Geografia">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    Historia
                    <input type="checkbox" name="przed7" value="Historia">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    Informatyka
                    <input type="checkbox" name="przed8" value="Informatyka">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    Angielski
                    <input type="checkbox" name="przed9" value="Angielski">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    Niemiecki
                    <input type="checkbox" name="przed10" value="Niemiecki">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    Francuski
                    <input type="checkbox" name="przed11" value="Francuski">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    Hiszpanski
                    <input type="checkbox" name="przed12" value="Hiszpanski">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    AnalizaDanych
                    <input type="checkbox" name="przed13" value="AnalizaDanych">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    Architektura
                    <input type="checkbox" name="przed14" value="Architektura">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    Druk3D
                    <input type="checkbox" name="przed15" value="Druk3D">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    Elektronika
                    <input type="checkbox" name="przed16" value="Elektronika">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    Film
                    <input type="checkbox" name="przed17" value="Film">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    Fotografia
                    <input type="checkbox" name="przed18" value="Fotografia">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    HistoriaSztuki
                    <input type="checkbox" name="przed19" value="HistoriaSztuki">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    Astronomia
                    <input type="checkbox" name="przed20" value="Astronomia">
                    <span class="checkmark"></span>
                </label>
            </div>
            <p class="infosx">Zakres w którym możemy ci pomóc w zaznaczonych przedmiotach</p>
            <input type="text" class="minput" placeholder="Dodatkowa informacja" name="notatka" autocomplete="off">

            <p style="margin-botton:20px;">Klikając przycisk Ok, akceptujesz nasz  <a target="_blank" href="http://3-lab.pl/3class/">Regulamin</a>.</p>
            <div class="g-recaptcha" data-sitekey="6Lcl_OIUAAAAADgDChzz76IgK4rwRZv70Wu2jdMT"></div>
            <input type="submit" value="Ok" name="action" class="mainbut">
        </form>

        <p class="info" style="color: black;">Made by Piotr Bieńskowski, Bartek Kostarczyk &amp; Mateusz Mazurczak with 💕</p>

        <div class="spacer"></div>
    </div>

    <script src="js/general.js"></script>
</BODY>
