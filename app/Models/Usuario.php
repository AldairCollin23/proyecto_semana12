<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Usuario
 * @package App\Models
 * @version October 21, 2021, 2:21 am UTC
 *
 * @property string $nombre
 * @property string $usuario
 */
class Usuario extends Model
{
    //
     //use SoftDeletes;

     public $table = 'usuario';
     protected $primaryKey= 'idusuario';
     public $timestamps =false;
 
     
     const CREATED_AT = 'created_at';
     const UPDATED_AT = 'updated_at';
 
 
     protected $dates = ['deleted_at'];
 
 
 
     public $fillable = [
         'nombre',
         'apellido',
         'usuario',
         'password'
     ];
 
     /**
      * The attributes that should be casted to native types.
      *
      * @var array
      */
     protected $casts = [
         'idusuario' => 'integer',
         'nombre' => 'string',
         'apellido' => 'string',
         'usuario' => 'string',
         'password' => 'string'
     ];
 
     /**
      * Validation rules
      *
      * @var array
      */
     public static $rules = [
         'nombre' => 'nullable|string|max:45',
         'apellido' => 'nullable|string|max:45',
         'usuario' => 'nullable|string|max:45',
         'password' => 'nullable|string|max:45'
         
     ];
}
