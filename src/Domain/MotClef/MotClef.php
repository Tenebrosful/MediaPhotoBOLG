<?php


namespace App\Domain\MotClef;


use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $colonne, string $comparateur, mixed $valeur)
 * @method static find(int $id)
 */
class MotClef extends Model
{
    /**
     * Nom de la table
     */
    protected $table = 'motclef';

    /**
     * Nom de la primary key
     */
    protected $primaryKey = 'id';

    /**
     * Liste des colones modifiables
     *
     * @var array
     */
    protected $fillable = ['mot'];

    /**
     * Liste des colones à cacher en cas de conversion en String / JSON
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @param int $id Id du mot clef
     * @return MotClef Mot clef correspondant à l'id passé en paramètre
     */
    static function getById(int $id): MotClef
    {
        return MotClef::find($id)->get();
    }
}