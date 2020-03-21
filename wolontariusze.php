<?php
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
$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6Lcl_OIUAAAAAM-dDD6TVuhCtrlginws5Wn6-R8L&response='.$_POST['g-recaptcha-response']);
        
$odpowiedz = json_decode($sprawdz);
        
if ($odpowiedz->success==false)
{
    unset($_POST['action']);
    echo "<script>";
    echo "alert('Jestes robotem');";
    echo "</script>";
    header('Location: index.php');
}
$name = htmlentities($_POST['name']);
$surname = htmlentities($_POST['surname']);
$email = htmlentities($_POST['email']);
$ilegodz = htmlentities($_POST['ilegodz']);
$komunikatory = htmlentities($_POST['komunikatory']);
$przedmioty = htmlentities($_POST['przedmioty']);
$szkola_id = $_SESSION['idszkoly'];

$ciagPon="";
for($i=7;$i<21;++$i){
if(isset($_POST['pon'.strval($i)])){
$ciagPon=$ciagPon.'1';
}
else{
$ciagPon=$ciagPon.'0';
}
}

$ciagWt="";
for($i=7;$i<21;++$i){
if(isset($_POST['wt'.strval($i)])){
$ciagWt=$ciagWt.'1';
}
else{
$ciagWt=$ciagWt.'0';
}
}

$ciagSr="";
for($i=7;$i<21;++$i){
if(isset($_POST['sr'.strval($i)])){
$ciagSr=$ciagSr.'1';
}
else{
$ciagSr=$ciagSr.'0';
}
}

$ciagCzw="";
for($i=7;$i<21;++$i){
if(isset($_POST['czw'.strval($i)])){
$ciagCzw=$ciagCzw.'1';
}
else{
$ciagCzw=$ciagCzw.'0';
}
}

$ciagPt="";
for($i=7;$i<21;++$i){
if(isset($_POST['pt'.strval($i)])){
$ciagPt=$ciagPt.'1';
}
else{
$ciagPt=$ciagPt.'0';
}
}

$ciagSob="";
for($i=7;$i<21;++$i){
if(isset($_POST['sob'.strval($i)])){
$ciagSob=$ciagSob.'1';
}
else{
$ciagSob=$ciagSob.'0';
}
}

$ciagNd="";
for($i=7;$i<21;++$i){
if(isset($_POST['nd'.strval($i)])){
$ciagNd=$ciagNd.'1';
}
else{
$ciagNd=$ciagNd.'0';
}
}

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

$sql = sprintf("INSERT INTO wolontariusze (_imie, _nazwisko, _email, _szkola_id, _liczba_godzin, _komunikatory, _przedmioty, _przedmiotyCiag, _godzPon, _godzWt, _godzSr, _godzCzw, _godzPt, _godzSob, _godzNd)
VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                  $conn->real_escape_string($name),
                  $conn->real_escape_string($surname),
                  $conn->real_escape_string($email),
                  $conn->real_escape_string($szkola_id),
                  $conn->real_escape_string($ilegodz),
                  $conn->real_escape_string($komunikatory),
                  $conn->real_escape_string($ciagPrzed),
                  $conn->real_escape_string($ciagPrzedC),
                  $conn->real_escape_string($ciagPon),
                  $conn->real_escape_string($ciagWt),
                  $conn->real_escape_string($ciagSr),
                  $conn->real_escape_string($ciagCzw),
                  $conn->real_escape_string($ciagPt),
                  $conn->real_escape_string($ciagSob),
                  $conn->real_escape_string($ciagNd));
$result=$conn->query($sql);

if ($result === TRUE)
{
echo "<script>";
echo "alert('Konto zostało dodane, opiekun twojej szkoły dostał informacje o twoim zgłoszeniu i będzie cię informował na bierząco');";
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
            <p class="infosx">Cześć! Miło Cię widzieć, czy jesteś licealistą, który zechciałby udzieliać korepetycji młodszym kolegom? :)</p>
            <input type="text" class="minput" placeholder="Imię" name="name" autocomplete="off" required>
            <input type="text" class="minput" placeholder="Nazwisko" name="surname" autocomplete="off" required>
            <input type="text" class="minput" placeholder="E-mail" name="email" autocomplete="off" required>

            <p class="infos">Ile czasu w godzinach chiałbyś poświęcić na korepetycje tygodniowo?</p>
            <input type="text" class="minput" placeholder="Ile godzin tygodniowo" name="ilegodz" autocomplete="off" required>

            <p class="infos">Poprzez jakie komunikatory (np. Discord, Skype, Messenger) możeż prowadzić lekcje online?</p>
            <input type="text" class="minput" placeholder="Komunikatory" name="komunikatory" autocomplete="off" required>

            <p class="infos">Powiedz nam, z jakich przedmiotów mógłbyś dawać korepetycje.</p>
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

            <p class="infos">Powiedz nam, kiedy jesteś dostępny.</p>
            
            <p class="infosx">Poniedziałek</p>

            <div class="gridmaker">
                <label class="container">
                    7:00 - 8:00
                    <input type="checkbox" name="pon7">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    8:00 - 9:00
                    <input type="checkbox" name="pon8">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    9:00 - 10:00
                    <input type="checkbox" name="pon9">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    10:00 - 11:00
                    <input type="checkbox" name="pon10">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    11:00 - 12:00
                    <input type="checkbox" name="pon11">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    12:00 - 13:00
                    <input type="checkbox" name="pon12">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    13:00 - 14:00
                    <input type="checkbox" name="pon13">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    14:00 - 15:00
                    <input type="checkbox" name="pon14">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    15:00 - 16:00
                    <input type="checkbox" name="pon15">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    16:00 - 17:00
                    <input type="checkbox" name="pon16">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    17:00 - 18:00
                    <input type="checkbox" name="pon17">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    18:00 - 19:00
                    <input type="checkbox" name="pon18">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    19:00 - 20:00
                    <input type="checkbox" name="pon19">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    20:00 - 21:00
                    <input type="checkbox" name="pon20">
                    <span class="checkmark"></span>
                </label>
            </div>

             <p class="infosx">Wtorek</p>

            <div class="gridmaker">
                <label class="container">
                    7:00 - 8:00
                    <input type="checkbox" name="wt7">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    8:00 - 9:00
                    <input type="checkbox" name="wt8">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    9:00 - 10:00
                    <input type="checkbox" name="wt9">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    10:00 - 11:00
                    <input type="checkbox" name="wt10">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    11:00 - 12:00
                    <input type="checkbox" name="wt11">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    12:00 - 13:00
                    <input type="checkbox" name="wt12">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    13:00 - 14:00
                    <input type="checkbox" name="wt13">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    14:00 - 15:00
                    <input type="checkbox" name="wt14">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    15:00 - 16:00
                    <input type="checkbox" name="wt15">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    16:00 - 17:00
                    <input type="checkbox" name="wt16">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    17:00 - 18:00
                    <input type="checkbox" name="wt17">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    18:00 - 19:00
                    <input type="checkbox" name="wt18">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    19:00 - 20:00
                    <input type="checkbox" name="wt19">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    20:00 - 21:00
                    <input type="checkbox" name="wt20">
                    <span class="checkmark"></span>
                </label>
            </div>

             <p class="infosx">Środa</p>

            <div class="gridmaker">
                <label class="container">
                    7:00 - 8:00
                    <input type="checkbox" name="sr7">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    8:00 - 9:00
                    <input type="checkbox" name="sr8">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    9:00 - 10:00
                    <input type="checkbox" name="sr9">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    10:00 - 11:00
                    <input type="checkbox" name="sr10">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    11:00 - 12:00
                    <input type="checkbox" name="sr11">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    12:00 - 13:00
                    <input type="checkbox" name="sr12">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    13:00 - 14:00
                    <input type="checkbox" name="sr13">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    14:00 - 15:00
                    <input type="checkbox" name="sr14">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    15:00 - 16:00
                    <input type="checkbox" name="sr15">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    16:00 - 17:00
                    <input type="checkbox" name="sr16">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    17:00 - 18:00
                    <input type="checkbox" name="sr17">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    18:00 - 19:00
                    <input type="checkbox" name="sr18">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    19:00 - 20:00
                    <input type="checkbox" name="sr19">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    20:00 - 21:00
                    <input type="checkbox" name="sr20">
                    <span class="checkmark"></span>
                </label>
            </div>

             <p class="infosx">Czwartek</p>

            <div class="gridmaker">
                <label class="container">
                    7:00 - 8:00
                    <input type="checkbox" name="czw7">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    8:00 - 9:00
                    <input type="checkbox" name="czw8">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    9:00 - 10:00
                    <input type="checkbox" name="czw9">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    10:00 - 11:00
                    <input type="checkbox" name="czw10">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    11:00 - 12:00
                    <input type="checkbox" name="czw11">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    12:00 - 13:00
                    <input type="checkbox" name="czw12">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    13:00 - 14:00
                    <input type="checkbox" name="czw13">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    14:00 - 15:00
                    <input type="checkbox" name="czw14">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    15:00 - 16:00
                    <input type="checkbox" name="czw15">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    16:00 - 17:00
                    <input type="checkbox" name="czw16">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    17:00 - 18:00
                    <input type="checkbox" name="czw17">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    18:00 - 19:00
                    <input type="checkbox" name="czw18">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    19:00 - 20:00
                    <input type="checkbox" name="czw19">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    20:00 - 21:00
                    <input type="checkbox" name="czw20">
                    <span class="checkmark"></span>
                </label>
            </div>

             <p class="infosx">Piątek</p>

            <div class="gridmaker">
                <label class="container">
                    7:00 - 8:00
                    <input type="checkbox" name="pt7">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    8:00 - 9:00
                    <input type="checkbox" name="pt8">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    9:00 - 10:00
                    <input type="checkbox" name="pt9">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    10:00 - 11:00
                    <input type="checkbox" name="pt10">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    11:00 - 12:00
                    <input type="checkbox" name="pt11">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    12:00 - 13:00
                    <input type="checkbox" name="pt12">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    13:00 - 14:00
                    <input type="checkbox" name="pt13">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    14:00 - 15:00
                    <input type="checkbox" name="pt14">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    15:00 - 16:00
                    <input type="checkbox" name="pt15">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    16:00 - 17:00
                    <input type="checkbox" name="pt16">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    17:00 - 18:00
                    <input type="checkbox" name="pt17">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    18:00 - 19:00
                    <input type="checkbox" name="pt18">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    19:00 - 20:00
                    <input type="checkbox" name="pt19">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    20:00 - 21:00
                    <input type="checkbox" name="pt20">
                    <span class="checkmark"></span>
                </label>
            </div>

             <p class="infosx">Sobota</p>

            <div class="gridmaker">
                <label class="container">
                    7:00 - 8:00
                    <input type="checkbox" name="sob7">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    8:00 - 9:00
                    <input type="checkbox" name="sob8">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    9:00 - 10:00
                    <input type="checkbox" name="sob9">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    10:00 - 11:00
                    <input type="checkbox" name="sob10">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    11:00 - 12:00
                    <input type="checkbox" name="sob11">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    12:00 - 13:00
                    <input type="checkbox" name="sob12">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    13:00 - 14:00
                    <input type="checkbox" name="sob13">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    14:00 - 15:00
                    <input type="checkbox" name="sob14">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    15:00 - 16:00
                    <input type="checkbox" name="sob15">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    16:00 - 17:00
                    <input type="checkbox" name="sob16">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    17:00 - 18:00
                    <input type="checkbox" name="sob17">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    18:00 - 19:00
                    <input type="checkbox" name="sob18">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    19:00 - 20:00
                    <input type="checkbox" name="sob19">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    20:00 - 21:00
                    <input type="checkbox" name="sob20">
                    <span class="checkmark"></span>
                </label>
            </div>

            <p class="infosx">Niedziela</p>

            <div class="gridmaker">
                <label class="container">
                    7:00 - 8:00
                    <input type="checkbox" name="nd7">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    8:00 - 9:00
                    <input type="checkbox" name="nd8">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    9:00 - 10:00
                    <input type="checkbox" name="nd9">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    10:00 - 11:00
                    <input type="checkbox" name="nd10">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    11:00 - 12:00
                    <input type="checkbox" name="nd11">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    12:00 - 13:00
                    <input type="checkbox" name="nd12">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    13:00 - 14:00
                    <input type="checkbox" name="nd13">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    14:00 - 15:00
                    <input type="checkbox" name="nd14">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    15:00 - 16:00
                    <input type="checkbox" name="nd15">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    16:00 - 17:00
                    <input type="checkbox" name="nd16">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    17:00 - 18:00
                    <input type="checkbox" name="nd17">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    18:00 - 19:00
                    <input type="checkbox" name="nd18">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    19:00 - 20:00
                    <input type="checkbox" name="nd19">
                    <span class="checkmark"></span>
                </label>
                <label class="container">
                    20:00 - 21:00
                    <input type="checkbox" name="nd20">
                    <span class="checkmark"></span>
                </label>
            </div>
            <p style="margin-botton:20px;">Klikając przycisk Ok, akceptujesz nasz  <a target="_blank" href="http://3-lab.pl/3class/">Regulamin</a>.</p>
            <div class="g-recaptcha" data-sitekey="6Lcl_OIUAAAAADgDChzz76IgK4rwRZv70Wu2jdMT"></div>
            <input type="submit" value="Ok" name="action" class="mainbut">
        </form>

        <p class="info" style="color: black;">Made by Piotr Bieńskowski, Bartek Kostarczyk &amp; Mateusz Mazurczak with 💕</p>

        <div class="spacer"></div>
    </div>

    <script src="js/general.js"></script>
</BODY>
