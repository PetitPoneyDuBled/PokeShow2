<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $table = 'type';
    protected $primaryKey = 'id';

    public $timestamps = false;

    public function types()
    {
        return $this->belongsToMany(Pokemon::class, 'pokemon_type', 'pokemon_id', 'type_id');
    }
}
?>