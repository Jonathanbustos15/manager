$(function(){
	
	//-------------------------------------------
	//console.log('hola sesion...');

	//leer cookies con js document.cookie--------
	/*
	function leerCookie(nombre) {
         var lista = document.cookie.split(";");
         for (i in lista) {
             var busca = lista[i].search(nombre);
             if (busca > -1) {micookie=lista[i]}
             }
         var igual = micookie.indexOf("=");
         var valor = micookie.substring(igual+1);
         return valor;
    };
    //--------------------------------------------

    console.log( leerCookie("log_lunelAdmin_id") );

    function crea_timeSesion(){

    	if( localStorage.getItem("sesion_time") ){
    		console.log( localStorage.getItem("sesion_time") )
    	}else{
    		localStorage.setItem("sesion_time", 0 )
    		console.log( localStorage.getItem("sesion_time") )
    	}
    }

    crea_timeSesion()    

	$('#timer-sesion').timer({
	    duration: 1,
	    callback: function() {
	        if ( parseInt(localStorage.sesion_time) == 3600 ) {
	        	
	        	localStorage.removeItem("sesion_time");
	        	location.reload();
		    	
		    }else{		    	
		    			    
		    	localStorage.sesion_time = parseInt(localStorage.sesion_time) + 1;
		    	 		    	
		    };
	    },
	    repeat: true //repeatedly call the callback
	});
	*/

});