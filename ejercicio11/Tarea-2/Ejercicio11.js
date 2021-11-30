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

    verDatos(){
        var ubicacion=document.getElementsByTagName("main")[0];
        if (this.mensaje != null){
            var datos='<p> ERROR: ' + this.mensaje + '</p>'; 
        } else{
            var datos='<ul>'; 
            datos+='<li>Longitud: '+this.longitud +' grados</li>'; 
            datos+='<li>Latitud: '+this.latitud +' grados</li>';
            datos+='<li>Precisión de la latitud y longitud: '+ this.precision +' metros</li>';
            datos+='<li>Altitud: '+ this.altitud +' metros</li>';
            datos+='<li>Precisión de la altitud: '+ this.precisionAltitud +' metros</li>'; 
            datos+='<li>Rumbo: '+ this.rumbo +' grados</li>'; 
            datos+='<li>Velocidad: '+ this.velocidad +' metros/segundo</li></ul>';
        }
        ubicacion.innerHTML = datos;
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
}
var geo = new Geolocalizacion;