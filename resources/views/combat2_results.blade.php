<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combat 2 battle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <h1>Pokémon adverse : {{ $randomEnemyPokemon->nom }}</h1>
    <p id="ennemie-pv">Pv : {{ $randomEnemyPokemon->pv }}</p>
    <p id="ennemie-atq">Atq : {{ $randomEnemyPokemon->atq }}</p>
    <p id="ennemie-def">Def : {{ $randomEnemyPokemon->def }}</p>
    <p id="ennemie-atqspe">Atqspe : {{ $randomEnemyPokemon->atqspe }}</p>
    <p id="ennemie-defspe">Defspe : {{ $randomEnemyPokemon->defspe }}</p>
    <p id="ennemie-vit">Vit : {{ $randomEnemyPokemon->vit }}</p>

    <button id="attack-btn" class="btn btn-danger">Attaquer</button>
    <p id="win-message" style="display: none;"> {{ $chosenPokemon->nom }} a gagné !</p>

    <script>
        const attackButton = document.getElementById('attack-btn');
        const ennemiePvElement = document.getElementById('ennemie-pv');
        const winMessageElement = document.getElementById('win-message');

        attackButton.addEventListener('click', () => {
            let ennemiePv = parseInt(ennemiePvElement.textContent.split(' ')[2]);
            ennemiePv -= 40;

            if (ennemiePv < 0) {
                ennemiePv = 0;
            }

            ennemiePvElement.textContent = 'Pv : ' + ennemiePv;

            if (ennemiePv=== 0) {
                winMessageElement.style.display = 'block';
            }
        });
    </script>
</body>
</html>
