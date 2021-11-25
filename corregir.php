<?php 

$contEncerts = 0;
$contEnBlanc = 0;
$contMalament = 0;
$totalPreguntes =  0;

$encert  =  1;
$malament  =  0.5;


$arxiu = fopen("preguntes/HernandezJulianDecoded.txt", "r");
while($linea = fgets($arxiu)) {
    $resposta = explode(";", $linea);
    $totalPreguntes++;
    if (empty($_POST["pregunta$resposta[0]"])) {
        $contEnBlanc++;
    } else {
        $solucio = explode("\n", $resposta[2]);
        if(strcmp($_POST["pregunta$resposta[0]"], $solucio[0])){
            $contMalament++;
        } else {
            $contEncerts++;
        }
    }
}
fclose($arxiu);

echo "Encerts: ".$contEncerts;
echo "<br>";
echo "En blanc: ".$contEnBlanc;
echo "<br>";
echo "Malament: ".$contMalament;
echo "<br>";

$nota = (($contEncerts-($contMalament*$malament))/$totalPreguntes)*10;

echo "<br>";
echo "La teva nota es: ".$nota;

$old = fopen("oldExamen/old.txt", "a");

$str = $_POST['nom']. ";".$nota ."\n";

fwrite($old, $str);

fclose($old);

$old = fopen("oldExamen/old.txt", "r");

echo "<br>";
while($linea = fgets($old)) {
    $a = explode(";", $linea);
    echo "Nom: ". $a[0]." Nota: ".$a[1];
    echo "<br>";
}
fclose($old);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correccio</title>
</head>
<body>
</body>
</html>