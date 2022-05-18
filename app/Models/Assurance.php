<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone_number',
        'nni',
        'birthdate',
        'n_permis',
        'duration',
        'vehicule_brand',
        'vehicule_model',
        'vehicule_type',
        'vehicule_color',
        'vehicule_chassis',
        'vehicule_matricule',
        'vehicule_first_use_date',
        'vehicule_power',
        'payment',
    ];
}
