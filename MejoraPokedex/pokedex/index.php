<?php

include 'request.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <h1 style="text-align: center;">Mi Pokedex</h1>
        <center>
            <table border="1" style="width: 60%;">
                <tr>
                    <td style="text-align: center;">
                        <label for="" style="text-align: center;">Nombre: </label>
                        <input type="text" style="text-align: center;">
                        <select name="" id="">
                            <?php
                                for($i = 0; $i < 20; $i++){
                                    echo "<option value='1'>".$data['results'][$i]["name"]."</option>";
                                }
                            ?>
                        </select>
                        <input type="submit" value="Buscar">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                    <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/shiny/1.png">
                    </td>
                </tr>
            </table>
        </center>
    </form>
</body>
</html>

<!-- 
<?php
/*
# Como usamos un for

for($i = 0; $i < 20; $i++){
    echo $data['results'][$i]["name"]."<br>";
    #echo "$i".'<br>';
}
*/
?>
