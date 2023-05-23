<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EfficaciteType extends Model
{
    protected $table = 'efficacite_type';
    public $timestamps = false;

    public static function getTypeChart() {
        $typeChart = array();
        $allEfficaciteTypes = self::all();

        foreach ($allEfficaciteTypes as $efficaciteType) {
            $typeChart[$efficaciteType->attaque_type_id][$efficaciteType->defense_type_id] = $efficaciteType->multiplicateur;
        }

        return $typeChart;
    }
}