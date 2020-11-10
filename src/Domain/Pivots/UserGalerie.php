<?php


namespace App\Domain\Pivots;


use Illuminate\Database\Eloquent\Relations\Pivot;

class UserGalerie extends Pivot
{
    /**
     * Nom de la table
     */
    protected $table = 'usergalerie';

    /**
     * Nom de la primary key
     */
    protected $primaryKey = [
        'id_user',
        'id_galerie'
    ];

    protected $incrementing = false;

    /**
     * Liste des colones modifiables
     *
     * @var array
     */
    protected $fillable = [
        'id_user',
        'id_galerie',
        'canModify'
    ];

    /**
     * Liste des colones à cacher en cas de conversion en String / JSON
     *
     * @var array
     */
    protected $hidden = [];
}