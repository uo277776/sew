var mapaDinamicoGoogle = new Object();
function initMap(){
    var centro = {lat: 43.532984, lng: -5.66096};
    var mapa = new google.maps.Map(document.getElementById("mapa"),{zoom: 8,center:centro});
    var marcador = new google.maps.Marker({position:centro,map:mapa});
}
mapaDinamicoGoogle.initMap = initMap;
