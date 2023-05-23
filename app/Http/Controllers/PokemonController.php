<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\Type;
use App\Models\Attaque;
use App\Models\EfficaciteType;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;


class PokemonController extends Controller
{
    public function home()
    {
        $pokemons = Pokemon::distinct()->get();
        return view('home', compact('pokemons'));
    }

    public function listepokemon2()
    {
        $pokemons = Pokemon::with('types')->get();
        $types = Type::distinct()->get();
        return view('listepokemon2', compact('pokemons', 'types'));
    }
    

    public function combatpokemon1()
    {
        $salameche = Pokemon::where('nom', 'Salamèche')->first();
        $carapuce = Pokemon::where('nom', 'Carapuce')->first();

        return view('combat1', ['salameche' => $salameche, 'carapuce' => $carapuce]);
    }

    public function combatpokemon2(Request $request)
    {
        $request->validate([
            'pokemon_id' => 'required|exists:pokemon,id',
        ]);

        $chosenPokemon = Pokemon::find($request->pokemon_id);
        $randomEnemyPokemon = Pokemon::where('id', '<>', $chosenPokemon->id)->inRandomOrder()->first();

        return view('combat2_results', ['chosenPokemon' => $chosenPokemon, 'randomEnemyPokemon' => $randomEnemyPokemon]);
    }

    public function combat2Form()
    {
        $pokemons = Pokemon::all();
        return view('combat2', ['pokemons' => $pokemons]);
    }

    public function listepokemon3()
    {
        $pokemons = Pokemon::with('types','attaques')->get();
        $types = Type::distinct()->get();
        $attaques = Attaque::distinct()->get();
        return view('listepokemon3', compact('pokemons', 'types', 'attaques'));
    }

    public function listetype()
    {
        $types = Type::distinct()->get();
        return view('listetype', compact('types'));
    }

    public function listeattaque()
    {
        $attaques = Attaque::with('typeattaque')->get();
        return view('listeattaque', compact('attaques'));
    }

    //celui-ci juste pour le formulaire de choix
    public function combat3Form()
    {
        $pokemons = Pokemon::all();
        return view('combat3', ['pokemons' => $pokemons]);
    }


    public function combatpokemon3(Request $request)
    {
        $request->validate([
            'pokemon_id' => 'required|exists:pokemon,id',
        ]);
    
        $chosenPokemon = Pokemon::with('types', 'attaques')->find($request->pokemon_id);
        $randomEnemyPokemon = Pokemon::with('types', 'attaques')->where('id', '<>', $chosenPokemon->id)->inRandomOrder()->first();
    
        return view('combat3_results', ['chosenPokemon' => $chosenPokemon, 'randomEnemyPokemon' => $randomEnemyPokemon]);
    }
    
    public function combat3Attack(Request $request)
    {
        $request->validate([
            'chosen_pokemon_id' => 'required|exists:pokemon,id',
            'enemy_pokemon_id' => 'required|exists:pokemon,id',
            'attaque_id' => 'required|exists:attaque,id',
        ]);
    
        $chosenPokemon = Pokemon::with('attaques')->find($request->chosen_pokemon_id);
        $enemyPokemon = Pokemon::find($request->enemy_pokemon_id);
        $attaque = Attaque::find($request->attaque_id);
    
        if (!$chosenPokemon || !$enemyPokemon) {
            return redirect()->route('combat3.form')->withErrors(['Une erreur est survenue lors de la récupération des Pokémon. Veuillez réessayer.']);
        }

        $niveau = 100;
        $puissance = $attaque->puissance;
        $attaqueStat = $chosenPokemon->atq;
        $defenseStat = $enemyPokemon->def;
    
        $degats = ((((2 * $niveau) / 5 + 2) * $puissance * $attaqueStat / $defenseStat) / 50) + 4;
    
        $response = [
            'success' => true,
            'degats' => $degats,
            'chosen_pokemon_nom' => $chosenPokemon->nom,
            'enemy_pokemon_nom' => $enemyPokemon->nom,
            'attaque_nom' => $attaque->nom,
        ];
    
        return response()->json($response);
    }

    public function combat4Form()
    {
        $pokemons = Pokemon::all();
        return view('combat4', ['pokemons' => $pokemons]);
    }

    public function combatpokemon4(Request $request)
    {
        $request->validate([
            'pokemon_id' => 'required|exists:pokemon,id',
        ]);
    
        $chosenPokemon = Pokemon::with('types', 'attaques')->find($request->pokemon_id);
        $chosenPokemon->niveauAtq = 0;
        $chosenPokemon->niveauDef = 0;
        $chosenPokemon->niveauAtqspe = 0;
        $chosenPokemon->niveauDefspe = 0;
        $chosenPokemon->niveauVit = 0;
        $chosenPokemon->atq = $chosenPokemon->atq_base;
        $chosenPokemon->def = $chosenPokemon->def_base;
        $chosenPokemon->atqspe = $chosenPokemon->atqspe_base;
        $chosenPokemon->defspe = $chosenPokemon->defspe_base;
        $chosenPokemon->vit = $chosenPokemon->vit_base;

        $randomEnemyPokemon = Pokemon::with('types', 'attaques')->where('id', '<>', $chosenPokemon->id)->inRandomOrder()->first();
        $randomEnemyPokemon->niveauAtq = 0;
        $randomEnemyPokemon->niveauDef = 0;
        $randomEnemyPokemon->niveauAtqspe = 0;
        $randomEnemyPokemon->niveauDefspe = 0;
        $randomEnemyPokemon->niveauVit = 0;
        $randomEnemyPokemon->atq = $randomEnemyPokemon->atq_base;
        $randomEnemyPokemon->def = $randomEnemyPokemon->def_base;
        $randomEnemyPokemon->atqspe = $randomEnemyPokemon->atqspe_base;
        $randomEnemyPokemon->defspe = $randomEnemyPokemon->defspe_base;
        $randomEnemyPokemon->vit = $randomEnemyPokemon->vit_base;
        
        session(['randomEnemyPokemon' => $randomEnemyPokemon]);
        session(['randomEnemyPokemonAttacks' => $randomEnemyPokemon->attaques->random(min(4, $randomEnemyPokemon->attaques->count()))]);
        session(['chosenPokemon' => $chosenPokemon]);
        session(['chosenPokemonAttacks' => $chosenPokemon->attaques->random(min(4, $chosenPokemon->attaques->count()))]);

        return view('combat4_results', [
            'chosenPokemon' => $chosenPokemon,
            'randomEnemyPokemon' => $randomEnemyPokemon,
            'chosenPokemonAttacks' => session('chosenPokemonAttacks'),
            'randomEnemyPokemonAttacks' => session('randomEnemyPokemonAttacks'),
        ]);
        
    }

    public function combat4Attack(Request $request)
    {
        $request->validate([
            'chosen_pokemon_id' => 'required|exists:pokemon,id',
            'enemy_pokemon_id' => 'required|exists:pokemon,id',
            'attaque_id' => 'required|exists:attaque,id',
        ]);
    
        $chosenPokemon = session('chosenPokemon');
        $enemyPokemon = session('randomEnemyPokemon');
    
        $chosenPokemonAttacks = session('chosenPokemonAttacks');
        $enemyPokemonAttacks = session('randomEnemyPokemonAttacks');
        $attaque = Attaque::find($request->attaque_id);

        $degats = 0;
        $message = "";
        $message_efficace ="";
        $message_stab = "";
        $message_crit = "";
        if (strtolower($attaque->Catégorie) == 'physique') {
            $niveau = 100;
            $puissance = $attaque->puissance;
            $attaqueStat = $chosenPokemon->atq;
            $defenseStat = $enemyPokemon->def;

            $degats = round(((((2 * $niveau) / 5 + 2) * $puissance * $attaqueStat / $defenseStat) / 50) + 2);

            $typeMultiplier = $enemyPokemon->getTypeDamageMultiplier($attaque->type_id);
            if ($typeMultiplier > 1) {
                $message_efficace .= "C'est super efficace ! ";
            } else if ($typeMultiplier < 1 && $typeMultiplier >0) {
                $message_efficace .= "Ce n'est pas très efficace... ";
            } else if ($typeMultiplier === 0){
                $message_efficace .= "Ca n'affecte pas le pokemon ennemie... ";
            }

            $stabMultiplier = $this->getStab($attaque->type_id, $chosenPokemon->types);
            if ($stabMultiplier !== 1){
                $message_stab .= "Il y a bien l'utilisation du stab";
            }
            
            $criticalMultiplier = $this->isCriticalHit($chosenPokemon) ? 2 : 1;
            if($criticalMultiplier == 2){
                $message_crit .= "Coup critique !";
            }

            $degats = round($degats * $typeMultiplier * $stabMultiplier * $criticalMultiplier);
            

        } else if (strtolower($attaque->Catégorie) == 'spéciale'){
            $niveau = 100;
            $puissance = $attaque->puissance;
            $attaqueStat = $chosenPokemon->atqspe;
            $defenseStat = $enemyPokemon->defspe;

            $degats = round(((((2 * $niveau) / 5 + 2) * $puissance * $attaqueStat / $defenseStat) / 50) + 2);
            
            $typeMultiplier = $enemyPokemon->getTypeDamageMultiplier($attaque->type_id);
            if ($typeMultiplier > 1) {
                $message_efficace .= "C'est super efficace ! ";
            } else if ($typeMultiplier < 1 && $typeMultiplier >0) {
                $message_efficace .= "Ce n'est pas très efficace... ";
            } else if ($typeMultiplier === 0){
                $message_efficace .= "Ca n'affecte pas le pokemon ennemie... ";
            }
            
            $stabMultiplier = $this->getStab($attaque->type_id, $chosenPokemon->types);
            if ($stabMultiplier !== 1){
                $message_stab .= "Il y a bien l'utilisation du stab";
            }

            $criticalMultiplier = $this->isCriticalHit($chosenPokemon) ? 2 : 1;
            if($criticalMultiplier == 2){
                $message_crit .= "Coup critique !";
            }

            $degats = round($degats * $typeMultiplier * $stabMultiplier * $criticalMultiplier);
        } else if (strtolower($attaque->Catégorie) == 'statut'){
            if ($attaque->modification_attaque !== 0 || $attaque->modification_defense !== 0 || $attaque->modification_attaque_speciale !== 0 || $attaque->modification_defense_speciale !== 0 || $attaque->modification_vitesse !== 0) {
                $enemyPokemon->niveauAtq += $attaque->modification_attaque;
                $enemyPokemon->niveauAtq = max(-6, min(6, $enemyPokemon->niveauAtq));
                $enemyPokemon->atq = $this->applyStatModifier($enemyPokemon->atq_base, $enemyPokemon->niveauAtq);
            
                $enemyPokemon->niveauDef += $attaque->modification_defense;
                $enemyPokemon->niveauDef = max(-6, min(6, $enemyPokemon->niveauDef));
                $enemyPokemon->def = $this->applyStatModifier($enemyPokemon->def_base, $enemyPokemon->niveauDef);
            
                $enemyPokemon->niveauAtqspe += $attaque->modification_attaque_speciale;
                $enemyPokemon->niveauAtqspe = max(-6, min(6, $enemyPokemon->niveauAtqspe));
                $enemyPokemon->atqspe = $this->applyStatModifier($enemyPokemon->atqspe_base, $enemyPokemon->niveauAtqspe);
            
                $enemyPokemon->niveauDefspe += $attaque->modification_defense_speciale;
                $enemyPokemon->niveauDefspe = max(-6, min(6, $enemyPokemon->niveauDefspe));
                $enemyPokemon->defspe = $this->applyStatModifier($enemyPokemon->defspe_base, $enemyPokemon->niveauDefspe);
            
                $enemyPokemon->niveauVit += $attaque->modification_vitesse;
                $enemyPokemon->niveauVit = max(-6, min(6, $enemyPokemon->niveauVit));
                $enemyPokemon->vit = $this->applyStatModifier($enemyPokemon->vit_base, $enemyPokemon->niveauVit);

                $chosenPokemon->niveauAtq += $attaque->modification_attaque_allie;
                $chosenPokemon->niveauAtq = max(-6, min(6, $chosenPokemon->niveauAtq));
                $chosenPokemon->atq = $this->applyStatModifier($chosenPokemon->atq_base, $chosenPokemon->niveauAtq);
                
                $chosenPokemon->niveauDef += $attaque->modification_defense_allie;
                $chosenPokemon->niveauDef = max(-6, min(6, $chosenPokemon->niveauDef));
                $chosenPokemon->def = $this->applyStatModifier($chosenPokemon->def_base, $chosenPokemon->niveauDef);
                
                $chosenPokemon->niveauAtqspe += $attaque->modification_attaque_speciale_allie;
                $chosenPokemon->niveauAtqspe = max(-6, min(6, $chosenPokemon->niveauAtqspe));
                $chosenPokemon->atqspe = $this->applyStatModifier($chosenPokemon->atqspe_base, $chosenPokemon->niveauAtqspe);
                
                $chosenPokemon->niveauDefspe += $attaque->modification_defense_speciale_allie;
                $chosenPokemon->niveauDefspe = max(-6, min(6, $chosenPokemon->niveauDefspe));
                $chosenPokemon->defspe = $this->applyStatModifier($chosenPokemon->defspe_base, $chosenPokemon->niveauDefspe);
                
                $chosenPokemon->niveauVit += $attaque->modification_vitesse_allie;
                $chosenPokemon->niveauVit = max(-6, min(6, $chosenPokemon->niveauVit));
                $chosenPokemon->vit = $this->applyStatModifier($chosenPokemon->vit_base, $chosenPokemon->niveauVit);
            }        
            if ($attaque->modification_attaque !== 0) {
                $message .= "L'attaque de {$enemyPokemon->nom} a été modifiée de {$attaque->modification_attaque}. ";
            }
            if ($attaque->modification_defense !== 0) {
                $message .= "La défense de {$chosenPokemon->nom} a été modifiée de {$attaque->modification_defense}. ";
            }
            if ($attaque->modification_attaque_speciale !== 0) {
                $message .= "L'attaque spéciale de {$chosenPokemon->nom} a été modifiée de {$attaque->modification_attaque_speciale}. ";
            }
            if ($attaque->modification_defense_speciale !== 0) {
                $message .= "La défense spéciale de {$chosenPokemon->nom} a été modifiée de {$attaque->modification_defense_speciale}. ";
            }
            if ($attaque->modification_vitesse !== 0) {
                $message .= "La vitesse de {$chosenPokemon->nom} a été modifiée de {$attaque->modification_vitesse}. ";
            }

        }

        $chosenPokemon->except('selected_attacks')->save();
        $chosenPokemon->except('selected_attacks')->save();
        $response = [
            'message_crit' => $message_crit,
            'message_efficace' => $message_efficace,
            'message_stab' => $message_stab,
            'message' => $message,
            'success' => true,
            'degats' => $degats,
            'chosen_pokemon_nom' => $chosenPokemon->nom,
            'enemy_pokemon_nom' => $enemyPokemon->nom,
            'attaque_nom' => $attaque->nom,
            'stat_changes' => [
                'chosen_pokemon' => [
                    'atq' => $chosenPokemon->atq,
                    'def' => $chosenPokemon->def,
                    'atqspe' => $chosenPokemon->atqspe,
                    'defspe' => $chosenPokemon->defspe,
                    'vit' => $chosenPokemon->vit,
                ],
                'enemy_pokemon' => [
                    'atq' => $enemyPokemon->atq,
                    'def' => $enemyPokemon->def,
                    'atqspe' => $enemyPokemon->atqspe,
                    'defspe' => $enemyPokemon->defspe,
                    'vit' => $enemyPokemon->vit,
                ],
                'stat_levels' => [
                    'enemy_pokemon' => [
                        'niveauAtq' => $enemyPokemon->niveauAtq,
                        'niveauDef' => $enemyPokemon->niveauDef,
                        'niveauAtqspe' => $enemyPokemon->niveauAtqspe,
                        'niveauDefspe' => $enemyPokemon->niveauDefspe,
                        'niveauVit' => $enemyPokemon->niveauVit,
                    ],
                    'chosen_pokemon' => [
                        'niveauAtq' => $chosenPokemon->niveauAtq,
                        'niveauDef' => $chosenPokemon->niveauDef,
                        'niveauAtqspe' => $chosenPokemon->niveauAtqspe,
                        'niveauDefspe' => $chosenPokemon->niveauDefspe,
                        'niveauVit' => $chosenPokemon->niveauVit,
                    ]
                ]
            ],
        ];
        return response()->json($response);
    }

    function applyStatModifier($baseStat, $modifier) {
        if ($modifier == 0) {
            return $baseStat;
        } elseif ($modifier > 0) {
            return round($baseStat * (2 + $modifier) / 2);
        } else {
            return round($baseStat * 2 / (2 - $modifier));
        }
    }

    function getTypeDamageMultiplier($attackTypeId, $defenderType1Id, $defenderType2Id = null)
    {
        $typeChart = EfficaciteType::all()
            ->mapWithKeys(function ($efficacite) {
                return [[$efficacite->attaque_type_id, $efficacite->defense_type_id] => $efficacite->multiplicateur];
            })
            ->all();
    
        $multiplier = $typeChart[$attackTypeId][$defenderType1Id] ?? 1;
    
        if ($defenderType2Id) {
            $multiplier *= $typeChart[$attackTypeId][$defenderType2Id] ?? 1;
        }
    
        return $multiplier;
    }

    function getStab($attackTypeId, $pokemonTypes) {
        foreach($pokemonTypes as $pokemonType) {
            if($attackTypeId == $pokemonType->id) {
                return 1.5;
            }
        }
        return 1;
    }

    function isCriticalHit($pokemon) {
        $criticalHitProbabilities = [
            1 => 1/16,
            2 => 1/8,
            3 => 1/4,
            4 => 1/3,
            5 => 1/2
        ];
        // Génère un nombre aléatoire entre 0 et 1
        $randomNumber = mt_rand() / mt_getrandmax();
        // Compare le nombre aléatoire à la probabilité de coup critique du Pokémon
        return $randomNumber < $criticalHitProbabilities[$pokemon->niveau_coup_critique];
    }
    
}
?>