$(function(){
	//console.log('hola desde selects formatos')
	//

	//----------------------------------------------------------------------------------------------------------------------
	//funciones para el modal de personal
	console.log('Hola personal...');

	//---------------------------------------------------------
	//variable para el objeto del formulario
	var objt_f_personal = {};
	//variable de accion del boton del formulario
	var action = "";
	  //variable para el id del registro
	var id_personal = "";

	//--------------------------------------------------------- 
	function valida_action_personal(action){

  		if(action==="crear"){
    		crea_personal();
    		//subida_foto();
  		}else if(action==="editar"){
    		edita_personal();
  		};
	};
	//---------------------------------------------------------
	

	//-------------------------------------------------------------------------------------------
   

    function crea_personal(){

	      //--------------------------------------
	      //crea el objeto formulario serializado
	      objt_f_personal = $("#form_personal").valida();
	      
	      console.log(objt_f_personal.srlz);
	      //--------------------------------------
	      /**/
	      if( objt_f_personal.estado == true ){	      

	        $.ajax({
	          url: "../controller/ajaxController12.php",
	          data: objt_f_personal.srlz+"&tipo=inserta&nom_tabla=hv_proyecto",
	        })
	        .done(function(data) {	          
	          //---------------------
	          console.log(data);
	          
	          //var pkID_personal = data[0].last_id;
	         
	          //insertaArchivo("pkID_hojaVida="+pkID_hojaVida+"&url_archivo="+val[0].name+"&des_archivo="+getValoresDesc(val[0].name);
	                   
	          //$("#btn_actionpersonal").attr('enabled','enabled');

	          alert(data[0].mensaje);
	          location.reload();
	          //$('#form_modal_personal').modal('hide');
	          //$('#form_modal_documentos').modal('show');
	          
	        })
	        .fail(function(data) {
	          console.log(data);
	          //alert(data[0].mensaje);          
	        })
	        .always(function() {
	          console.log("complete");
	        });

	      }else{
	        alert("El formulario no está totalmente diligenciado, revíselo e inténtelo de nuevo.");
	      };

	    };
	  //cierra crea

	  function elimina_personal(id_personal){

	    console.log('Eliminar el personal: '+id_personal);

	    var confirma = confirm("En realidad quiere eliminar esta personal?");

	    console.log(confirma);
	    /**/
	    if(confirma == true){
	      //si confirma es true ejecuta ajax
	      $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: "pkID="+id_personal+"&tipo=eliminar&nom_tabla=hv_proyecto",
	        })
	        .done(function(data) {            
	            //---------------------
	            console.log(data);

	            alert(data.mensaje.mensaje);
	            
	            location.reload();
	        })
	        .fail(function() {
	            console.log("error");
	        })
	        .always(function() {
	            console.log("complete");
	        });
	    }else{
	      //no hace nada
	    }
    };
    //cierra funcion eliminar personal

	function edita_personal(){

	    //--------------------------------------
	    //crea el objeto formulario serializado
	    objt_f_personal = $("#form_personal").valida();
	 		    
	    //--------------------------------------
	    /**/
	    if( objt_f_personal.estado == true) {

	        console.log(objt_f_personal.srlz);

	        $.ajax({
	            url: '../controller/ajaxController12.php',
	            data: objt_f_personal.srlz+"&tipo=actualizar&nom_tabla=hv_proyecto",
	        })
	        .done(function(data) {	           
	          //---------------------
	          console.log(data);
	          

	          //id_personal = $("#pkID").val();	         	        

	          alert(data.mensaje.mensaje);

	          location.reload();
	        })
	        .fail(function() {
	            console.log("error");
	        })
	        .always(function() {
	            console.log("complete");
	        });

	    }else{
	        alert("Faltan "+Object.keys(objt_f_personal.objt).length+" campos por llenar.");
	    }
	    //------------------------------------------------------

    };
    //cierra funcion edita_personal

	function carga_personal(id_personal){

	    console.log("Carga el personal "+id_personal);

	    $.ajax({
	        url: '../controller/ajaxController12.php',
	        data: "pkID="+id_personal+"&tipo=consultar&nom_tabla=hv_proyecto",
	    })
	    .done(function(data) {
	    	/**/
	        $.each(data.mensaje[0], function( key, value ) {
	          console.log(key+"--"+value);
	          //console.log($("#form_personal")[0][key].value = value);
	          //$("#"+key).val(value);
	          $("#form_personal")[0][key].value = value;
	        });

	        id_personal = data.mensaje[0].pkID;	        
	    })
	    .fail(function() {
	        console.log("error");
	    })
	    .always(function() {
	        console.log("complete");
	    });

	};
	//cierra carga_personal

	  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


	//-------------------------------------------------------------------------------
	//ejecución
	//-------------------------------------------------------------------------------	
	
	

	/*
	Botón que carga el formulario para insertar
	*/
	$("#btn_nuevopersonal").click(function(){

	  	$("#lbl_form_personal").html("Asignar Persona a este proyecto");
	  	$("#lbl_btn_actionpersonal").html("Guardar <span class='glyphicon glyphicon-save'></span>");
	  	$("#btn_actionpersonal").attr("data-action","crear");

	  	$("#btn_actionpersonal").removeAttr('disabled');
	     //validaBtnGuardar();

	  	$("#form_personal")[0].reset();

	  	//cierra modal formato
	  	//$('#form_modal_documentos').modal('hide');

	  	var id_proyecto = $("#id_proyecto").val();

	  	console.log(id_proyecto);

	  	$("#fkID_proyecto").val(id_proyecto);
	  		      	   
	});	

	/*
	Botón de accion de formulario
	*/
	$("#btn_actionpersonal").click(function(){
		
		action = $(this).attr("data-action");
		valida_action_personal(action);
		console.log("accion a ejecutar: "+action); 
		//subida_archivo();   
	});

	/*
	Botón que carga el formulario para editar
	*/  
	$("[name*='edita_hv_proyecto']").click(function(event) {

		$("#lbl_form_personal").html("Editar personal");
		$("#lbl_btn_actionpersonal").html("Guardar Cambios <span class='glyphicon glyphicon-pencil'></span>");
		$("#btn_actionpersonal").attr("data-action","editar");

		$("#form_personal")[0].reset();

		id_personal = $(this).attr('data-id-hv-proyecto');

		$("#btn_actionpersonal").removeAttr('disabled');
		

		carga_personal(id_personal);
		//carga_propiedades(id_personal);
	});

	/*
	Botón que elimina registro
	*/  
	$("[name*='elimina_hv_proyecto']").click(function(event) {		
		id_personal = $(this).attr('data-id-hv-proyecto');		
		elimina_personal(id_personal);
	});	

	//-------------------------------------------------------------------------------------

	$('#tbl_personal').on( 'click', '.detail', function () {
	  window.location.href = $(this).attr('href');
	} );

	//-------------------------------------------------------------------------------------
	/*
	var table = $('#tbl_personal').DataTable(

        {
            //"order": [[ 1, "asc" ]], //ordenando por nombre asc
            "pagingType": "full_numbers",
            "lengthMenu": [[-1, 5, 10, 25, 50], ["Todo", 5, 10, 25, 50]],

            "language": {
                "lengthMenu":     "Mostrando _MENU_ registros",
                "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                "search":         "Buscar:",
                "loadingRecords": "Cargando...",
                "processing":     "Procesando...",
                "zeroRecords": "No hay registros que coincidan.",
                "infoEmpty": "No se encuentran registros.",
                "infoFiltered":   "(Filtrando _MAX_ registros en total)",
                //------------------------------------------------------------------
                //paginador
                "paginate": {
                    "first":      "<--",
                    "last":       "-->",
                    "next":       ">",
                    "previous":   "<"
                },
                "aria": {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
                //------------------------------------------------------------------
            }
        }

    );

    

    setTimeout(function(){
        table.page.len( 10 ).draw();
        table.column( 0 ).visible( false );
        table.order( [ 0, 'desc' ] ).draw();
    }, 1000);*/

    //-------------------------------------------------------------------------------
    //tabla de gastos de proyecto
    /*
    var tablegastosProyecto = $('#tbl_gastosProyecto').DataTable(

        {
            //"order": [[ 1, "asc" ]], //ordenando por nombre asc
            "pagingType": "full_numbers",
            "lengthMenu": [[-1, 5, 10, 25, 50], ["Todo", 5, 10, 25, 50]],

            "language": {
                "lengthMenu":     "Mostrando _MENU_ registros",
                "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                "search":         "Buscar:",
                "loadingRecords": "Cargando...",
                "processing":     "Procesando...",
                "zeroRecords": "No hay registros que coincidan.",
                "infoEmpty": "No se encuentran registros.",
                "infoFiltered":   "(Filtrando _MAX_ registros en total)",
                //------------------------------------------------------------------
                //paginador
                "paginate": {
                    "first":      "<--",
                    "last":       "-->",
                    "next":       ">",
                    "previous":   "<"
                },
                "aria": {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
                //------------------------------------------------------------------
            }
        }

    );

    setTimeout(function(){
        tablegastosProyecto.page.len( 10 ).draw();
    }, 1000);*/

});