function getAllPokemon() {
    fetch('https://pokeapi.co/api/v2/pokemon?limit=1302')
        .then(response => response.json())
        .then(data => {
            const pokemonList = data.results;
            pokemonList.forEach(pokemon => {
                getPokemonImage(pokemon.url, pokemon.name); // Pasar el nombre del Pokémon
            });
        });
}

function getPokemonImage(url, name) { // Agregar el parámetro para el nombre del Pokémon
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const imageUrl = data.sprites.other['official-artwork'].front_default;
            if (imageUrl) {
                displayPokemonInfo(name, imageUrl); // Llamar a displayPokemonInfo con el nombre y la URL de la imagen
            }
        });
}

// La función displayPokemonInfo ahora toma el nombre y la URL de la imagen como argumentos
function displayPokemonInfo(name, imageUrl) {
    const pokemonImagesDiv = document.getElementById('imagenes');
    const containerDiv = document.createElement('div');
    const imageElement = document.createElement('img');
    const nameElement = document.createElement('p');

    imageElement.src = imageUrl;
    imageElement.alt = name;
    nameElement.textContent = name;
    nameElement.classList.add('pokemon-name'); // Agrega la clase para el nombre del Pokémon

    containerDiv.appendChild(imageElement);
    containerDiv.appendChild(nameElement);
    containerDiv.classList.add('pokemon-container');

    pokemonImagesDiv.appendChild(containerDiv);
}


window.onload = getAllPokemon;
