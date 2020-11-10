<?php

namespace App\Domain\Galerie;

use App\Domain\User\User;
use Illuminate\Database\Eloquent\Collection;
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
    static function getById(int $id)
    {
        return Galerie::where('id', '=', $id)->first();
    }

    public static function getFilter(bool $isPublic, bool $isPrivate, bool $isShare)
    {
        $query = Galerie::query();
        if($isPublic)
            $query = $query->where("isPrivate", "=", false);
        if($isPrivate)
            $query = $query->where("id_owner", "=", $_SESSION['user']->id);
        $result = $query->get();
        if($isShare)
            $result = $result->merge(Galerie::query()->join('usergalerie', 'id', '=', 'id_galerie')->where('id_user', '=', $_SESSION['user']->id)->get());
        return $result;
    }

    /**
     * @return Collection Liste des utilisateurs de la galerie
     */
    function users()
    {
        return $this->belongsToMany("App\Domain\User\User", "usergalerie", "id_galerie", "id_user")->get();
    }

    /**
     * @return Collection Liste des mots clefs de la galerie
     */
    function motsclefs()
    {
        return $this->belongsToMany("App\Domain\MotClef\MotClef", "motclefgalerie", "id_galerie", "id_mot")->get();
    }

    /**
     * @return Collection Liste des images de la galerie
     */
    function images()
    {
        return $this->belongsToMany("App\Domain\Image\Image", "imagegalerie", "id_galerie", "id_image")->get();
    }

    /**
     * @return User Créateur de la galerie
     */
    function owner()
    {
        return User::getById($this->id_owner);
    }
}