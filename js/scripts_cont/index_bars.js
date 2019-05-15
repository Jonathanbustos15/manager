$(function(){
	console.log('hola index bars')

	//----------------------------------------------------------------
	//funcion de consulta del los datos

	var objt_estudioVal = '';
	var obtj_hojaVidaVal = '';

	function cons_hvida(){

		var consulta_hvida = "SELECT hoja_estudio.*,estudio.fkID_tipoEstudio as tipo_estudio FROM `hoja_estudio` INNER JOIN estudio ON estudio.pkID = hoja_estudio.pkID_estudio where estudio.fkID_tipoEstudio = 1 ORDER BY `pkID` ASC";

		$.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "query="+consulta_hvida+"&tipo=consulta_gen&nom_tabla=hoja_estudio",
	    })
	    .done(function(data) {
	    	/*muestra data actual*/
	    	var ordena_estudios = [];
	    	var objt_Barra = [];
	        //console.log(data.mensaje);
	        $.each(data.mensaje, function(index, val) {
		     	 /* iterate through array or object 
		     	 for (var i = 0; i > val.length; i++) {
		     	 	//-------------------------------
		     	 	console.log("Estudio :"+val.pkID_estudio+"-- Hvida:"+val.pkID_hojaVida)
		     	 	//-------------------------------
		     	 };*/
		     	 console.log('index:'+index+' val:'+val)

		     	 console.log("Estudio :"+val.pkID_estudio+"-- Hvida:"+val.pkID_hojaVida)

		     	 objt_estudioVal = cons_nom_estudio(val.pkID_estudio);

		     	 //validar que el estudio no este en el array estudios
		     	 //si no esta meterlo

		     	 //ir contado cuado va para cada uno

		     	 var a = ordena_estudios.indexOf(objt_estudioVal.nombre);
		     	 console.log(a)		     	 		   

		     	 if (a == '-1') {
		     	 	// statement
		     	 	//meterl el estudio
		     	 	//objt_Barra.cant = objt_Barra.cant + 1
		     	 	//objt_Barra.nombre = objt_estudioVal.nombre
		     	 	ordena_estudios.push(objt_estudioVal.nombre);
		     	 	objt_Barra.push({
			     	 	'nombre':objt_estudioVal.nombre,
			     	 	'cant':1
			     	 });

		     	 } else {
		     	 	// statement
		     	 	//ordena_estudios.splice(a,a);
		     	 	objt_Barra[a].cant = objt_Barra[a].cant + 1;
		     	 }

		     	 obtj_hojaVidaVal = cons_obtj_hvida(val.pkID_hojaVida);

		     	 console.log(objt_estudioVal)
		     	 console.log(obtj_hojaVidaVal)		     	 

		     });

		     console.log(ordena_estudios);
		     console.log(objt_Barra);

		     //-----------------------------------------------------
		     Morris.Bar({
		        element: 'morris-bar-chart',
		        data: objt_Barra,
		        xkey: 'nombre',
		        ykeys: ['cant'],
		        labels: ['Cantidad'],
		        hideHover: 'auto',
		        resize: true
		    });		        			     
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });
		/*---------------------------------------------------*/

	}

	function cons_nom_estudio(pkID_estudio){

		var consulta_nom_estudio = "SELECT * FROM `estudio` WHERE `pkID` = "+pkID_estudio;

		var dataNomEstudio = $.ajax({
	        url: '../controller/ajaxController12.php',
	        async: false,
	        data: "query="+consulta_nom_estudio+"&tipo=consulta_gen&nom_tabla=estudio",
	    })
	    .done(function(data) {
	    	//console.log(data);
	    	//return data.mensaje[0].nombre;	        			     
	    })
	    .fail(function() {
	        //console.log("error");
	    })
	    .always(function() {
	        //console.log("complete");
	    });

	    return dataNomEstudio.responseJSON.mensaje[0];
		/*---------------------------------------------------*/
	}

	function cons_obtj_hvida(pkID_hvida){

		var consulta_obtj_hvida = "SELECT * FROM `hoja_vida` WHERE `pkID` = "+pkID_hvida;

		var dataObjtHvida = $.ajax({
	        url: '../controller/ajaxController12.php',
	        async: false,
	        data: "query="+consulta_obtj_hvida+"&tipo=consulta_gen&nom_tabla=hoja_vida",
	    })
	    .done(function(data) {
	    	//console.log(data);
	    	//return data.mensaje[0].nombre;	        			     
	    })
	    .fail(function() {
	        //console.log("error");
	    })
	    .always(function() {
	        //console.log("complete");
	    });

	    return dataObjtHvida.responseJSON.mensaje[0];
		/*---------------------------------------------------*/
	}

	cons_hvida();
	//----------------------------------------------------------------
	/*
	Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '2006',
            a: 100,
            b: 90
        }, {
            y: '2007',
            a: 75,
            b: 65
        }, {
            y: '2008',
            a: 50,
            b: 40
        }, {
            y: '2009',
            a: 75,
            b: 65
        }, {
            y: '2010',
            a: 50,
            b: 40
        }, {
            y: '2011',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 100,
            b: 90
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });*/
});