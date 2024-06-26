<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex 100% Real</title>
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="estilos.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
</head>

<style>
    table,
    th {
        border: 2px solid black;
        text-align: center;
    }
</style>

<audio id="miMusica" src="sounds/fondo_music.mp3" preload="auto"></audio>
<button class="musicButton" id="musicButton" onclick="toggleMusic()"></button>

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
            sessionStorage.setItem('musicaReproduciendo', true);
            enableInputAndButton();
            miMusica.volume = 0.4;
            changeTableColor();
        } else {
            miMusica.pause();
            sessionStorage.setItem('musicaReproduciendo', false);
            disableInputAndButton();
            clearTable();
            clearInput();
            changeTableColorblack();
            // Habilitar input y botón submit
        }
    }

    // Guardar el tiempo de reproducción al salir de la página
    window.addEventListener('beforeunload', function() {
        sessionStorage.setItem('musicaTiempo', miMusica.currentTime);
    });

    // Función para desactivar input y botón de búsqueda
    function disableInputAndButton() {
        document.getElementById('pokemonInput').disabled = true;
        document.getElementById('submitBtn').disabled = true;
    }

    // Función para habilitar input y botón de búsqueda
    function enableInputAndButton() {
        document.getElementById('pokemonInput').disabled = false;
        document.getElementById('submitBtn').disabled = false;
    }

    // Función para borrar el contenido de la tabla
    function clearTable() {
        document.getElementById('pokeinfo').innerHTML = '';
    }

    function clearInput(){
        document.getElementById('pokemonInput').value = "";
    }

    function changeTableColorblack() {
    var table = document.getElementById('pokeinfo');
    table.style.backgroundColor = '#0080B3';
    }


    function changeTableColor() {
    var table = document.getElementById('pokeinfo');
    table.style.backgroundColor = 'white';
    }
</script>

<center>
    <h1><img class ="pokedex" src="img/Pokédex_logo.webp" alt=""></h1>
    <form id="pokemonForm">
        <label for="Pokemon" id="Nom-Pokemon">Pokemon :</label>
        <input type="text" placeholder="Ingrese un Pokemon" maxlength="15" name="dato" id="pokemonInput" disabled>
        <input type="submit" value="Buscar" id="submitBtn" disabled>
    </form>
    <table class="tbl-pokedex">
        <td id="pokeinfo" width="1000px" ; height="660px">
            
        </td>
    </table>
</center>

<script>
    document.getElementById("pokemonForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Evitar el comportamiento predeterminado del formulario

        var formData = new FormData(this);

        fetch("consultAPI.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Mostrar los datos del Pokemon en la tabla
            var tableContent = '';

            tableContent += '<div id="nombre">';

            tableContent += '<h2>NOMBRE</h2>'
            data.forms.forEach(function(name){
                tableContent += name.name + '<br>';
            })
                tableContent += 'ID : '+data.id + '<br>';

            tableContent += '</div>';

            tableContent += '<div id="hablilidades">';

            tableContent += '</div>';

            tableContent += '<div id="hablilidades">';

            tableContent += '<h2>HABILIDADES</h2>';
            data.abilities.forEach(function(ability) {
                tableContent += ability.ability.name + '<br>';
            });

            tableContent += '</div>';

            tableContent += '<div id="tipo">';

            tableContent += '<h2>TIPO</h2>';
            data.types.forEach(function(type) {
                tableContent += type.type.name + '<br>';
            });

            tableContent += '</div>';

            tableContent += '<div id="estadisticas">';

            tableContent += '<h2>ESTADISTICAS</h2>';
            data.stats.forEach(function(stat) {
                tableContent += stat.stat.name + ' = ' + stat.base_stat + '<br>';
            });

            tableContent += '</div>';

            tableContent += '<div id="fotos">';
            
            tableContent += '<h2>FOTOS</h2>';
            tableContent += '<img src="' + data.sprites.other.showdown.front_default + '" width="100">';
            tableContent += '<img src="' + data.sprites.other.showdown.back_default + '" width="130">';
            
            tableContent += '</div>';

            document.getElementById('pokeinfo').innerHTML = tableContent;

            
        })
        .catch(error => console.error('Error:', error));
    });
</script>

</body>
</html>
