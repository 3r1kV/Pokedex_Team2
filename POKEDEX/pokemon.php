<?php
// Verificar si se recibió una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el nombre del Pokémon del formulario
    $pokemon = $_POST['dato'];

    // URL de la API PokeAPI para obtener datos del Pokémon
    $url = "https://pokeapi.co/api/v2/pokemon/$pokemon";

    // Realizar una solicitud HTTP GET a la API PokeAPI
    $pokemonData = file_get_contents($url);

    // Verificar si se obtuvieron los datos del Pokémon correctamente
    if ($pokemonData !== false) {
        // Decodificar los datos JSON recibidos
        $pokemonData = json_decode($pokemonData);

        // Devolver los datos del Pokémon como respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($pokemonData);
    } else {
        // Si no se pudieron obtener los datos del Pokémon, devolver un error
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(array("error" => "No se pudieron obtener los datos del Pokémon"));
    }
} else {
    // Si la solicitud no es POST, devolver un error
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(array("error" => "Solicitud no permitida"));
}
?>
