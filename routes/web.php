<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;
use Illuminate\Support\Facades\Log;


Route::get('/', [PokemonController::class, 'home']);

Route::get('/combat1', [PokemonController::class, 'combatpokemon1'])->name('combat1');

Route::post('/combat2', [PokemonController::class, 'combatpokemon2'])->name('combat2');
Route::get('/combat2', [PokemonController::class, 'combat2Form'])->name('combat2_form');

Route::get('/listepokemon2', [PokemonController::class, 'listepokemon2'])->name('listepokemon2');

Route::get('/listepokemon3', [PokemonController::class, 'listepokemon3'])->name('listepokemon3');

Route::get('/listetype', [PokemonController::class, 'listetype'])->name('listetype');

Route::get('/listeattaque', [PokemonController::class, 'listeattaque'])->name('listeattaque');

Route::get('/combat3', [PokemonController::class, 'combat3Form'])->name('combat3');
Route::post('/combat3', [PokemonController::class, 'combatpokemon3'])->name('combat3');

Route::post('/combat3/attack', [PokemonController::class, 'combat3Attack'])->name('combat3.attack');
Route::get('/combat3/results', [PokemonController::class, 'combatpokemon3'])->name('combat3.results');

Route::get('/combat4', [PokemonController::class, 'combat4Form'])->name('combat4');
Route::post('/combat4', [PokemonController::class, 'combatpokemon4'])->name('combat4');

Route::post('/combat4/attack', [PokemonController::class, 'combat4Attack'])->name('combat4.attack');
Route::get('/combat4/results', [PokemonController::class, 'combatpokemon4'])->name('combat4.results');

Route::get('/trigger-error', function () {
    Log::error('Erreur volontaire pour tester les journaux.');
    return response('Erreur volontaire déclenchée. Vérifiez les journaux pour voir si cela a été enregistré.');
});
?>