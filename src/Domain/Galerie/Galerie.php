<?php

namespace App\Domain\Galerie;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $colonne, string $comparateur, mixed $valeur)
 * @method static find(int $id)
 */
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

    /**
     * @param int $id Id de la galerie
     * @return Galerie Galerie correspondant à l'id passé en paramètre
     */
    static function getById(int $id): Galerie
    {
        return Galerie::find($id)->get();
    }
}