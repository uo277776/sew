class Geolocalizacion {

    constructor (){
        navigator.geolocation.getCurrentPosition(this.getPosicion.bind(this), this.manejoErrores.bind(this));
    }

    getPosicion(posicion){
        this.longitud         = posicion.coords.longitude; 
        this.latitud          = posicion.coords.latitude;  
        this.precision        = posicion.coords.accuracy;
        this.altitud          = posicion.coords.altitude;
        this.precisionAltitud = posicion.coords.altitudeAccuracy;
        this.rumbo            = posicion.coords.heading;
        this.velocidad        = posicion.coords.speed;       
    }

    manejoErrores(error){
        switch (error.code){
            case error.PERMISSION_DENIED:
                this.mensaje = "El usuario no permite la petición de geolocalización"
                break;
            case error.POSITION_UNAVAILABLE:
                this.mensaje = "Información de geolocalización no disponible"
                break;
            case error.TIMEOUT:
                this.mensaje = "La petición de geolocalización ha caducado"
                break;
            case error.UNKNOWN_ERROR:
                this.mensaje = "Se ha producido un error desconocido"
                break;
        }

    }
    verDatos(){
        var ubicacion=document.getElementsByTagName("main")[0];
        if (this.mensaje != null){
            var datos='<p> ERROR: ' + this.mensaje + '</p>'; 
            ubicacion.innerHTML = datos;
        } else{
            var datos ='<ul><li>Longitud: '+this.longitud +' grados</li>'; 
            datos+='<li>Latitud: '+this.latitud +' grados</li>';
            datos+='<li>Precisión de la latitud y longitud: '+ this.precision +' metros</li>';
            datos+='<li>Altitud: '+ this.altitud +' metros</li>';
            datos+='<li>Precisión de la altitud: '+ this.precisionAltitud +' metros</li>'; 
            datos+='<li>Rumbo: '+ this.rumbo +' grados</li>'; 
            datos+='<li>Velocidad: '+ this.velocidad +' metros/segundo</li></ul>';
            ubicacion.innerHTML = datos;
            this.getMapaEstaticoGoogle();
        }
    }

    getMapaEstaticoGoogle(){
        var ubicacion=document.getElementsByTagName("main")[0];
        
        var apiKey = "&key=AIzaSyBNOKMk6t52dI87mIHSYsrQbu3FYHIDF8I";
        var url = "https://maps.googleapis.com/maps/api/staticmap?";
        var centro = "center=" + this.latitud + "," + this.longitud;
        var zoom ="&zoom=15";
        var tamaño= "&size=800x600";
        var marcador = "&markers=color:red%7Clabel:S%7C" + this.latitud + "," + this.longitud;
        var sensor = "&sensor=false"; 
        
        this.imagenMapa = url + centro + zoom + tamaño + marcador + sensor + apiKey;
        ubicacion.innerHTML += "<img src='"+this.imagenMapa+"' alt='mapa estÃ¡tico google' />";
    }
}
var geo = new Geolocalizacion;