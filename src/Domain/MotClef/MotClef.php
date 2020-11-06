<?php


namespace App\Domain\MotClef;


use Illuminate\Database\Eloquent\Collection;
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

    /**
     * @return Collection Liste des galeries ayant le mot clef
     */
    function galeries()
    {
        return $this->belongsToMany("App\Domain\Galerie\Galerie", "motclefgalerie", "id_mot", "id_galerie")->get();
    }

    /**
     * @return Collection Liste des images ayant le mot clef
     */
    function images()
    {
        return $this->belongsToMany("App\Domain\Image\Image", "motclefimage", "id_mot", "id_image")->get();
    }

}