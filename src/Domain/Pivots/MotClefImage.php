<?php


namespace App\Domain\Pivots;


use Illuminate\Database\Eloquent\Relations\Pivot;

class MotClefImage extends Pivot
{
    /**
     * Nom de la table
     */
    protected $table = 'motclefimage';

    /**
     * Nom de la primary key
     */
    protected $primaryKey = [
        'id_mot',
        'id_image'
    ];

    protected $incrementing = false;

    /**
     * Liste des colones modifiables
     *
     * @var array
     */
    protected $fillable = [
        'id_mot',
        'id_image'
    ];

    /**
     * Liste des colones à cacher en cas de conversion en String / JSON
     *
     * @var array
     */
    protected $hidden = [];
}