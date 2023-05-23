<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <title>Liste pokemon 3</title>
</head>
<body>
    
    @include('partials.navbar')
    <h1>Liste pokemon 3</h1>
    <ul>
    @foreach($pokemons as $pokemon)
        <li>
            <strong>{{ $pokemon->nom }}</strong><br>
            Pv: {{ $pokemon->pv }}<br>
            Atq: {{ $pokemon->atq }}<br>
            Def: {{ $pokemon->def }}<br>
            Atqspe: {{ $pokemon->atqspe }}<br>
            Defspe: {{ $pokemon->defspe }}<br>
            Vit: {{ $pokemon->vit }}<br>
            Types :
            <ul>
                @foreach($pokemon->types as $type)
                    <li>
                        {{ $type->nom }}
                    </li>
                @endforeach
            </ul>
            Attaques :
            <ul>
                @foreach($pokemon->attaques as $attaque)
                    <li>
                        {{ $attaque->nom }}
                    </li>
                @endforeach
            </ul>
            </li>
        @endforeach
    </ul>
</body>
<footer>
</footer>
</html>
