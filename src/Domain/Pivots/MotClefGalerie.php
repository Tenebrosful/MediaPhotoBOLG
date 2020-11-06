<?php


namespace App\Domain\Pivots;


use Illuminate\Database\Eloquent\Relations\Pivot;

class MotClefGalerie extends Pivot
{
    /**
     * Nom de la table
     */
    protected $table = 'motclefgalerie';

    /**
     * Nom de la primary key
     */
    protected $primaryKey = [
        'id_mot',
        'id_galerie'
    ];

    protected $incrementing = false;

    /**
     * Liste des colones modifiables
     *
     * @var array
     */
    protected $fillable = [
        'id_mot',
        'id_galerie'
    ];

    /**
     * Liste des colones à cacher en cas de conversion en String / JSON
     *
     * @var array
     */
    protected $hidden = [];
}