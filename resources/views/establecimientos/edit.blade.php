@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
  integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
  crossorigin=""/>
    <!-- Esri Leaflet Geocoder -->
  <link
  rel="stylesheet"
  href="https://unpkg.com/esri-leaflet-geocoder/dist/esri-leaflet-geocoder.css"
/>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/dropzone.min.css" integrity="sha512-0ns35ZLjozd6e3fJtuze7XJCQXMWmb4kPRbb+H/hacbqu6XfIX0ZRGt6SrmNmv5btrBpbzfdISSd8BAsXJ4t1Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')

    <div class="container">
        <h1 class="text-center mt-4">Editar Establecimiento</h1>

        <div class="mt-5 row justify-content-center">
            <form action="{{route('establecimiento.update',['establecimiento' => $establecimiento->id])}}"
            class="col-md-9 col-xs-12 card card-body"
            method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <fieldset class="border p-4">
                    <legend class="text-primary">Nombre, Categoría e Imagen Principal</legend>

                    <div class="form-group">
                        <label for="nombre">Nombre Establecimiento</label>
                        <input type="text" id="nombre" class="form-control @error('nombre') is-invalid
                        @enderror"
                        placeholder="Nombre Establecimiento"
                        name="nombre"
                        value="{{$establecimiento->nombre}}">

                        @error('nombre')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="categoria">Categoría</label>

                        <select
                            class="form-control @error('categoria_id') is-invalid
                            @enderror"
                            name="categoria_id"
                            id="categoria_id">
                            <option value="" selected disabled>-- Seleccione --</option>

                            @foreach ($categorias as $categoria)
                                <option
                                    value="{{$categoria->id}}"
                                    {{$establecimiento->categoria_id == $categoria->id ? 'selected' : ''}}
                                    >{{$categoria->nombre}}</option>

                            @endforeach
                        </select>

                        @error('categoria_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="imagen_principal">Imagen Principal</label>
                        <input type="file" id="imagen_principal" class="form-control @error('imagen_principal') is-invalid
                        @enderror"
                        name="imagen_principal"
                        value="{{old('imagen_principal')}}">

                        @error('imagen_principal')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                        <img src="/storage/{{$establecimiento->imagen_principal}}" style="width: 200px; margin-top:20px;">
                    </div>
                </fieldset>


                <fieldset class="border p-4 mt-5">
                    <legend class="text-primary">Ubicación</legend>

                    <div class="form-group">
                        <label for="formbuscador">Coloca la dirección de tu Establecimiento</label>
                        <input type="text" id="formbuscador"
                        placeholder="Calle del Negocio o Establecimiento"
                        class="form-control">

                        <p class="text-secondary mt-5 mb-3 text-center">
                            El asistente colocará una dirección estiamda o mueve el Pin hacia un lugar correcto
                        </p>
                    </div>

                    <div class="form-group">
                        <div id="mapa" style="height: 400px;"></div>
                    </div>

                    <p class="informacion">Confirma que los siguientes campos son correctos</p>

                    <div class="form-group">
                        <label for="direccion">Dirección</label>

                        <input type="text"
                                id="direccion"
                                name="direccion"
                                class="form-control @error('direccion') is-invalid
                                @enderror"
                                placeholder="Dirección"
                                value="{{$establecimiento->direccion}}">

                        @error('direccion')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="colonia">Colonia</label>

                        <input type="text"
                                id="colonia"
                                class="form-control @error('colonia') is-invalid
                                @enderror"
                                placeholder="Colonia"
                                value="{{$establecimiento->colonia}}"
                                name="colonia">

                        @error('colonia')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                        @enderror
                    </div>

                    <input type="hidden" id="lat" name="lat" value="{{$establecimiento->lat}}">
                    <input type="hidden" id="lng" name="lng" value="{{$establecimiento->lng}}">


                </fieldset>

                <fieldset class="border p-4 mt-5">
                    <legend  class="text-primary">Información Establecimiento: </legend>
                        <div class="form-group">
                            <label for="nombre">Teléfono</label>
                            <input
                                type="tel"
                                class="form-control @error('telefono')  is-invalid  @enderror"
                                id="telefono"
                                placeholder="Teléfono Establecimiento"
                                name="telefono"
                                value="{{ $establecimiento->telefono }}"
                            >

                                @error('telefono')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                        </div>



                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea
                                class="form-control  @error('descripcion')  is-invalid  @enderror"
                                name="descripcion"
                            >{{ $establecimiento->descripcion }}</textarea>

                                @error('descripcion')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="apertura">Hora Apertura:</label>
                            <input
                                type="time"
                                class="form-control @error('apertura')  is-invalid  @enderror"
                                id="apertura"
                                name="apertura"
                                value="{{ $establecimiento->apertura}}"
                            >
                            @error('apertura')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nombre">Hora Cierre:</label>
                            <input
                                type="time"
                                class="form-control @error('cierre')  is-invalid  @enderror"
                                id="cierre"
                                name="cierre"
                                value="{{ $establecimiento->cierre }}"
                            >
                            @error('cierre')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                </fieldset>

                <fieldset class="border p-4 mt-5">
                    <legend  class="text-primary">Imágenes Establecimiento: </legend>
                        <div class="form-group">
                            <label for="imagenes">Imagenes</label>

                            <div class="dropzone form-control" id="dropzone"></div>
                        </div>
                        @if(count($imagenes)>0)
                        @foreach ($imagenes as $imagen)
                            <input class="galeria" type="hidden" value="{{$imagen->ruta_imagen}}">

                        @endforeach
                    @endif
                </fieldset>
                <input type="hidden" id="uuid" name="uuid" value="{{$establecimiento->uuid}}">
                <input type="submit" class="btn btn-primary mt-3 d-block" value="Guardar Cambios">
            </form>
        </div>

    </div>


@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin="" defer></script>
    <!-- Load Esri Leaflet from CDN -->
    <script src="https://unpkg.com/esri-leaflet" defer></script>


    <!-- Esri Leaflet Geocoder -->
    <script src="https://unpkg.com/esri-leaflet-geocoder" defer></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/dropzone.min.js" integrity="sha512-Mn7ASMLjh+iTYruSWoq2nhoLJ/xcaCbCzFs0ZrltJn7ksDBx+e7r5TS7Ce5WH02jDr0w5CmGgklFoP9pejfCNA==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
@endsection
