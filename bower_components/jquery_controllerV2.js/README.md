# jquery_controllerV2.js
Plugin controlador de CRUDs para jsFramework Versión-2.

<br>

<h3>Ajustes por defecto:</h3>

tipo:'nuevo', //tipo de instancia
action:'insertar', //accion a realizar el botón
tipo_load:1, //tipo de carga puede ser 1(normal) o 2(especificando el form)
objt_f:'', //objeto del formulario
id : '', //id del registro de BD
subida : false, //si sube o no archivos
recarga : true, //si recarga o no la pagina despues de cada accion (sirve para debug)
//------------------------
//ajustes del form/modulo
nom_modulo:'', //el nombre del modulo usado
titulo_label:'', //titulo de la ventana del modal
nom_tabla:'', //nombre de la tabla en la BD
//-----------------------------------------------------------------
//Datos resultado funcion crear
id_resCrear:'', //resultado de la insercion del registro(last_id)
functionResCrear:function(){
    console.log('El ultimo creado fue: '+ajustes.id_resCrear);
    console.log('Ejecutando luego de Insertar!!!');                
},
//-----------------------------------------------------------------            
functionResEliminar:function(){
    //console.log('El eliminar registro: '+ajustes.id_resCrear);
    console.log('Ejecutando luego de Eliminar!!!');                
},
//-----------------------------------------------------------------
functionResCarga:function(){
    //console.log('El eliminar registro: '+ajustes.id_resCrear);
    console.log('Ejecutando luego de Cargar!!!');                
},
functionResEditar:function(){
    console.log('Se editó registro: '+ajustes.id_resCrear);
    console.log('Ejecutando luego de Editar!!!');                
},
//-----------------------------------------------------------------
//variable que dice si hay que ejecutar una funcion
//esto depende del tipo
ejecutarFunction:false

<br>

Ejemplo set del plugin boton:

$("#btn_xxx").jquery_controller({
  		tipo:'inserta/edita', 
  		titulo_label:'Nuevo Contenido' 
  		nom_modulo:'contenido',
  		nom_tabla:'contenido',
  		subida:true,
  		recarga:true,
  		ejecutarFunction:true,
  		functionResCrear:function(){
                
                console.log('Ejecutando luego de Insertar!!!');
                console.log('El ultimo insertado fue '+this.id_resCrear);
                
                //------------------------------------------------------------------------------------------------------------
	 	},
	 	functionResEditar:function(){
            console.log('Se editó registro: '+this.id_resCrear);
            console.log('Ejecutando luego de Editar!!!');                
        },
  	});

