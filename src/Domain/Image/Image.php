<?php


namespace App\Domain\Image;


use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $colonne, string $comparateur, mixed $valeur)
 * @method static find(int $id)
 */
class Image extends Model
{
    /**
     * Nom de la table
     */
    protected $table = 'image';

    /**
     * Nom de la primary key
     */
    protected $primaryKey = 'id';

    /**
     * Liste des colones modifiables
     *
     * @var array
     */
    protected $fillable = ['url', 'titre', 'description'];

    /**
     * Liste des colones à cacher en cas de conversion en String / JSON
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @param int $id Id de l' image
     * @return Image Image correspondant à l'id passé en paramètre
     */
    static function getById(int $id): Image
    {
        return Image::find($id)->get();
    }
}