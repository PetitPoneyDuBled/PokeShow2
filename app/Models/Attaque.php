<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attaque extends Model
{
    use HasFactory;

    protected $table = 'attaque';
    protected $primaryKey = 'id';

    public $timestamps = false;

    public function types()
    {
        return $this->belongsToMany(Type::class, 'pokemon_type', 'pokemon_id', 'type_id');
    }

    public function typeattaque()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

}
?>