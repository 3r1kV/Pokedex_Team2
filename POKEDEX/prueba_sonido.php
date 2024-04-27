<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex 100% Real</title>
</head>


<style>
    table,
    th {
        Border: 2px solid black;
        text-align: center;
    }
</style>
    
<audio id="miMusica" src="sounds/fondo_music.mp3" preload="auto"></audio>

<button id="musicButton" onclick="toggleMusic()">Reproducir Música</button>

<script>
    var miMusica = document.getElementById("miMusica");
    var musicButton = document.getElementById("musicButton");

    // Si hay datos en sessionStorage, cargarlos
    if (sessionStorage.getItem('musicaReproduciendo') === 'true') {
        var tiempo = parseFloat(sessionStorage.getItem('musicaTiempo'));
        miMusica.currentTime = tiempo;
        miMusica.play();
        musicButton.textContent = 'Pausar Música';
    }

    function toggleMusic() {
        if (miMusica.paused) {
            miMusica.play();
            musicButton.textContent = 'Pausar Música';
            sessionStorage.setItem('musicaReproduciendo', true);
        } else {
            miMusica.pause();
            musicButton.textContent = 'Reproducir Música';
            sessionStorage.setItem('musicaReproduciendo', false);
        }
    }

    // Guardar el tiempo de reproducción al salir de la página
    window.addEventListener('beforeunload', function() {
        sessionStorage.setItem('musicaTiempo', miMusica.currentTime);
    });
</script>


    <center>
        <h1>Pokedex</h1>
        <from>
            <label for="Pokemon">Pokemon:</label>
            <form action="" method="post">
                <input type="text" placeholder="Ingrese un Pokemon" maxlength="15" name="dato">
                <input type="submit" value="Buscar" name="buton">
            </form>
        </from>
        <br><br>
        <table>
            <td width="1200px" ; height="600px">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buton'])) {
                    $pokemon = $_POST['dato'];
                    $api = (curl_init("https://pokeapi.co/api/v2/pokemon/$pokemon"));
                    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($api);
                    curl_close($api);

                    $json = json_decode($response);

                    echo '<h2>Nombre</h2>';
                    foreach ($json->forms as $k => $v) {
                        echo $v->name . '<br>';
                    }

                    echo '<h2>HABILIDADES</h2>';
                    foreach ($json->abilities as $k => $v) {
                        echo $v->ability->name . '<br>';
                    }

                    echo '<h2>TIPO</h2>';
                    foreach ($json->types as $A => $X) {
                        echo $X->type->name . '<br>';
                    }

                    echo '<h2>ESTADISTICAS</h2>';
                    foreach ($json->stats as $W => $S) {
                        echo $S->stat->name, ' = ';
                        echo $S->base_stat .'<br>';
                    }
                    echo '<h2>FOTOS</h2>';
                    echo '<img src="' . $json->sprites->other->showdown->front_default . '" width="100">';
                    echo '<img src="' . $json->sprites->other->showdown->back_default . '" width="130">';
                }
                ?>
            </td>
        </table>
    </center>

</body>

</html>