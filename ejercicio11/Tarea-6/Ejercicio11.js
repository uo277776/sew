var mapaNuevo = new Object();

var locationA;
var locationB;
var primerMarcador = false;
function initMap() {
  mapa = new google.maps.Map(document.getElementById('mapa'), {
    center: new google.maps.LatLng(43.532984, -5.66096),
    zoom: 2,
    mapTypeId: 'terrain'
  });

  google.maps.event.addListener(mapa, 'click', function(event) {
    placeMarker(event.latLng, mapa);
    if (!primerMarcador){
      locationA = event.latLng;
      primerMarcador = true;
    } else{
      locationB = event.latLng;
      var puntos_linea = [
        locationA,
        locationB
      ]
      var linea = new google.maps.Polyline({
        path: puntos_linea,
        geodesic: true,
        strokeColor: '#FF0000',
        strokeOpacity: 1.0,
        strokeWeight: 2
       })
       linea.setMap(mapa);
    }
  });
}


function placeMarker(location, mapa) {
   var marker = new google.maps.Marker({
       position: location, 
       map: mapa
   });
}

function calcularDistancia(){
  var distanceInMeters = google.maps.geometry.spherical.computeDistanceBetween(
    locationA,
    locationB
  );

  $("#mapa").after("<p>La distancia en metros es: " + distanceInMeters +"</p>");
  $("#mapa").after("<p>La distancia en km es: " + distanceInMeters/1000 +"</p>");
}

mapaNuevo.initMap = initMap;