<?php

namespace App;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Usuario extends Eloquent
{
    protected $table = 'usuarios'; // nombre de la tabla
    protected $fillable = ['email','username', 'password'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
