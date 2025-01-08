<?php
require_once("db.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
 
$stmt = $conn->prepare("SELECT * FROM bogudgivelser");
$stmt->execute();

$stmt->setFetchMode(PDO::FETCH_ASSOC);
$results = $stmt->fetchAll();

$json_data = json_encode($results, JSON_PRETTY_PRINT);

header("content-type:application/json");
echo $json_data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $targetDir = "images/";
    $targetFile = $targetDir . basename($_FILES["foto"]["name"]);
    $uploadOk = true;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" ){
        $uploadOk = false;
    }
    
    if ($uploadOk == false) {
        echo "Din filtype er ikke godkendt her!";
    } else {
        if(move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile)){
            echo "Filen er blevet uploadet.";
        } else {
            echo "Filen blev ikke uploadet.";
        }
    }    
    
$cols = "titel, forfatter, kategori, sprog, format, sider, udgivelsesdato, forlag, beskrivelse, foto";
$values = ":titel, :forfatter, :kategori, :sprog, :format, :sider, :udgivelsesdato, :forlag, :beskrivelse, :foto";

$stmt = $conn->prepare("INSERT INTO bogudgivelser ($cols) VALUES($values)");
$stmt->bindParam(":titel", $_POST["titel"]);
$stmt->bindParam(":forfatter", $_POST["forfatter"]);
$stmt->bindParam(":kategori", $_POST["kategori"]);
$stmt->bindParam(":sprog", $_POST["sprog"]);
$stmt->bindParam(":format", $_POST["format"]);
$stmt->bindParam(":sider", $_POST["sider"]);
$stmt->bindParam(":udgivelsesdato", $_POST["udgivelsesdato"]);
$stmt->bindParam(":forlag", $_POST["forlag"]);
$stmt->bindParam(":beskrivelse", $_POST["beskrivelse"]);
$stmt->bindParam(":foto", $targetFile);  

$stmt->execute();
$result = $stmt->fetchAll();
$json_data = json_encode($result, JSON_PRETTY_PRINT);
header("content-type:application/json");
echo $json_data;

}

?>