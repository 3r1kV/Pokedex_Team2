<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex 100% Funcional No Fake</title>
    <link rel="stylesheet" href="style.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
    <style>
        .tablasInfo {
            display: flex;
            margin-left: 100px;
        }

        .tablasInfo table {
            margin-right: 30px;
        }
    </style>

    <audio id="miMusica" src="sounds/fondo_music.mp3" preload="auto"></audio>
    <video id="miVideo" src="videos/fondo.mp4" muted autoplay loop></video>
    <button class="musicButton" id="musicButton" onclick="toggleMusic()"></button>

    <script>
        var miMusica = document.getElementById("miMusica");
        var musicButton = document.getElementById("musicButton");

        miMusica.addEventListener('ended', function() {
            this.currentTime = 0;
            this.play();
        }, false);

        function toggleMusic() {
            if (miMusica.paused) {
                miMusica.play();
                enableInputAndButton();
                miMusica.volume = 0.2;
                changeTableColor();
            } else {
                miMusica.pause();
                miMusica.currentTime = 0;
                disableInputAndButton();
                clearTable();
                clearInput();
                changeTableColorblack();
            }
        }

        function disableInputAndButton() {
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('searchInput').disabled = true;
            document.getElementById('pokemonSelect').disabled = true;
        }

        function enableInputAndButton() {
            document.getElementById('submitBtn').disabled = false;
            document.getElementById('searchInput').disabled = false;
            document.getElementById('pokemonSelect').disabled = false;
        }

        function clearTable() {
            document.getElementById('pokeinfo').innerHTML = '';
        }

        function clearInput() {
            document.getElementById('searchInput').value = "";
        }
    </script>

    <script>
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

    </center>


    <div class="tablasInfo">
        <table class="tbl-pokedex">
            <th id="pokeinfo" width="1000px" ; height="660px">
            </th>
        </table>

        <div class="container">

            <input type="submit" value="Buscar" id="submitBtn" disabled>
            <input type="text" placeholder="Ingrese un Pokemon" maxlength="15" name="dato" id="searchInput" disabled>
            <select id="pokemonSelect" disabled>
                <option value="opcion1">Selecciona un Pokémon</option>
            </select>
            <div class="pokeIMG">
                <div class="tabla-externa">
                    <div class="tabla-container" id="imagenes">
                        <!-- Contenedor de imágenes se llenará dinámicamente -->
                    </div>
                </div>
            </div>
        </div>

        <script>
$(document).ready(function() {
    getAllPokemon();
    // Detectar cambio en el select y actualizar el input
    $('#pokemonSelect').on('change', function() {
        $('#searchInput').val($(this).val());
    });
    $('#searchInput').on('input', function() {
        filterPokemon($(this).val().toLowerCase());
    });
});

function getAllPokemon() {
    $.ajax({
        url: 'https://pokeapi.co/api/v2/pokemon?limit=1302',
        type: 'GET',
        success: function(data) {
            const pokemonList = data.results;
            pokemonList.sort((a, b) => getPokemonId(a.url) - getPokemonId(b.url)); // Ordenar por ID
            pokemonList.forEach(pokemon => {
                const name = pokemon.name;
                const imageUrl = `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/${getPokemonId(pokemon.url)}.png`;
                const imageElement = $('<img>').addClass('pokemon-image').attr('src', imageUrl).attr('alt', name).click(function() {
                    $('#searchInput').val(name); // Al hacer clic en la imagen, se envía el nombre del Pokémon al campo de entrada
                });
                $('#imagenes').append(imageElement); // Agrega la imagen al contenedor de imágenes

                const option = $('<option>').text(name).val(name.toLowerCase()); // Crea una opción para el select
                $('#pokemonSelect').append(option); // Agrega la opción al select
            });
        },
        error: function(xhr, status, error) {
            console.error("Error al obtener la lista de Pokémon:", error);
        }
    });
}

function getPokemonId(url) {
    const parts = url.split('/');
    return parseInt(parts[parts.length - 2]); // Obtener el ID de la URL
}

function filterPokemon(keyword) {
    $('.pokemon-image').each(function() {
        const name = $(this).attr('alt').toLowerCase();
        if (name.indexOf(keyword) !== -1) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}
</script>

        <!-- 
<script>
        $(document).ready(function() {
            getAllPokemon();
            $('#searchInput').on('input', function() {
                filterPokemon($(this).val().toLowerCase());
            });
        });

        function getAllPokemon() {
            $.ajax({
                url: 'https://pokeapi.co/api/v2/pokemon?limit=1302',
                type: 'GET',
                success: function(data) {
                    const pokemonList = data.results;
                    pokemonList.sort((a, b) => getPokemonId(a.url) - getPokemonId(b.url)); // Ordenar por ID
                    pokemonList.forEach(pokemon => {
                        const name = pokemon.name;
                        const option = $('<option>').text(name).val(name.toLowerCase()); // Crea una opción para el select
                        $('#pokemonSelect').append(option); // Agrega la opción al select
                        getPokemonImage(pokemon.url, name); // Pasar el nombre del Pokémon
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error al obtener la lista de Pokémon:", error);
                }
            });
        }

        function getPokemonId(url) {
            const parts = url.split('/');
            return parseInt(parts[parts.length - 2]); // Obtener el ID de la URL
        }

        function getPokemonImage(url, name) { // Agregar el parámetro para el nombre del Pokémon
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    const imageUrl = data.sprites.other['official-artwork'].front_default;
                    if (imageUrl) {
                        displayPokemonInfo(name, imageUrl, getPokemonId(url)); // Llamar a displayPokemonInfo con el nombre, la URL de la imagen y el ID del Pokémon
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error al obtener la imagen de " + name + ":", error);
                }
            });
        }

        // La función displayPokemonInfo ahora toma el nombre, la URL de la imagen y la ID del Pokémon como argumentos
        function displayPokemonInfo(name, imageUrl, pokemonId) {
            const pokemonImagesDiv = $('#imagenes');
            const containerDiv = $('<div>').addClass('pokemon-container');
            const imageElement = $('<img>').addClass('pokemon-image').attr('src', imageUrl).attr('alt', name);
            const nameElement = $('<p>').addClass('pokemon-name').text(name);
            const idElement = $('<p>').addClass('pokemon-id').text('ID: ' + pokemonId); // Agregar ID del Pokémon

            containerDiv.append(imageElement);
            containerDiv.append(nameElement);
            containerDiv.append(idElement); // Agregar el elemento ID debajo del nombre

            pokemonImagesDiv.append(containerDiv);
        }

        function filterPokemon(keyword) {
            $('.pokemon-container').each(function() {
                const name = $(this).find('.pokemon-name').text().toLowerCase();
                if (name.indexOf(keyword) !== -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
</script> -->

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

                        tableContent += data.species.name + '<br>';

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