<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combat 4 battle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    @include('partials.navbar')
    <h1>Votre Pokémon : {{ $chosenPokemon->nom }}</h1>
    <p id="allie-pv">Pv : {{ $chosenPokemon->pv }}</p>
    <p id="allie-atq">Atq : {{ $chosenPokemon->atq }}</p>
    <p id="allie-def">Def : {{ $chosenPokemon->def }}</p>
    <p id="allie-atqspe">Atqspe : {{ $chosenPokemon->atqspe }}</p>
    <p id="allie-defspe">Defspe : {{ $chosenPokemon->defspe }}</p>
    <p id="allie-vit">Vit : {{ $chosenPokemon->vit }}</p>
    Attaques :
    <ul>
        @foreach($chosenPokemonAttacks as $attaque)
            <li>
                {{ $attaque->nom }}
            </li>
        @endforeach
    </ul>

    <div class="container">
        <h1>Combat entre {{ $chosenPokemon->nom }} et {{ $randomEnemyPokemon->nom }}</h1>

        <form action="{{ route('combat4.attack') }}" method="POST" id="attack-form">
            @csrf
            <input type="hidden" name="chosen_pokemon_id" value="{{ $chosenPokemon->id }}">
            <input type="hidden" name="enemy_pokemon_id" value="{{ $randomEnemyPokemon->id }}">

            <label for="attaque_id">Choisissez une attaque pour {{ $chosenPokemon->nom }} :</label>
            <select name="attaque_id" id="attaque_id">
                @foreach($chosenPokemonAttacks as $attaque)
                    <option value="{{ $attaque->id }}">{{ $attaque->nom }}</option>
                @endforeach
            </select>


            <button type="submit">Attaquer</button>
        </form>

        @if (session('degats'))
            <div>
                <p>{{ $chosenPokemon->nom }} a infligé {{ session('degats') }} dégâts à {{ $randomEnemyPokemon->nom }} avec l'attaque {{ session('attaque_nom') }} !</p>
            </div>
        @endif
    </div>

    <h1>Pokémon adverse : {{ $randomEnemyPokemon->nom }}</h1>
    <p id="ennemie-pv">Pv : {{ $randomEnemyPokemon->pv }}</p>
    <p id="ennemie-atq">Atq : {{ $randomEnemyPokemon->atq }}</p>
    <p id="ennemie-def">Def : {{ $randomEnemyPokemon->def }}</p>
    <p id="ennemie-atqspe">Atqspe : {{ $randomEnemyPokemon->atqspe }}</p>
    <p id="ennemie-defspe">Defspe : {{ $randomEnemyPokemon->defspe }}</p>
    <p id="ennemie-vit">Vit : {{ $randomEnemyPokemon->vit }}</p>

    Attaques :
    <ul>
        @foreach($randomEnemyPokemonAttacks as $attaque)
            <li>
                {{ $attaque->nom }}
            </li>
        @endforeach
    </ul>


    <script>

    function updateStats(idPrefix, stats) {
        document.getElementById(`${idPrefix}-atq`).textContent = `Atq : ${stats.atq}`;
        document.getElementById(`${idPrefix}-def`).textContent = `Def : ${stats.def}`;
        document.getElementById(`${idPrefix}-atqspe`).textContent = `Atqspe : ${stats.atqspe}`;
        document.getElementById(`${idPrefix}-defspe`).textContent = `Defspe : ${stats.defspe}`;
        document.getElementById(`${idPrefix}-vit`).textContent = `Vit : ${stats.vit}`;
    }
    
    document.getElementById('attack-form').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);
        let url = this.getAttribute('action');

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error ${response.status}`);
            }
            return response.text();
        })
        .then(text => {
            try {
                return JSON.parse(text);
            } catch (error) {
                console.error("Erreur lors de la conversion de la réponse en JSON :", error);
                console.log("Réponse brute du serveur :", text);
                throw error;
            }
        })
        .then(data => {
            if (data.success) {
                let ennemiePvElement = document.getElementById('ennemie-pv');
                let ennemiePv = parseInt(ennemiePvElement.textContent.split(' ')[2]) - data.degats;
                ennemiePvElement.textContent = `Pv : ${Math.max(ennemiePv, 0)}`;
                let Msgefficace = data.message_efficace ? `${data.message_efficace} ` : "";
                let Msgstab = data.message_stab ? `${data.message_stab} ` : "";
                let Msgcrit = data.message_crit ? `${data.message_crit} ` : "";
                updateStats('allie', data.stat_changes.chosen_pokemon);
                updateStats('ennemie', data.stat_changes.enemy_pokemon);
                if (data.degats > 0) {
                    alert(`${data.chosen_pokemon_nom} a infligé ${data.degats} dégâts à ${data.enemy_pokemon_nom} avec l'attaque ${data.attaque_nom} ! Les statistiques ont été mises à jour.`);
                    if (Msgstab != "")
                        alert(Msgstab);
                    if (Msgefficace != "")
                        alert(Msgefficace);
                    if (Msgcrit != "")
                        alert(Msgcrit);
                }
                if (data.message) {
                    alert("Vous avez utilisé une attaque de statut !");
                    alert(data.message);
                }
                if (data.stat_changes.stat_levels.enemy_pokemon.niveauAtq === -6) {
                    alert("L'attaque de l'adversaire ne peut plus être diminuée !");
                } else if (data.stat_changes.stat_levels.enemy_pokemon.niveauAtq === 6) {
                    alert("L'attaque de l'adversaire ne peut plus être augmentée !");
                } else if(data.stat_changes.stat_levels.enemy_pokemon.niveauDef === -6) {
                    alert("La défense de l'adversaire ne peut plus être diminuée !");
                } else if (data.stat_changes.stat_levels.enemy_pokemon.niveauDef === 6) {
                    alert("La défense de l'adversaire ne peut plus être augmentée !");
                } else if (data.stat_changes.stat_levels.enemy_pokemon.niveauAtqspe === 6){
                    alert("L'attaque spéciale de l'adversaire ne peut plus être augmentée !");
                } else if (data.stat_changes.stat_levels.enemy_pokemon.niveauAtqspe === -6){
                    alert("L'attaque spéciale de l'adversaire ne peut plus être diminuée !");
                } else if (data.stat_changes.stat_levels.enemy_pokemon.niveauDefspe === -6){
                    alert("La défense spéciale de l'adversaire ne peut plus être diminuée !");
                } else if (data.stat_changes.stat_levels.enemy_pokemon.niveauDefspe === 6){
                    alert("La défense spéciale de l'adversaire ne peut plus être augmentée !");
                } else if(data.stat_changes.stat_levels.enemy_pokemon.niveauVit === -6) {
                    alert("La vitesse de l'adversaire ne peut plus être diminuée !");
                } else if(data.stat_changes.stat_levels.enemy_pokemon.niveauAtqspe === 6) {
                    alert("La vitesse de l'adversaire ne peut plus être augmentée !");
                } else if(data.stat_changes.stat_levels.chosen_pokemon.niveauAtq === -6) {
                    alert("L'attaque de ton Pokémon ne peut plus être diminuée !");
                } else if(data.stat_changes.stat_levels.chosen_pokemon.niveauAtq === 6) {
                    alert("L'attaque de ton Pokémon ne peut plus être augmentée !")
                } else if(data.stat_changes.stat_levels.chosen_pokemon.niveauDef === -6) {
                    alert("La défense de ton Pokémon ne peut plus être diminuée !");
                } else if(data.stat_changes.stat_levels.chosen_pokemon.niveauDef === 6) {
                    alert("La défense de ton Pokémon ne peut plus être augmentée !");
                } else if(data.stat_changes.stat_levels.chosen_pokemon.niveauAtqspe === -6) {
                    alert("L'attaque spéciale de ton Pokémon ne peut plus être diminuée !");
                } else if(data.stat_changes.stat_levels.chosen_pokemon.niveauAtqspe === 6) {
                    alert("L'attaque spéciale de ton Pokémon ne peut plus être augmentée !");
                } else if(data.stat_changes.stat_levels.chosen_pokemon.niveauDefspe === -6) {
                    alert("La défense spéciale de ton Pokémon ne peut plus être diminuée !");
                } else if(data.stat_changes.stat_levels.chosen_pokemon.niveauDefspe === 6) {
                    alert("La défense spéciale de ton Pokémon ne peut plus être augmentée !");
                } else if(data.stat_changes.stat_levels.chosen_pokemon.niveauVit === -6) {
                    alert("La vitesse de ton Pokémon ne peut plus être diminuée !");
                } else if(data.stat_changes.stat_levels.chosen_pokemon.niveauAtqspe === 6) {
                    alert("La vitesse de ton Pokémon ne peut plus être augmentée !");
                } 
            } else {
                alert('Une erreur est survenue. Veuillez réessayer.');
            }
        });
});
</script>
</body>
</html>