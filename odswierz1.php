<?php
    session_start();
    include "db.php";
    /*if(!isset($_SESSION['gsidkLOG']))
    { 
        header("Location: login.php");
    }
    if($_SESSION['gsidkLOG'] != 123)
    {
        header("Location: login.php");
    }*/
    echo date('N');
    echo "</br>";
    echo date('Y-m-d H:i:s');
    $adate = date('N');
    $adate--;
    $adate--;
    if($adate<0)
    $adate=6;
    if($adate == 0)
        $day = "_godzPon";
        
    else if($adate == 1)
        $day = "_godzWt";

    else if($adate == 2)
        $day = "_godzSr";

    else if($adate == 3)
        $day = "_godzCzw";

    else if($adate == 4)
        $day = "_godzPt";

    else if($adate == 5)
        $day = "_godzSob";

    else if($adate == 6)
        $day = "_godzNd";
    echo "j";

    $sql="SELECT * FROM godziny WHERE _dzien_tyg=$adate";
    $result = $conn->query($sql);
    $rows=$result->num_rows;
    $acuallyid=-1;
    for($i=0;$i<$rows;$i++)
    {

        if($response = @$conn->query("SELECT * FROM godziny WHERE _dzien_tyg=$adate AND _id>$acuallyid LIMIT 1"))
        {
            echo "e";
            $data = $response->fetch_assoc();
            $idgodzina=$data['_id'];
            $id=$data['_id_wolontariusz'];
            $godzina=$data['_godzina'];
            $godzina=$godzina-7;
            $acuallyid = $data['_id'];

            $sql = "SELECT * FROM wolontariusze WHERE _id=$id";
            $result2 = $conn->query($sql);
            if($rows2=$result2->num_rows){
                echo "d";
                $data2 = $result2->fetch_assoc();
                $ileGodz = $data2['_liczba_godzin'];
                $ciag = $data2[$day];
                $ciag[$godzina]='1';
                $sql = "UPDATE wolontariusze SET $day='$ciag' WHERE _id=$id";
                if ($conn->query($sql) === TRUE) 
                {
                    echo "n";
                    $sql = "DELETE FROM godziny WHERE _id = $idgodzina";
                    if ($conn->query($sql) === TRUE) 
                    {
                        $sql = "INSERT INTO bin (_id_wolontariusz) VALUES ('$id')";
                        if ($conn->query($sql) === TRUE) 
                        {
                            echo "ok";
                        } 
                        else 
                        {
                            echo "err";
                        }
                    } 
                    else 
                    {
                        echo "err";
                    }
                } 
            }
            else
            {
                echo "err";
            }
        }
        else
        {
            header('Location: index.php?info=database_err');
        }
    }
    if($adate==6){
        $sql="SELECT * FROM bin";
        $result = $conn->query($sql);
        $rows=$result->num_rows;
        $acuallyid=-1;
        for($i=0;$i<$rows;$i++)
        {
            if($response = @$conn->query("SELECT * FROM bin WHERE _id>$acuallyid LIMIT 1"))
            {
                $data = $response->fetch_assoc();
                $idbin=$data['_id'];
                $id=$data['_id_wolontariusz'];

                $sql = "SELECT * FROM wolontariusze WHERE _id=$id";
                $result2 = $conn->query($sql);
                if($rows2=$result2->num_rows){
                    $data2 = $result2->fetch_assoc();
                    $ileGodz = $data2['_liczba_godzin'];
                    $ileGodz++;
                    $sql = "UPDATE wolontariusze SET _liczba_godzin=$ileGodz WHERE _id=$id";
                    if ($conn->query($sql) === TRUE) 
                    {
                        $sql = "DELETE FROM bin WHERE _id = $idbin";
                        if ($conn->query($sql) === TRUE) 
                        {
                            echo "ok";
                        } 
                    }   
                }
            }
            else
            {
                header('Location: index.php?info=database_err');
            }
        }
    }
    echo "najs";
header("Location: admin.php");
?>