<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Type;

class Pokemon extends Model
{
    use HasFactory;

    protected $table = 'pokemon';
    protected $primaryKey = 'id';
    
    protected $attributes = [
        'niveauAtq' => 0,
        'niveauDef' => 0,
        'niveauAtqspe' => 0,
        'niveauDefspe' => 0,
        'niveauVit' => 0,
    ];

    public $timestamps = false;

    public $base_hp;
    public $base_attack;
    public $base_defense;
    public $base_sp_attack;
    public $base_sp_defense;
    public $base_speed;

    public function types()
    {
        return $this->belongsToMany(Type::class, 'pokemon_type', 'pokemon_id', 'type_id');
    }

    public function attaques()
    {
        return $this->belongsToMany(Attaque::class, 'pokemon_attaque', 'pokemon_id', 'attaque_id');
    }

    public function getTypeDamageMultiplier($attackTypeId) {
        $defenderType1Id = $this->types[0]->id;
        $defenderType2Id = isset($this->types[1]) ? $this->types[1]->id : null;
    
        $typeChart = \App\Models\EfficaciteType::getTypeChart();
    
        $multiplier = $typeChart[$attackTypeId][$defenderType1Id] ?? 1;
    
        if ($defenderType2Id) {
            $multiplier *= $typeChart[$attackTypeId][$defenderType2Id] ?? 1;
        }
    
        return $multiplier;
    }
    
}