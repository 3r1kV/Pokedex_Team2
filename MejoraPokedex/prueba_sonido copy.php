<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex 100% Real</title>
    <link rel="stylesheet" href="style.css">


    <link rel="stylesheet" href="style.css">



    <style>
        table,
        th {
            border: 2px solid black;
            text-align: center;
        }
    </style>

    <audio id="miMusica" src="sounds/fondo_music.mp3" preload="auto"></audio>
    <video id="miVideo"src="videos/fondo.mp4" muted autoplay loop></video>
    <button class="musicButton" id="musicButton" onclick="toggleMusic()"></button>
    <script>
        var miMusica = document.getElementById("miMusica");
        var musicButton = document.getElementById("musicButton");

        // Si hay datos en sessionStorage, cargarlos
        if (sessionStorage.getItem('musicaReproduciendo') === 'true') {
            var tiempo = parseFloat(sessionStorage.getItem('musicaTiempo'));
            miMusica.currentTime = tiempo;
            miMusica.play();
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

        function clearInput() {
            document.getElementById('pokemonInput').value = "";
        }

        // function changeTableColorblack() {
        //     var table = document.getElementById('pokeinfo');
        //     table.style.backgroundColor = '#0080B3';
        // }


        // function changeTableColor() {
        //     var table = document.getElementById('pokeinfo');
        //     table.style.backgroundColor = 'white';
        // }
    </script>




    <center>
        <h1><img class="pokedex" src="img/Pokédex_logo.webp" alt=""></h1>
        <form id="pokemonForm">
            <label for="Pokemon" id="Nom-Pokemon">Pokemon :</label>
            <input type="text" placeholder="Ingrese un Pokemon" maxlength="15" name="dato" id="pokemonInput" disabled>
            <input type="submit" value="Buscar" id="submitBtn" disabled> -->

            <br>
            <input type="text" id="searchInput" placeholder="Search Pokémon">
            <br>
            <select id="pokemonSelect" style="width: 177px;">
                <option value="">Selecciona un Pokémon</option>
            </select>


            <table class="tbl-pokedex">
                <td id="pokeinfo" width="1000px" ; height="660px">

                </td>
            </table>
    </center>







    <script>
        const apiUrl = 'https://pokeapi.co/api/v2/pokemon?limit=1025';

        async function fetchPokemonNames() {
            const response = await fetch(apiUrl);
            const data = await response.json();
            const pokemonNames = data.results.map(pokemon => pokemon.name);
            return pokemonNames;
        }

        async function populatePokemonSelect() {
            const pokemonNames = await fetchPokemonNames();
            const select = document.getElementById('pokemonSelect');
            pokemonNames.forEach(name => {
                const option = document.createElement('option');
                option.value = name;
                option.textContent = name;
                select.appendChild(option);
            });
        }

        function filterPokemonNames(term) {
            const select = document.getElementById('pokemonSelect');
            const options = select.options;
            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                const pokemonName = option.textContent.toLowerCase();
                if (pokemonName.includes(term)) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            }
        }

        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.trim().toLowerCase();
            filterPokemonNames(searchTerm);
        });

        // Populate the select with Pokémon names when the page loads
        window.onload = populatePokemonSelect;
    </script>

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
                    data.forms.forEach(function(name) {
                        tableContent += name.name + '<br>';
                    })
                    tableContent += 'ID : ' + data.id + '<br>';

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
                    tableContent += '<img src="' + data.sprites.other.showdown.back_default + '" width="130"> <br>';
                    tableContent += `<img src=${data.sprites.other["official-artwork"].front_default} width="190">`;
                    tableContent += `<img src=${data.sprites.other["official-artwork"].front_shiny} width="190">`;

                    tableContent += '</div>';

                    document.getElementById('pokeinfo').innerHTML = tableContent;


                })
                .catch(error => console.error('Error:', error));
        });
    </script>

    </body>

</html>