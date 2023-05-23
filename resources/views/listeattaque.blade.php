<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <title>Liste type</title>
</head>
<body>
    
    @include('partials.navbar')
    <h2>Liste des attaques</h2>
    <ul>
        @foreach($attaques as $attaque)
        <strong>{{ $attaque->nom }}</strong><br>
        Puissance: {{ $attaque->puissance }}<br>
        Précision: {{ $attaque->précision }}<br>
        Type_id: {{ $attaque->typeattaque->nom }}<br>
        Description: {{ $attaque->description }}<br>
        PP: {{ $attaque->PP }}<br>
        Catégorie: {{ $attaque->Catégorie }}<br><br>
        @endforeach
    </ul>
</body>
<footer>
</footer>
</html>