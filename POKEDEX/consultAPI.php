<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $pokemon = $_POST['dato'];
    
    $url = "https://pokeapi.co/api/v2/pokemon/$pokemon";
    
    $pokemonData = file_get_contents($url);
    
    if ($pokemonData !== false) {
        
        $pokemonData = json_decode($pokemonData);
        
        header('Content-Type: application/json');
        echo json_encode($pokemonData);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(array("error" => "No se pudieron obtener los datos del Pokémon"));
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(array("error" => "Solicitud no permitida"));
}