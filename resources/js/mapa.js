import { OpenStreetMapProvider } from 'leaflet-geosearch';

const provider = new OpenStreetMapProvider();

document.addEventListener('DOMContentLoaded', () => {


//     if(document.querySelector('#mapa')){


//     const lat =
//     document.querySelector('#lat').value === '' ? -0.9336698 : document.querySelector('#lat').value;

//   const lng =
//     document.querySelector('#lng').value === ''
//       ? -78.6171449
//       : document.querySelector('#lng').value;

//     const mapa = L.map('mapa').setView([lat, lng], 16);

//     let markers = new L.FeatureGroup().addTo(mapa);

//     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//         attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
//     }).addTo(mapa);

//     let marker;

//     // agregar el pin
//     marker = new L.marker([lat, lng],{
//         draggable: true,
//         autoPan: true
//     }).addTo(mapa);

//     markers.addLayer(marker);
//     // console.log(L.esri);

//     // Crear Geocode Service

//     const geocodeService = L.esri.Geocoding.geocodeService({
//         apikey: 'AAPKd77d46fe8cd94441840126c417ef4ae2cMuKLeEr0ynah5SGDFwdycAPmjMv2U5ebffUPg-PtLKzgbmhbGy7sAEtqPD4YsYc'  // reemplazamos con nuestra api key
//     });

//     // Buscador de direcciones

//     const buscador = document.querySelector('#formbuscador');
//     buscador.addEventListener('blur', buscarDireccion);
//     //Detectar movimiento del marcador

//     marker.on('moveend',function(e){
//         // console.log('Soltaste el pin')
//         // console.log()

//         marker= e.target;

//         const posicion = marker.getLatLng();
//         //Centrar automaticamente

//         mapa.panTo(new L.LatLng( posicion.lat, posicion.lng))

//         // Reverse Geocoding, cuando el usuario reubica el pin

//         geocodeService.reverse().latlng(posicion,16).run(function(error,resultado){
//             // console.log(error);

//             // console.log(resultado.address);

//             marker.bindPopup(resultado.address.LongLabel);
//             marker.openPopup();

//             // LLenar los campos

//             llenarInputs(resultado);

//         })

//     })

//         function buscarDireccion(e){
//             //  console.log(provider);

//              if(e.target.value.length>1){

//                 provider.search({query: e.target.value + ' Latacunga EC '})
//                         .then(resultado =>{
//                             // console.log(resultado[0].bounds);

//                             if(resultado[0]){

//                                 markers.clearLayers();

//                                 // Reverse Geocoding, cuando el usuario reubica el pin

//                                 geocodeService.reverse()
//                                 .latlng(resultado[0].bounds[0],16).
//                                 run(function(error,resultado){
//                                     // console.log(error);

//                                     // Llenar los inputs


//                                     llenarInputs(resultado);
//                                     // Centrar el mapa

//                                     mapa.setView(resultado.latlng);
//                                     // Agregar el Pin

//                                     marker = new L.marker(resultado.latlng,{
//                                         draggable: true,
//                                         autoPan: true
//                                     }).addTo(mapa);


//                                     //Permitir al usuario mover el pin
//                                 })
//                             }
//                         })
//                         .catch(error => {
//                             console.log(error)
//                         })
//              }

//         }

//         function llenarInputs(resultado){
//             console.log(resultado);
//             document.querySelector('#direccion').value = resultado.address.Match_addr || '';
//             document.querySelector('#colonia').value = resultado.address.Region || '';

//             document.querySelector('#lat').value = resultado.latlng.lat || '';
//             document.querySelector('#lng').value = resultado.latlng.lng || '';
//         }
//     }

if (document.querySelector('#mapa')) {
    const lat =
      document.querySelector('#lat').value === '' ? -0.9336698 : document.querySelector('#lat').value

    const lng =
      document.querySelector('#lng').value === ''
        ? -78.6171449
        : document.querySelector('#lng').value

    const mapa = L.map('mapa').setView([lat, lng], 16)

    // Eliminar pines previos
    let markers = new L.FeatureGroup().addTo(mapa)

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetmap</a> contributors',
    }).addTo(mapa)

    let marker

    // agregar el pin
    marker = new L.marker([lat, lng], {
      draggable: true,
      autoPan: true,
    }).addTo(mapa)

    // Agregar el pin a las capas
    markers.addLayer(marker)


    // Crear Geocode Service


    const geocodeService = L.esri.Geocoding.geocodeService({
        apikey: 'AAPKd77d46fe8cd94441840126c417ef4ae2cMuKLeEr0ynah5SGDFwdycAPmjMv2U5ebffUPg-PtLKzgbmhbGy7sAEtqPD4YsYc'  // reemplazamos con nuestra api key
    });


    // Buscador de direcciones
    const addressSearcher = document.querySelector('#formbuscador')

    addressSearcher.addEventListener('blur', searchAddress)

    relocatePin(marker)

    function fillInputs(location) {
        console.log(location)
      document.querySelector('#direccion').value = location.address.Address || ''
      document.querySelector('#colonia').value = location.address.Neighborhood || ''
      document.querySelector('#lat').value = location.latlng.lat || ''
      document.querySelector('#lng').value = location.latlng.lng || ''
    }

    function searchAddress(e) {
      if (e.target.value.length > 5) {
        provider
          .search({ query: e.target.value + ' Latacunga EC ' })
          .then(resp => {
            if (resp[0]) {

                // Limpiar los pines previos
              markers.clearLayers()

              // Reverse Geocoding, cuando el usuario reubica el pin
              geocodeService
                .reverse()
                .latlng(resp[0].bounds[0], 16)
                .run((error, result) => {
                  fillInputs(result)

                  mapa.setView(result.latlng)

                // //   Agregar el pin
                  marker = new L.marker(result.latlng, {
                    draggable: true,
                    autoPan: true,
                  }).addTo(mapa)

                // Asignar el contenedor de markers el nuevo pin

                  markers.addLayer(marker)

                  marker.bindPopup(result.address.LongLabel)
                  marker.openPopup()

                  relocatePin(marker)
                })
            }
          })
          .catch(console.error)
      }
    }

    //Reubicar Pin
    function relocatePin(marker) {
        //Detectar movimiento del marcador
      marker.on('moveend', e => {
        marker = e.target
        const position = marker.getLatLng()

        //Centrar automaticamente
        mapa.panTo(new L.LatLng(position.lat, position.lng))

        geocodeService
          .reverse()
          .latlng(position, 16)
          .run((error, result) => {
            marker.bindPopup(result.address.LongLabel)
            marker.openPopup()
            fillInputs(result)
          })
      })
    }
  }
});
