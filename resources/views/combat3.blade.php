<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combat 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')
    <h1>Choisissez votre Pokémon</h1>

    @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('combat3') }}" method="POST" target="_blank">
        @csrf
        <select name="pokemon_id" required>
            <option value="">Sélectionnez un Pokémon</option>
            @foreach($pokemons as $pokemon)
                <option value="{{ $pokemon->id }}">{{ $pokemon->nom }}</option>
            @endforeach
        </select>
        <button type="submit">Démarrer le combat</button>
    </form>
</body>
</html>