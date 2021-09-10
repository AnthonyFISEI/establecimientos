document.addEventListener('DOMContentLoaded', () => {


    if(document.querySelector('#mapa')){
    const lat = -0.9336698;
    const lng = -78.6171449;

    const mapa = L.map('mapa').setView([lat, lng], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(mapa);

    let marker;

    // agregar el pin
    marker = new L.marker([lat, lng],{
        draggable: true,
        autoPan: true
    }).addTo(mapa);

    //Detectar movimiento del marcador

    marker.on('moveend',function(e){
        // console.log('Soltaste el pin')
        // console.log()

        marker= e.target;

        const posicion = marker.getLatLng();
        //Centrar automaticamente

        mapa.panTo(new L.LatLng( posicion.lat, posicion.lng))
    })
    }
});
