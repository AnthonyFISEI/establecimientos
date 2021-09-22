<?php

namespace App\Http\Controllers;

use App\Imagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    //



    public function store(Request $request)
    {
        // Leer imagen

        $ruta_imagen = $request->file('file')->store('establecimientos', 'public');


        //Resize a la imagen

        $imagen = Image::make(public_path("storage/{$ruta_imagen}"))->fit(800,450);

        // Guardar imagen en el disco duro del servidor
        $imagen->save();


        //Alamacenar con modelo


        $imagenDB = new Imagen;

        $imagenDB->id_establecimiento = $request['uuid'];
        $imagenDB->ruta_imagen=$ruta_imagen;

        $imagenDB->save();

        //Retornar respuesta

        $respuesta = [
            'archivo' => $ruta_imagen
        ];
        return response()->json($respuesta);
        // return $request->file('file');
    }

    // Elimina una imagen de la bd y del servidor

    public function destroy(Request $request){


        $imagen= $request->get('imagen');
        // $respuesta = [
        //     'imagen_eliminar' => $imagen
        // ];

        if(File::exists('storage/'. $imagen)){
            File::delete('storage/'. $imagen);
        }

        $respuesta = [
            'eliminado' => 'Imagen Eliminada',
            'imagen' => $imagen
        ];

        // Eliminar la imagen de la bd

        Imagen::where('ruta_imagen','=', $imagen)->delete();

        // Otra forma de eliminar

        // $imagenEliminar=Imagen::where('ruta_imagen','=', $imagen)->firstOrFail();
        // Imagen::destroy($imagenEliminar->id);

        return response()->json($respuesta);
    }
}


