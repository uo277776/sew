var mapaNuevo = new Object();
var src = 'https://uo277776.github.io/sew/personas.geojson';

function initMap() {
  mapa = new google.maps.Map(document.getElementById('mapa'), {
    center: new google.maps.LatLng(-19.257753, 146.823688),
    zoom: 2,
    mapTypeId: 'terrain'
  });

  mapa.data.loadGeoJson(src);

  var infowindow = new google.maps.InfoWindow();

  mapa.data.addListener('click', function(event) {
    var name = event.feature.getProperty("name");
    infowindow.setContent("<p>"+name+"</p>");
    infowindow.setPosition(event.feature.getGeometry().get());
    infowindow.setOptions({pixelOffset: new google.maps.Size(0,-30)});
    infowindow.open(mapa);
  });
}

mapaNuevo.initMap = initMap;