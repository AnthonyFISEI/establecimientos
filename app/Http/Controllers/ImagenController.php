<?php

namespace App\Http\Controllers;

use App\Establecimiento;
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

        //Validacion policy
        $uuid=$request->get('uuid');

        $establecimiento = Establecimiento::where('uuid', $uuid)->first();

        $this->authorize('delete',$establecimiento);

        //Imagen a eliminar
        $imagen= $request->get('imagen');
        // $respuesta = [
        //     'imagen_eliminar' => $imagen
        // ];

        if(File::exists('storage/'. $imagen)){
            //Elimina imgane del servidor

            File::delete('storage/'. $imagen);

            // Eliminar imagen de la BD
            Imagen::where('ruta_imagen',$imagen)->delete();

            $respuesta = [
                'eliminado' => 'Imagen Eliminada',
                'imagen' => $imagen,
                'uuid' => $uuid
            ];
        }



        // Eliminar la imagen de la bd

        // Imagen::where('ruta_imagen','=', $imagen)->delete();

        // Otra forma de eliminar

        // $imagenEliminar=Imagen::where('ruta_imagen','=', $imagen)->firstOrFail();
        // Imagen::destroy($imagenEliminar->id);

        return response()->json($respuesta);
    }
}


