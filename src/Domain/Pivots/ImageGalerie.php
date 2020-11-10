<?php


namespace App\Domain\Pivots;


use Illuminate\Database\Eloquent\Relations\Pivot;

class ImageGalerie extends Pivot
{
    /**
     * Nom de la table
     */
    protected $table = 'imagegalerie';

    /**
     * Nom de la primary key
     */
    protected $primaryKey = [
        'id_galerie',
        'id_image'
    ];

    public $incrementing = false;

    /**
     * Liste des colones modifiables
     *
     * @var array
     */
    protected $fillable = [
        'id_galerie',
        'id_image'
    ];

    /**
     * Liste des colones à cacher en cas de conversion en String / JSON
     *
     * @var array
     */
    protected $hidden = [];
}