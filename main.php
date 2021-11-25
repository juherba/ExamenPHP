<?php 

if(!empty($_POST['Enviar'])) {
    $nom = $_POST['nom'];
    $cognom = $_POST['cognom'];

    if (empty($nom)) {
        echo "Has d'omplir el nom!<br>";
    }

    if(empty($cognom)){
        echo "Has d'omplir el cognom!<br>";
    }
        $tmp_txt = $_FILES['file']['tmp_name'];
        $nomArxiu = "hernandezJulianCoded.txt";

        if (is_uploaded_file($tmp_txt)) {
            if (move_uploaded_file($tmp_txt, "preguntes/".$nomArxiu)) {
                $arxiu =  fopen("preguntes/".$nomArxiu, "r");
                $arxiudecoded = fopen("preguntes/HernandezJulianDecoded.txt", "w");
                    while ($fraseOriginal = fgets($arxiu)) {
                        $fraseDecodificada = gzdecode($fraseOriginal);
                        fwrite($arxiudecoded,$fraseDecodificada."\n");
                    }    
                fclose($arxiudecoded);
                fclose($arxiu);
                ?> 
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Examen</title>
                </head>
                <body>
                    <h1>Bienvenido al examen! <?php echo $nom." ".$cognom;?></h1>
                    <form action="corregir.php" method="post">
                        
                    <?php
                    $preguntes = fopen("preguntes/HernandezJulianDecoded.txt",  "r");
                    while ($linea = fgets($preguntes)) {
                        $printar = explode(";", $linea);
                        echo "<p>Pregunta $printar[0]: $printar[1]</p>";
                        echo "Verdader";
                        echo "<input type='radio' name=pregunta$printar[0] value=V>";
                        echo "Fals";
                        echo "<input type='radio' name=pregunta$printar[0] value=F>";
                        echo "<br>";
                    }
                    fclose($preguntes);
                    
                    ?>
                    <input type="hidden" name="nom" value="<?php echo $nom." ".$cognom; ?>">
                    <button type="submit" value="respostes" name="respostes">Enviar respostes</button>
                    </form>
                </body>
                </html>
                
                
                <?php
            } else {
                echo "Has de respetar el formato(txt).";
            }
        } else {
            echo "No se ha podido subir la imagen";
        }
} else {

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="main.php" method="post" enctype="multipart/form-data">
        <label for="nom">Nom: </label>
        <input type="text" name="nom" id="nom">
        <label for="cognom">Cognom: </label>
        <input type="text" name="cognom" id="cognom">
        <input type="file" name="file" id="file">
        <button type="submit" value="Enviar" name="Enviar">Enviar</button>
    </form>
</body>
</html>

<?php
}
?>