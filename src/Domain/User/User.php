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
     * Liste des colones à caché en cas de conversion en String / JSON
     *
     * @var array
     */
    protected $hidden = ['password'];

}