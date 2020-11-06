<?php

namespace App\Domain\User;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $colonne, string $comparateur, mixed $valeur)
 * @method static find(int $id)
 */
class User extends Model
{
    /**
     * Nom de la table
     */
    protected $table = 'user';

    /**
     * Nom de la primary key
     */
    protected $primaryKey = 'id';

    /**
     * Liste des colones modifiables
     *
     * @var array
     */
    protected $fillable = ['email', 'password'];

    /**
     * Liste des colones à cacher en cas de conversion en String / JSON
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * @param int $id Id de l'utilisateur
     * @return User Utilisateur correspondant à l'id passé en paramètre
     */
    static function getById(int $id): User
    {
        return User::find($id)->get();
    }

    /**
     * @param string $identifiant Identifiant de l'utilisateur
     * @return User Utilisateur correspondant (l'identifiant étant unique dans la bdd)
     */
    static function getByIdentifiant(string $identifiant): User
    {
        return User::where("identifiant", "=", $identifiant)->get();
    }

    /**
     * @param string $email Email de l'utilisateur
     * @return User Utilisateur correspondant (l'email étant unique dans la bdd)
     */
    static function getByEmail(string $email): User
    {
        return User::where("email", "=", $email)->get();
    }
}