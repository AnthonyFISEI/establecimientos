<template>

    <div class="container my-5">
        <h2>Hoteles</h2>

        <div class="row">
            <div class="col-md-4 mt-4" v-for="hotel in this.hoteles" v-bind:key="hotel.id">

                <div class="card">
                    <img  class="card-img-top" :src="`storage/${hotel.imagen_principal}`" alt="card del restaurant">
                    <div class="card-body">
                        <h3 class="card-title text-primary font-weight-bold">{{hotel.nombre}}</h3>
                        <p class="card-text">{{hotel.direccion}}</p>
                        <p class="card-text">
                            <span class="font-weight-bold">Horario:</span>
                                {{hotel.apertura}} - {{hotel.cierre}}
                        </p>

                        <a href="" class="btn btn-primary d-block">Ver Lugar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {

    data:function(){
        return{
            hoteles: []
        }
    },
    mounted(){
        axios.get('/api/categorias/hotel')
            .then(respuesta=>{
                // console.log(respuesta.data)
                this.hoteles = respuesta.data;
            })
    }
}
</script>
