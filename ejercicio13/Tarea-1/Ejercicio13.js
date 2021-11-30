var mapaNuevo = new Object();
var src = 'https://uo277776.github.io/sew/personas.kml';

function initMap() {
  mapa = new google.maps.Map(document.getElementById('mapa'), {
    center: new google.maps.LatLng(-19.257753, 146.823688),
    zoom: 2,
    mapTypeId: 'terrain'
  });

  var kmlLayer = new google.maps.KmlLayer({
    url: src,
    suppressInfoWindows: false,
    preserveViewport: false,
    map: mapa
  });
}

mapaNuevo.initMap = initMap;