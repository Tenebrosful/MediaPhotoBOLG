<?php

namespace App\Domain\Galerie;

use Illuminate\Database\Eloquent\Model;

class Galerie extends Model
{
    /**
     * Nom de la table
     */
    protected $table = 'galerie';

    /**
     * Nom de la primary key
     */
    protected $primaryKey = 'id';

    /**
     * Liste des colones modifiables
     *
     * @var array
     */
    protected $fillable = ['nom', 'description', 'id_owner', 'isPrivate'];

    /**
     * Liste des colones à cacher en cas de conversion en String / JSON
     *
     * @var array
     */
    protected $hidden = [];
}