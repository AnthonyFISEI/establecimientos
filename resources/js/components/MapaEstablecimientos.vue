<template>
<div class="mapa">
    <l-map
        :zoom="zoom"
        :center="center"
        :options="mapOptions"
    >
        <l-tile-layer :url="url" :attribution="attribution"/>
            <l-marker v-for="establecimiento in establecimientos" v-bind:key="establecimiento.id"
                    :lat-lng="obtenerCoordenadas(establecimiento)"
                    :icon="iconoEstablecimiento(establecimiento)"
                    @click="redireccionar(establecimiento.id)"
            >
                <l-tooltip>
                    <div class="">
                        {{establecimiento.nombre}} - {{establecimiento.categoria.nombre}}
                    </div>
                </l-tooltip>
            </l-marker>
    </l-map>
</div>
</template>

<script>
import { latLng } from "leaflet";
import { LMap, LTileLayer, LMarker, LTooltip, LIcon } from "vue2-leaflet";
export default {
  components: {
    LMap,
    LTileLayer,
    LMarker,
    LTooltip,
    LIcon,
  },
  data() {
    return {
      zoom: 13,
      center: latLng(-0.9336698, -78.6171449),
      url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
      attribution:
        '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
      currentZoom: 11.5,
      currentCenter: latLng(-0.9336698, -78.6171449),
      showParagraph: false,
      mapOptions: {
        zoomSnap: 0.5,
      },
      showMap: true,
    };
  },
  created(){
      axios.get('/api/establecimientos')
            .then(respuesta=>{
                // console.log(respuesta.data);
                this.$store.commit('AGREGAR_ESTABLECIMIENTOS',respuesta.data);
            });
  },
  computed:{
      establecimientos(){
          return this.$store.getters.obtenerEstablecimientos;
      }
  },
  methods:{
      obtenerCoordenadas(establecimiento){
        //   console.log(establecimiento);

        return{
            lat: establecimiento.lat,
            lng: establecimiento.lng
        }
      },
      iconoEstablecimiento(establecimiento){
        //   console.log(establecimiento);

        const { slug } =establecimiento.categoria;
        return L.icon({
            iconUrl: `images/iconos/${slug}.png`,
            iconSize: [40,50]
        })
      },
      redireccionar(id){
          this.$router.push({name : 'establecimiento' , params:{id}})
      }
  },
  watch:{
      "$store.state.categoria":function(){
        //   console.log('ya cambio');
        axios.get('/api/' + this.$store.getters.obtenerCategoria)
            .then(respuesta=>{
                // console.log(respuesta);
                this.$store.commit('AGREGAR_ESTABLECIMIENTOS',respuesta.data);
            })
      }
  }
};
</script>

<style scoped>
.mapa{
    height:600px;
    width:100%;
}
</style>
