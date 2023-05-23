<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">Pokemon Showdown</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Liste Pokémon</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('combat1') }}">Combat 1</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('combat2') }}">Combat 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('listepokemon2') }}">Liste pokémon 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('listepokemon3') }}">Liste pokémon 3</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('listetype') }}">Liste type</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('listeattaque') }}">Liste attaque</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('combat3') }}">Combat 3</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('combat4') }}">Combat 4</a>
                </li>
            </ul>
        </div>
    </div>
</nav>