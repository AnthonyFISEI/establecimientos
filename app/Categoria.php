<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //Leer las rutas por el slug y no por id

    public function getRouteKeyName()
    {
        return 'slug';
    }


    // relacion uno a muchos para categorias y establecimientos

    public function establecimientos(){

        return $this->hasMany(Establecimiento::class);
    }
}
