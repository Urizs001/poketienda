async function definirdatos() {
    try {
        const pokemonName = document.getElementById("pokemonName").value;
        const apiUrl = `https://pokeapi.co/api/v2/pokemon/${pokemonName.toLowerCase()}`;

        const response = await fetch(apiUrl);
        const data = await response.json();
        const abilities = data.abilities.map(ability => ability.ability.name).join(',');
        const types = data.types.map(type => type.type.name).join(' , ');

        const colorUrl = data.species.url;
        const colorResponse = await fetch(colorUrl);
        const colorData = await colorResponse.json();
        const color = colorData.color.name;

        return {
            data,
            abilities,
            types,
            color
        };
    } catch (error) {
        throw error;
    }
}

async function verPokemon() {
    try {
        const { data, abilities, types, color } = await definirdatos();
        
        const pokemonInfo = `
            <p class="sms">Pokemon no encontrado en la BD,<br> buscado en la API e insertado en la BD </p>
            <h2>${data.name}</h2>
            <h3>id: ${data.id}</h3>
            <div>
                <img src="${data.sprites.front_default}" alt="${data.name}">
                <img src="${data.sprites.front_shiny}" alt="${data.name}">
            </div>
            <p>Altura: ${data.height} Cm</p>
            <p>Peso: ${data.weight} Kg</p>
            <p>Categoria: ${types} </p>
            <p>Color: ${color}</p>
            <p>Habilidad: ${abilities} </p>
        `;
        document.getElementById("pokemonInfo").innerHTML = pokemonInfo;
    } catch (error) {
        document.getElementById("pokemonInfo").textContent = "Pokémon no encontrado.";
    }
    registrar();
}

async function registrar() {
    try {
        const { data, abilities, types, color } = await definirdatos();
        const pokemonData = {
            name: data.name,
            id: data.id,
            height: data.height,
            weight: data.weight,
            type: types,
            color: color,
            abilities: abilities,
            imgn: data.sprites.front_default,
            imgc: data.sprites.front_shiny
        };

        const phpApiUrl = 'php/guardar_poquemon.php';
        const phpResponse = await fetch(phpApiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(pokemonData),
        });
        
        const phpResult = await phpResponse.text();
        console.log(phpResult);
    } catch (error) {
        
        console.error(error);
    }
}

function clearResults() {
    document.getElementById("pokemonInfo").textContent = "";
}

async function buscar(){
    const id_nombre = document.getElementById("pokemonName").value;
    const apiUrl = 'php/busqueda.php';
    
    fetch(apiUrl,{
        method: 'POST',
        body: JSON.stringify({ id_nombre: id_nombre }),
        headers: {
            'Content-Type': 'application/json'
        } 
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            verPokemon()
        } else {
            const pokemonInfo = `
                <p class="sms">Pokemon encontrado en la BD </p>
                <h2>${data.nombre}</h2>
                <h3>id: ${data.numero}</h3>
                <div>
                    <img src="${data.imgn}" alt="${data.nombre}">
                    <img src="${data.imgc}" alt="${data.nombre}">
                </div>
                <p>Altura: ${data.altura} Cm</p>
                <p>Peso: ${data.peso} Kg</p>
                <p>Categoria: ${data.categoria} </p>
                <p>Color: ${data.color}</p>
                <p>Habilidad: ${data.habilidades} </p>
            `;
            document.getElementById("pokemonInfo").innerHTML = pokemonInfo;
        }
    })
    .catch(error => {
        console.error('Error al cargar el archivo JSON:', error);
    });
}
