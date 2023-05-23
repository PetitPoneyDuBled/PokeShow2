<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <title>Combat1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')
    <h1>Combat de Pokémon</h1>
    <div>
        <h2>Salameche</h2>
        <p id="salameche-pv">Pv : {{ $salameche->pv }}</p>
        <p id="salameche-atq">Atq : {{ $salameche->atq }}</p>
        <p id="salameche-def">Def : {{ $salameche->def }}</p>
        <p id="salameche-atqspe">Atqspe : {{ $salameche->atqspe }}</p>
        <p id="salameche-defspe">Defspe : {{ $salameche->defspe }}</p>
        <p id="salameche-pv">Vit : {{ $salameche->vit }}</p>
    </div>
    <h1>Contre</h1>
    <div>
    <h2>Carapuce</h2>
        <p id="carapuce-pv">Pv : {{ $carapuce->pv }}</p>
        <p id="carapuce-atq">Atq : {{ $carapuce->atq }}</p>
        <p id="carapuce-def">Def : {{ $carapuce->def }}</p>
        <p id="carapuce-atqspe">Atqspe : {{ $carapuce->atqspe }}</p>
        <p id="carapuce-defspe">Defspe : {{ $carapuce->defspe }}</p>
        <p id="carapuce-pv">Vit : {{ $carapuce->vit }}</p>
    </div>
    
    <button id="attack-btn" class="btn btn-danger">Attaquer</button>
    <p id="win-message" style="display: none;">Salameche a gagné !</p>

    <script>
        const attackButton = document.getElementById('attack-btn');
        const carapucePvElement = document.getElementById('carapuce-pv');
        const winMessageElement = document.getElementById('win-message');

        attackButton.addEventListener('click', () => {
            let carapucePv = parseInt(carapucePvElement.textContent.split(' ')[2]);
            carapucePv -= 40;

            if (carapucePv < 0) {
                carapucePv = 0;
            }

            carapucePvElement.textContent = 'Pv : ' + carapucePv;

            if (carapucePv === 0) {
                winMessageElement.style.display = 'block';
            }
        });
    </script>
</body>
</html>
