<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$capsule = new Capsule;

if (is_array($bddConfig = parse_ini_file('./config/bdd.ini')))
    $capsule->addConnection($bddConfig);
else {
    echo "ERREUR : Fichier de configuration de la base de donnée introuvable";
    exit();
}

// Make this Capsule instance available globally
$capsule->setAsGlobal();

// Setup the Eloquent ORM.
$capsule->bootEloquent();

Capsule::schema()->create('user', function ($table) {
    $table->increments('id');
    $table->string('identifiant')->unique();
    $table->string('email')->unique();
    $table->string('password');
    $table->timestamps();
});

Capsule::schema()->create('galerie', function ($table) {
    $table->increments('id');
    $table->boolean('isPrivate');
    $table->string('nom');
    $table->string('description');
    $table->integer('id_owner')->unsigned();
    $table->foreign('id_owner')->references('id')->on('user')->onDelete('cascade');
    $table->timestamps();
});

Capsule::schema()->create('usergalerie', function ($table) {
    $table->integer('id_user')->unsigned();
    $table->integer('id_galerie')->unsigned();
    $table->boolean('canModify');
    $table->foreign('id_user')->references('id')->on('user')->onDelete('cascade');
    $table->foreign('id_galerie')->references('id')->on('galerie')->onDelete('cascade');
    $table->timestamps();
});

Capsule::schema()->create('image', function ($table) {
    $table->increments('id');
    $table->string('url')->unique();
    $table->string('titre');
    $table->string('description');
    $table->timestamps();
});

Capsule::schema()->create('imagegalerie', function ($table) {
    $table->integer('id_galerie')->unsigned();
    $table->integer('id_image')->unsigned();
    $table->foreign('id_galerie')->references('id')->on('galerie')->onDelete('cascade');
    $table->foreign('id_image')->references('id')->on('image')->onDelete('cascade');
    $table->timestamps();
});

Capsule::schema()->create('motclef', function ($table) {
    $table->increments('id');
    $table->string('mot')->unique();
    $table->timestamps();
});

Capsule::schema()->create('motclefimage', function ($table) {
    $table->integer('id_mot')->unsigned();
    $table->integer('id_image')->unsigned();
    $table->foreign('id_mot')->references('id')->on('motclef')->onDelete('cascade');
    $table->foreign('id_image')->references('id')->on('image')->onDelete('cascade');
    $table->timestamps();
});

Capsule::schema()->create('motclefgalerie', function ($table) {
    $table->integer('id_mot')->unsigned();
    $table->integer('id_galerie')->unsigned();
    $table->foreign('id_mot')->references('id')->on('motclef')->onDelete('cascade');
    $table->foreign('id_galerie')->references('id')->on('galerie')->onDelete('cascade');
    $table->timestamps();
});