//lista la cantidad de enventos definidos para
//un elemento jquery
//$._data($(elemento).get(0), "events")

(function(){
	//widget de autocompletado con categorias
	$.widget( "custom.catcomplete", $.ui.autocomplete, {
	      _create: function() {
	        this._super();
	        this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
	      },
	      _renderMenu: function( ul, items ) {
	        var that = this,
	          currentCategory = "";
	        $.each( items, function( index, item ) {
	          var li;
	          if ( item.category != currentCategory ) {
	            ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
	            currentCategory = item.category;
	          }
	          li = that._renderItemData( ul, item );
	          if ( item.category ) {
	            li.attr( "aria-label", item.category + " : " + item.label );
	          }
	        });
	      }
	});

	//---------------------------------------------------------------------------------------
	//widget para crear un autocompletado desde un select
	$.widget( "custom.combobox", {

	  _setPlaceholder: function(){
	  	//console.log(this.options)
	  	//console.log(this.element)
	  	if (this.options.placeholder) {
	  		//console.log("Si hay placeholder")
	  		this.input.attr('placeholder', this.options.placeholder);
	  	}
	  },

	  _setIdInput: function(){
	  	if (this.options.id_input) {
	  		//console.log("Si hay placeholder")
	  		this.input.attr('id', this.options.id_input);
	  	}
	  },

      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .addClass("dropdown")          
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
        this._setPlaceholder();
        this._setIdInput();
      },
 
      _createAutocomplete: function() {

        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input form-control" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            classes: {
              "ui-tooltip": "ui-state-highlight"
            }
          })
          .removeClass( "ui-autocomplete-input" );
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option,
              getOption: function(){
              	return ui.item.option
              }
            });
          },
 
          autocompletechange: function( event, ui ){
          	this._trigger( "change", event, {
              //item: ui.item.option
              item: function(){
              	return ui.item
              }
            });
          },

          autocompletesearch: function( event, ui ){
          	this._trigger( "search", event, {
              item: ui.option
            });
          },

          autocompleteclose: function( event, ui ){
          	this._trigger( "close", event, {
              item: ui.option
            });
          },

        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          //.attr( "tabIndex", -1 )
          .attr( "title", "Ver Todo" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right btn btn-default dropdown-toggle" )
          .addClass('glyphicon')
          .addClass('glyphicon-menu-down')
          .on( "mousedown", function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .on( "click", function() {
            input.trigger( "focus" );
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      }
    });
	//---------------------------------------------------------------------------------------

	//---------------------------------------------------------------------------------------
	//Uppercase en form
	  function firstUppercase(valor){
	    var valorIni = valor;
	    var letraMay = valorIni[0].toUpperCase();
	    var letra = valorIni[0];

	    valorFinal = valorIni.replace(letra, letraMay);

	    return valorFinal;
	  }

	  function uppercaseStringArr(str){

	  	//Las pasa a minusculas
	  	str = str.toLowerCase();
	  	
	  	var res = str.split(" ");
	  	$.each(res, function(index, val) {	  		 
	  		 res[index] = firstUppercase(val)	  		 
	  	});	 
	  	var fin = res.join(" ");

	  	return fin;

	  }

	  function uppercaseStringArr2(str){

	  	//Las pasa a minusculas
	  	str = str.toUpperCase();
	  	
	  	var res = str.split(" ");
	  	$.each(res, function(index, val) {	  		 
	  		 res[index] = firstUppercase(val)	  		 
	  	});	 
	  	var fin = res.join(" ");

	  	return fin;

	  }
	  function validaUppercaseArr(str){
	  	//Las pasa a minusculas
	  	str = str.toLowerCase();

	  	var res = str.split("");

	  	$.each(res, function(index, val) {
	  		
	  		//console.log("index: "+index+" val: "+val)

	  		if (val == val.toUpperCase()) {
				//alert ('upper case true');
				if (index != 0) {
					res[index] = val.toLowerCase()
				}
			}
			if (val == val.toLowerCase()){
				//alert ('lower case true');

				if (index == 0) {
					res[index] = val.toUpperCase()
				}
			}			

	  	});

	  	var fin = res.join("");

	  	//console.log(fin)

	  	return fin;

	  }
	 
	  //console.log($("#form_hvida"))-----------------------------------------------------//

	  self.uppercaseForm = function(selector_form){
	  	console.log('Seteando uppercase '+selector_form)

	  	$.each($("#"+selector_form)[0], function(index, val) {
		  	 /* iterate through array or object */
		  	 //console.log('llave: '+index+' valor: '+val)
		  	 //console.log(val["name"])
		  	 //console.log(val["type"])

		  	 if (val["type"]=="text" || val["type"]=="textarea") {

		  	 	if (val["name"]=='nombre' || val["name"]=='apellido' ) {

		  	 		$("#"+selector_form+" [id='"+val["id"]+"']").blur(function(event) {

					    $(this).val( uppercaseStringArr( $(this).val() ) );
					    
					  });

		  	 	}else if(val["name"]!='url_propuesta' && val["name"]!='email' && val["id"]!='contrasena' && val["id"]!='usuario' && val["id"]!='codigo' && val["id"]!='nombre_entidad' ){

		  	 		$("#"+selector_form+" [id='"+val["id"]+"']").blur(function(event) {

					    //$(this).val(firstUppercase( $(this).val() ) );
					    $(this).val(validaUppercaseArr( $(this).val() ) );
					   
					  });

		  	 	};
		  	 
		  	 };

		  });

	  }

	  self.uppercaseForm2 = function(selector_form){
	  	console.log('Seteando uppercase '+selector_form)

	  	$.each($("#"+selector_form)[0], function(index, val) {
		  	 /* iterate through array or object */
		  	 //console.log('llave: '+index+' valor: '+val)
		  	 //console.log(val["name"])
		  	 //console.log(val["type"])

		  	 if (val["type"]=="text" || val["type"]=="textarea") {

		  	 	if (val["name"]=='nombre' || val["name"]=='apellido' ) {

		  	 		$("#"+selector_form+" [id='"+val["id"]+"']").blur(function(event) {

					    $(this).val( uppercaseStringArr2( $(this).val() ) );
					    
					  });

		  	 	}else if(val["name"]!='url_propuesta' && val["name"]!='email' && val["id"]!='contrasena' && val["id"]!='usuario' && val["id"]!='codigo' && val["id"]!='nombre_entidad' ){

		  	 		$("#"+selector_form+" [id='"+val["id"]+"']").blur(function(event) {

					    //$(this).val(firstUppercase( $(this).val() ) );
					    $(this).val(validaUppercaseArr( $(this).val() ) );
					   
					  });

		  	 	};
		  	 
		  	 };

		  });

	  }
	  
	//--------------------------------------------------------------------------------------------------
	self.leerCookie = function (nombre) {
         var lista = document.cookie.split(";"),
         	 micookie;
         for (i in lista) {
             var busca = lista[i].search(nombre);
             if (busca > -1) {micookie=lista[i]}
             }
         var igual = micookie.indexOf("=");
         var valor = micookie.substring(igual+1);
         return valor;
    };

    /**/
    self.date;
	date = new Date();
	date = date.getFullYear() + '-' +
	    ('00' + (date.getMonth()+1)).slice(-2) + '-' +
	    ('00' + date.getDate()).slice(-2);


	self.remplazar = function (texto, buscar, nuevo){
	    var temp = '';
	    var long = texto.length;
	    for (j=0; j<long; j++) {
	        if (texto[j] == buscar) 
	        {
	            temp += nuevo;
	        } else
	            temp += texto[j];
	    }
	    return temp;
	}

	self.validaUrl = function(valor){ 

 		var reg = /https?:\/\/\w{2,}[.?]\w{2,}/g

		var busca = valor.match(reg);		
	 	console.log(busca);

	 	if (busca) {
	 		return true;
	 	} else{
	 		return false;
	 	};
 	}

 	self.validarEmail = function( email ) {
	    expr = /([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})/;
	    if ( !expr.test(email.val()) ){
	    	alert("Error: La dirección de correo " + email.val() + " es incorrecta.");
	    	email.val('');
	    	email.focus();
	    }else{
	    	return true;
	    }	    
	}
	//--------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------
	//no permitir ' en textareas

	/*carateres no permitidos para ciertos campos*/
	self.nopermit = {
 		exp : /['´]/g,
 		search : [],
 		res : '',
 		valida : function(str){ 			
 			this.search = str.match(this.exp);
 			if (this.search) {
 				this.reemplaza(str); 				
		 		return this.res;
		 	}else{
		 		return str;
		 	};
 		}, 		
 		reemplaza : function(str){
 			this.res = str.replace(this.exp, ""); 			
 		}
 	}	
	
	$('textarea').keyup(function(event) {
		$(this).val(nopermit.valida($(this).val()))
	});
	//--------------------------------------------------------------------------------------------------

	//--------------------------------------------------------------------------------------------------
	//funcion para tener autocomplete resultados siempre on top
	self.uiAutocompleteOnTop = function(){
		$(".ui-autocomplete").css('z-index', '1000000');
	}
	//--------------------------------------------------------------------------------------------------

	self.userAdmin = function(){			
		return leerCookie("log_lunelAdmin_IDtipo") === "1" ? true : false;			
	}

	//--------------------------------------------------------------------------------------------------
	//validación de campos que puedan ya existir
	self.validaCampoLike = {
		valor : "",
		nom_campo : "",
		nom_tabla : "",
		cons_validaCampo : "",
		test : true,
		setup : function(nom_campo,nom_tabla,valor){
			validaCampoLike.nom_campo = nom_campo
			validaCampoLike.nom_tabla = nom_tabla
			validaCampoLike.valor = valor

			validaCampoLike.cons_validaCampo = 'select '+validaCampoLike.nom_campo+' from '+validaCampoLike.nom_tabla+' where '+validaCampoLike.nom_campo+' LIKE "%'+validaCampoLike.valor+'%" '

			//console.log(validaCampoLike.cons_validaCampo)
		},
		ejecuta_validar : function(){

			return $.ajax({
				url: '../controller/ajaxController12.php',
				data: "query="+validaCampoLike.cons_validaCampo+"&tipo=consulta_gen",
			})
			.done(function(data) {

			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		},
		valida : function(){

			var ejecucion = this.ejecuta_validar();

			ejecucion.success(function(data){
				
				console.log(data);

				if (data.estado != "Error") {

					validaCampoLike.test = false

					//mostrar las coincidencias
					$("#not_entidades_modal").html("");

					$("#not_entidades_modal").append("Entidades con Nombre Similar: <br>");

					$.each(data.mensaje, function(index, val) {
						 //$("#not_entidades_modal").html("");
						 //var nom = validaCampoLike.nom_campo;
						 console.log("index: "+index+" val: "+val[validaCampoLike.nom_campo])
						 $("#not_entidades_modal").append(val[validaCampoLike.nom_campo]+" - ");
					});

					/*
					$("#"+validaCampoLike.nom_campo).change(function(event) {
						$(this).val("");
					});*/
										
					//alert("El campo "+validaCampoLike.nom_campo+" que ha ingresado ya existe y no se puede duplicar. Por favor ingrese un valor diferente.");
				}else{

					validaCampoLike.test = true

					$("#not_entidades_modal").html("");

					$("#not_entidades_modal").append("No hay entidades con este Nombre.");

					//$("#"+validaCampoLike.nom_campo).unbind("change");
				};

			});	
		}

	}
	//--------------------------------------------------------------------------------------------------

})();

//-------------------------------------------------------------
//funciones globales generales bd
(function(){
	//funcion para hacer consultas a la bd de forma general.
	self.dbGen={

		db_general:function(query){

			return $.ajax({
				async: false,
		        url: '../controller/ajaxController12.php',
		        data: "query="+query+"&tipo=consulta_gen",
		    })
		    .done(function(data) {	   
		    })
		    .fail(function() {
		        console.log("error");
		    })
		    .always(function() {
		        console.log("complete");
		    });
		}
	}

})();
//-------------------------------------------------------------

//-------------------------------------------------------------
//
(function(){

	//---------------------------------------------------------------
    //clase para hacer selecciones de muchos a muchos

	self.matrixRelation = function(seleccionador,btn_accion,nombre_modulo,nombre_modulo2,formulario_add,nombre_tabla,obtHE){

		this.seleccionador = seleccionador;
		this.btn_accion = btn_accion;
		this.nombre_modulo = nombre_modulo;
		this.nombre_modulo2 = nombre_modulo2;
		this.formulario_add = formulario_add;
		this.nombre_tabla = nombre_tabla;
		this.obtHE = obtHE;
		this.id = 0;
    	this.nombre = "";
    	this.arrElementos = [];
    	this.arrElementosRelation = [];
    	//-----------------------------------
    	this.selector_id_usuario = "pkID";
    	//-----------------------------------
    	this.msg_err_consulta = "En este momento no hay registros.";
    	this.msg_err_consulta_clase = "warning";
	}

	self.matrixRelation.prototype = {

		valida_accion: function(){
	    	return $("#"+this.btn_accion).attr("data-action");	    	
	    },
	    valida_elemento : function(){
	    	//console.log(id)
	    	//console.log(nombre)
	    	
	    	if(document.getElementById("fkID_"+this.nombre_modulo+"_"+this.id)){
	    		return true;
	    	}else{
	    		return false;
	    	}

	    },
		setup : function() {

			var self = this;

		    $("#"+this.seleccionador).change(function(event){

		    	self.setup_change(this);

		    });
		},
		setup_change : function(elem){

			this.id = $(elem).val()
			this.nombre = $(elem).find("option:selected").data('nombre')
			
			var accion = this.valida_accion();

			console.log(accion)
			/**/
			if ( accion == "crear" ) {

				this.select_elemento('select',accion)

				//console.log(accion)

			} else if ( accion == "editar" ) {
				
				this.arrElementos.length = 0;
								
				//this.serializa_array(this.crea_array(this.arrElementos,this.getIdUsuario()),false);
				//console.log(this.crea_array(this.arrElementos,this.getIdUsuario()))
				//console.log(this.serializa_array(this.crea_array(this.arrElementos,this.getIdUsuario()),false))

				var btn_rm_frm = this.select_elemento('load',0);

				console.log(btn_rm_frm)

				var numReg_insertado = this.serializa_array(this.crea_array(this.arrElementos,this.getIdUsuario()),false);

				$("[name*='"+btn_rm_frm+"']").attr('data-numreg', numReg_insertado);

			}
		},
		getIdUsuario : function(){
			return $("#"+this.selector_id_usuario).val();
		},
		setSelectorIdUsuario : function(selector){
			this.selector_id_usuario = selector;
		},
		select_elemento : function(type,numReg) {

	    	//console.log(" ")

	    	var self = this;

	    	var rand = Math.round(Math.random()*10)

	    	var rand1 = Math.round(Math.random()*10)

	    	var idInputFrm = "";
	    	var nameBtnRm = "";

			if(this.id!=""){

				if (this.valida_elemento()) {
	    			alert("Este elemento ya fue seleccionado.")
	    		} else {
	    			
	    			if (type=='select') {

	    				var frm = 'frm_group'+this.id+rand*rand1;

	    				$("#"+this.formulario_add).append(
	    					'<div class="form-group" id="'+frm+'">'+		                
				                '<input type="text" style="width: 90%;display: inline;" class="form-control" id="fkID_'+this.nombre_modulo+'_'+this.id+'" name="fkID_'+this.nombre_modulo+'" value="'+this.nombre+'" readonly="true"> <button name="btn_actionRm_'+this.id+frm+'" data-id-'+this.nombre_modulo+'="'+this.id+'" data-id-frm-group="'+frm+'" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>'+		                
				            '</div>'
	    				);

	    			}else {

	    				var frm = 'frm_group'+this.id+rand*rand1;
	    				
	    				idInputFrm = 'fkID_'+this.nombre_modulo+'_'+this.id;

	    				//btn_actionRm_'+this.id+frm

	    				nameBtnRm = 'btn_actionRm_'+this.id+frm;


	    				$("#"+this.formulario_add).append(
							'<div class="form-group" id="frm_group'+this.id+frm+'">'+		                
				                '<input type="text" style="width: 90%;display: inline;" class="form-control" id="'+idInputFrm+'" name="fkID_'+this.nombre_modulo+'" value="'+this.nombre+'" readonly="true"> <button name="btn_actionRm_'+this.id+frm+'" data-id-'+this.nombre_modulo+'="'+this.id+'" data-id-frm-group="frm_group'+this.id+frm+'" data-numReg = "'+numReg+'" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>'+		                
				            '</div>'
				        );
	    			}
	    			
	    			$("[name*='btn_actionRm_"+this.id+frm+"']").click(function(event) {
						//tarea identificador unico?? para poderlo remover
						console.log('click remover '+$(this).data('id-frm-group'));
						
						self.remove_elemento($(this).data('id-frm-group'));
						/**/
						//buscar el indice
						var id_elemento = $(this).attr("data-id-"+self.nombre_modulo);
						console.log('el elemento es:'+id_elemento);
						var indexArr = self.arrElementos.indexOf(id_elemento);
						console.log("El indice encontrado es:"+indexArr);
						//quitar del array
						if(indexArr >= 0){
							self.arrElementos.splice(indexArr,1);
							console.log(self.arrElementos);
						}else{
							console.log('salio menor a 0');
							console.log(self.arrElementos);
						}

						if (type=='load') {
							// statement
							numReg = $(this).data('numreg');

							self.deleteElementoNumReg(numReg);
						}
						
					});

					this.arrElementos.push(this.id);
					console.log(this.arrElementos);
					//---------------------------------------

	    		}

			}else{
	    		alert("No se seleccionó ningún elemento.")
	    	}

	    	if (this.valida_accion() == "editar") {
	    		return nameBtnRm;
	    	}
		},
		remove_elemento : function(id_elem){
	    	$("#"+id_elem).remove();
	    	//console.log($("#"+id_elem))
	    },
	    deleteElementoNumReg : function(numReg){

	    	var self = this;
    	
	    	$.ajax({
	            url: '../controller/ajaxController12.php',
	            data: "pkID="+numReg+"&tipo=eliminar&nom_tabla="+self.nombre_tabla,
	        })
	        .done(function(data) {            
	            //---------------------
	            console.log(data);

	            alert(data.mensaje.mensaje);
	            
	            //location.reload();
	        })
	        .fail(function() {
	            console.log("error");
	        })
	        .always(function() {
	            console.log("complete");
	        });
	    },
	    serializa_array : function(array,recarga){

	    	var self = this;

	    	var cadenaSerializa = "";

	    	var numReg_edita = 0;	    	

	    	var accion = this.valida_accion();

	  		var ciclo_array = $.each(array, function(index, val) {

	  			var dataCadena = "";

	  			$.each(val, function(llave, valor) {
			 	          	 
				 	console.log("llave="+llave+" valor="+valor);

				 	dataCadena = dataCadena+llave+"="+valor+"&";	          	 	 	          	 	
				 	//insertaEstudio(cadenaSerializa);
				});

				dataCadena = dataCadena.substring(0,dataCadena.length - 1);

				console.log(dataCadena);
								
				numReg_edita = self.inserta_serializa(dataCadena);			

	  		});

	  		$.when(ciclo_array).then(function(){
	  			console.log(" Terminó la inserción.")
	  			if (recarga) {
	  				location.reload()
	  			}
	  		});	  		
	  		
	  		if (accion == "editar") {

	        	return numReg_edita;

	    	};
	    },
	    crea_array : function(array,id){

	    	var self = this;
    	
			this.arrElementosRelation = [];

			array.forEach(function(element, index){				

				var strObjt = '{"fkID_'+self.nombre_modulo+'":'+element+',"fkID_'+self.nombre_modulo2+'":'+id+'}';

				console.log(strObjt)

				var convObjt = JSON.parse(strObjt); 
			
				self.obtHE = convObjt;
				//setobtHE(convObjt)

				self.arrElementosRelation.push(self.obtHE);
				//getArrElementosRelation().push(getobtHE());

			});

			//console.log(matrixRelation.arrElementosRelation);

			return this.arrElementosRelation;
	    },
	    inserta_serializa : function(data){

	    	var self = this;
	    	var numReg = 0;

	    	$.ajax({
	    	  async: false,
	          url: "../controller/ajaxController12.php",
	          data: data+"&tipo=inserta&nom_tabla="+self.nombre_tabla,
	        })
	        .done(function(data) {	          
	          //---------------------

	          //alert(data[0].mensaje);
	          //location.reload();
	          if (self.valida_accion() == "editar") {
	          	alert(data[0].mensaje);
	          	//location.reload();
	          	console.log(data[0].last_id);
	          	numReg = data[0].last_id;

	          	//$("[name*='btn_actionRm_3frm_group310']").attr('data-numreg', 90)			
	          }          
	        })
	        .fail(function(data) {
	          console.log(data);	          
	          //alert(data[0].mensaje);          
	        })
	        .always(function() {
	          console.log("complete");
	        });

	        if (self.valida_accion() == "editar") {

	        	return numReg;

	    	};
	    },
	    carga_elementos : function(query){
    		
    		var self = this;

	        $.ajax({
		        url: '../controller/ajaxController12.php',
		        data: "query="+query+"&tipo=consulta_gen",
		    })
		    .done(function(data) {	    	

		    	console.log(data);	    	

		    	$("#"+self.formulario_add).html("");

		    	$("#"+self.seleccionador).attr('data-accion', 'load');

		    	self.arrElementos.length = 0;
			    self.arrElementosRelation.length=0;

		    	if(data.estado != "Error"){	    	
			    	/**/
			    	for(var i = 0; i < data.mensaje.length; i++){

			    		self.id = data.mensaje[i].pkID;
			    		self.nombre = data.mensaje[i].nombre;
			    		
			    		self.select_elemento($("#"+self.seleccionador).data('accion'),data.mensaje[i].numReg);
			    	}

		    	}else{

		    		var msg_err = '<div class="alert alert-'+self.msg_err_consulta_clase+'" role="alert">'+self.msg_err_consulta+'</div>';
		    	
		    		$("#"+self.formulario_add).append(msg_err);
		    	}
		   
		    })
		    .fail(function() {
		        console.log("error");
		    })
		    .always(function() {
		        console.log("complete");
		    });
	    },
	    setMsgError : function(msg){
	    	this.msg_err_consulta = msg;
	    },
	    setMsgErrorClase : function(clase){
	    	this.msg_err_consulta_clase = clase;
	    },
	    resetRel: function(){	    	
	    	//limpia el form
		  	$("#"+this.formulario_add).html("");
		  	//setea el valor de los arrays
			this.arrElementos.length = 0;
			this.arrElementosRelation.length=0;
	    }
		
	}

})();
//-------------------------------------------------------------

//-------------------------------------------------------------
(function(){
	self.temaAgenda = function(btn_add, div_add){
		this.btn_add = btn_add;
		this.div_add = div_add;
		//------------------------------
		this.nom_tabla = "temas";
	}

	self.temaAgenda.prototype = {

		setUp: function(){

			var self = this;

			this.btn_add.click(function(event) {

				self.div_add.append(self.createFormItem());

				//retira el evento click para cada btn y que no 
				//queden duplicados.
				$(".btn_rm_tema").unbind('click');

				//listener click del btn remove tema
				$(".btn_rm_tema").click(function(event) {
					//console.log($(this).data('id-tema'));
					var id_frm = $(this).data('id-frm');					
					//confirmarle al usuario si desea o no eliminar el tema de la agenda
					var confirma = confirm("Realmente quiere eliminar este tema?");

					if (confirma) {						
						$("#"+id_frm).remove()						
					}
					
				});

			});
		},
		createFormItem: function(){
			var idForm_item = "frm_item_agenda_"+this.randItemId(3000);

			return '<form id="'+idForm_item+'" class="form-horizontal" >'+
						this.createBtnRmTema(idForm_item)+
						this.createDivItem(this.createInputpkID(), true)+
						this.createDivItem(this.createFkIreunion(), true)+
						this.createDivItem(this.createTextTema()+this.createSelectPro(), false)
						//this.createDivItem(, false)
					+'</form>'
		},
		createBtnRmTema: function(id_frm){
			
			return '<button type="button" title="Eliminar Tema" class="close btn_rm_tema" data-dismiss="alert" aria-label="Close" data-id-frm="'+id_frm+'">'+
				   		'<span aria-hidden="true">&times;</span>'+
				   '</button>';
		},
		createDivItem: function(item, hidden){
			var idDivGroup = "div_group_"+this.randItemId(3000);
			
			hidden = hidden ? "hidden='true'" : "";
			clss = !hidden ? "div-group-tema-agenda" : "";

			return '<div class="form-group '+clss+'" id="'+idDivGroup+'" '+hidden+'>'+item+'</div>';
		},
		createInputpkID: function(){
			var idPkIdInput = "id_input_pkID_agenda_"+this.randItemId(3000);

			return '<input type="text" class="form-control" id="'+idPkIdInput+'" name="pkID">';
		},
		createFkIreunion: function(){
			var idFkId_Reunion = "id_fkid_reunion_"+this.randItemId(4000);

			return '<input type="text" class="form-control" id="'+idFkId_Reunion+'" name="fkID_reunion">';
		},
		createTextTema: function(){
			var id_text_tema = "id_text_tema_"+this.randItemId(5000);

			return '<label class="col-md-1 control-label">Tema</label> <div class="col-sm-5"> <textarea id="'+id_text_tema+'" name="tema" class="form-control" placeholder="Tema a tratar"></textarea> </div>';
		},
		createSelectPro: function(){			

			var id_select_pro = "id_select_pro_"+this.randItemId(500);

			return '<label class="col-md-1 control-label">Proyecto</label> <div class="col-sm-4"> <select id="'+id_select_pro+'" name="fkID_proyecto" class="form-control" required="true">'+
						this.getOptionSelPro()+
				   '</select> </div>';
		},
		getOptionSelPro: function(){
			var opts = '<option value="0">Administrativo</option>';
			//dbGen db_general
			var opts_sel = dbGen.db_general("SELECT pkID, nombre FROM `proyectos`");

			opts_sel.success(function(data){
				console.log(data)

				if (data.estado == "ok") {
					$.each(data.mensaje, function(index, val) {
						//console.log(index)
						//console.log(val)

						opts += '<option value="'+val.pkID+'">'+val.nombre+'</option>';
					});
				} else {
					opts += '<option> -- </option>';
				}
			})

			//console.log(opts)
			return opts;
		},
		randItemId: function(mult){
			return Math.round(Math.random()*mult)
		},
		insertAgenda: function(fkID_reunion, recarga){
			/*crea un objeto con todos los formularios frm_item_agenda_
			y agregar el id de la reunion recien creada
			*/
			var self = this;

			this.setFkidReu(fkID_reunion)
			/**/
			//serializar los forms para insertar
			var arr_serializa_forms = this.serializaForms();
			
			console.log(arr_serializa_forms);

			var it_forms = $.each(arr_serializa_forms, function(index, val) {
				console.log(val)

				self._ajaxA(val).success(function(data){
					console.log(data)
				})
			});		
			
			$.when(it_forms).then(function(){
				if (recarga) {
					location.reload()
				}
			});
			
		},
		loadAgenda: function(fkID_reunion){

			var self = this;

			var query = "SELECT * FROM `temas` WHERE fkID_reunion = "+fkID_reunion;

			var loadA = dbGen.db_general(query);

			loadA.success(function(data){
				console.log(data)

				if (data.estado == "ok") {

					self.resetDivAdd();

					$.each(data.mensaje, function(index, val) {
														
						self.div_add.append(self.createFormItem());
					});

					self.createAnLoadDataFrm(data.mensaje)

				} else {
					self.resetDivAdd();
				}
			})
		},
		createAnLoadDataFrm: function(data){		

			//
			var self = this;
			var forms = $("[id*='frm_item_agenda_']")
			//console.log(forms)

			$.each(forms, function(index, val) {
				
				//console.log(index)
				
				//console.log(val["id"])

				$("#"+val["id"]).prepend('<button type="button" title="Eliminar Tema" class="close btn_rm_tema" data-dismiss="alert" aria-label="Close" data-id-tema="'+data[index]["pkID"]+'" data-id-frm="'+val["id"]+'">'+
										  '<span aria-hidden="true">&times;</span>'+
										 '</button>');						

				$.each(val, function(llave, valor) {
					//console.log(llave)
					//console.log(valor["id"])
					//console.log(valor["name"])
					$("#"+valor["id"]).val(data[index][valor["name"]]).attr('disabled', 'true');
					//console.log(data[index][valor["name"]])
				});
			});

			//listener click del btn remove tema
			$(".btn_rm_tema").click(function(event) {
				//console.log($(this).data('id-tema'));
				var id_frm = $(this).data('id-frm');
				var data_del = "pkID="+$(this).data('id-tema')+"&tipo=eliminar&nom_tabla="+self.nom_tabla;
				//confirmarle al usuario si desea o no eliminar el tema de la agenda
				var confirma = confirm("Realmente quiere eliminar este tema?.");

				if (confirma) {
					self._ajaxA(data_del).success(function(data){
						console.log(data)
						alert(data.mensaje.mensaje)
						$("#"+id_frm).remove()
					})	
				}
				
			});
		},
		resetDivAdd: function(){
			this.div_add.html("");
		},
		setFkidReu: function(fkID_reunion){
			//id_fkid_reunion_
			var arr_inputs = $("[id*='id_fkid_reunion_']");
			//console.log(arr_inputs);
			/**/
			$.each(arr_inputs, function(index, val) {
				 //console.log(val["id"])
				 $("#"+val["id"]).val(fkID_reunion)
			});
		},
		serializaForms: function(){
			var self = this;
			var res = [];
			var arr_frm = $("[id*='frm_item_agenda_']");

			$.each(arr_frm, function(index, val) {
				 //console.log(val["id"])
				 res.push($("#"+val["id"]).serialize()+"&tipo=inserta&nom_tabla="+self.nom_tabla);				 
			});

			//console.log(res)
			return res;
		},
		_ajaxA: function(data){
			/**/
			return $.ajax({
	    	  async: false,
	          url: "../controller/ajaxController12.php",
	          data: data,
	        })
	        .done(function(data) {	          
	          //---------------------	                  
	        })
	        .fail(function(data) {
	          console.log(data);	          
	          //alert(data[0].mensaje);          
	        })
	        .always(function() {
	          console.log("complete");
	        });		
		}
	}

})();
//-------------------------------------------------------------



//-------------------------Compromisos-------------------------
(function(){
	self.compromisoReunion = function(btn_add, div_add, btn_action){
		this.btn_add = btn_add;
		this.div_add = div_add;
		this.btn_action = btn_action;
		//------------------------------
		this.nom_tabla = "compromisos";
		//------------------------------
		this.not_msg = "Enviando los correos correspondientes, por favor espere...";
		this.clase_not = "warning";
		//------------------------------
		this.btn_add_count = 0;
	}

	self.compromisoReunion.prototype = {

		setUp: function(){

			var self = this;

			//this.btn_add_count = 0;

			this.btn_add.click(function(event) {

				if (self.validateParticipantes()) {

					self.btn_add_count+=1;

					self.div_add.append(self.createFormItem("crear"));				

					$("[id*='id_fecha_cumplimiento_']").datepicker({
						dateFormat: "yy-mm-dd",
						yearRange: "1930:2040",
				    	changeYear: true,
						minDate: 0			
					});

					$(".btn_rm_compromiso").unbind('click')

					//listener click del btn remove tema
					$(".btn_rm_compromiso").click(function(event) {
						//console.log($(this).data('id-tema'));
						var id_frm = $(this).data('id-frm');
						
						//confirmarle al usuario si desea o no eliminar el tema de la agenda
						var confirma = confirm("Realmente quiere eliminar este compromiso?");

						if (confirma) {							
							$("#"+id_frm).remove()							
						}
						
					});

				} else {
					alert("No se puede añadir compromisos sin particpantes.")
				}				

			});
		},
		validateParticipantes: function(){
			if ($("[id*='fkID_usuario_']").length > 0) {
				return true;
			} else {
				return false;
			}
		},
		createFormItem: function(type){
			//var action = this.getActionBtn();
			var idForm_item = "frm_item_compromiso_"+this.randItemId(3000);
			var envia_mail = type === "crear" ? "data-mail-send='true'" : "data-mail-send='false'";
			
			return '<form id="'+idForm_item+'" class="col-md-12 form-horizontal" '+envia_mail+'>'+
						this.createBtnRmComrpromiso(idForm_item)+
						this.createDivItem(this.createInputpkID(), true)+
						this.createDivItem(this.createFkIdparticipantes()+this.createFechaCumplimiento(), false)+
						this.createDivItem(this.createFkIreunionC(), true)+
						//this.createDivItem(, false)+
						this.createDivItem(this.createTextDescripcion(), false)+
						this.createDivItem(this.createSelectEst(), true)
					+'</form>'
		},
		createBtnRmComrpromiso: function(id_frm){
			return '<button type="button" title="Eliminar Compromiso" class="close btn_rm_compromiso" data-dismiss="alert" aria-label="Close" data-id-frm="'+id_frm+'">'+
				  '<span aria-hidden="true">&times;</span>'+
				 '</button>';
			
		},
		createDivItem: function(item, hidden){
			var idDivGroup = "div_group_"+this.randItemId(3000);
			
			hidden = hidden ? "hidden='true'" : "";
			clss = !hidden ? "div-group-compromiso-reunion" : "";

			return '<div class="col-md-12 '+clss+'" id="'+idDivGroup+'" '+hidden+'>'+item+'</div>';
		},
		createInputpkID: function(){
			var idPkIdInput = "id_input_pkID_compromiso_"+this.randItemId(3000);

			return '<input type="text" class="form-control" id="'+idPkIdInput+'" name="pkID">';
		},
		createFkIdparticipantes: function(){
			var id_select_participante = "id_select_participante_"+this.randItemId(500);

			return '<label class="col-md-2 control-label">Responsable</label> <div class="col-sm-4"> <select id="'+id_select_participante+'" name="fkID_usuario" class="form-control" required="true">'+
						this.getOptionSelPar()+
				   '</select> </div>';
		},
		getOptionSelPar: function(){

			var opts = '<option value="0"></option>';			

			var query = this.validateActionOpt();					

			var opts_sel = dbGen.db_general(query);
			/**/		

			opts_sel.success(function(data){
				console.log(data)

				if (data.estado == "ok") {
					$.each(data.mensaje, function(index, val) {
						//console.log(index)
						console.log(val.pkID);

						opts += '<option value="'+val.pkID+'">'+val.nombre+' '+val.apellido+'</option>';
					});
				} else {
					opts += '<option> -- </option>';
				}
			})

			//console.log(opts)
			return opts;
		},
		validateActionOpt:function(){
			
			var action = this.getActionBtn();
			
			var res = "";
			
			console.log(this.btn_add_count)

			if ( ((action == "crear") || (action == "editar")) && (this.btn_add_count > 0) ) {
				var cons = "SELECT pkID, nombre, apellido FROM `usuarios` WHERE ";
				var cond = " pkID = "+rel_reuniones.arrElementos.join(" OR pkID = ");
				console.log(cons+cond)
				res = cons+cond;
			}
			else if ( (action == "editar") && (this.btn_add_count == 0) ){
				res = "select * from usuarios";
			}

			return res;
		},
		getActionBtn: function(){
			return $("#btn_actionreunion").attr("data-action");
		},
		createFkIreunionC: function(){
			var idFkId_ReunionC = "id_fkid_reunion_"+this.randItemId(4000);

			return '<input type="text" class="form-control" id="'+idFkId_ReunionC+'" name="fkID_reunion">';
		},
		createFechaCumplimiento: function(){
			var idFecha_Cumplimiento = "id_fecha_cumplimiento_"+this.randItemId(4000);

			return '<label class="col-md-2 control-label">Fecha de Cumplimiento</label>  <div class="col-sm-4"> <input type="text" class="form-control" id="'+idFecha_Cumplimiento+'" name="fecha_cumplimiento"> </div>';
		},
		createTextDescripcion: function(){
			var descripcion = "id_text_descripcion_"+this.randItemId(5000);

			return '<label class="col-md-2 control-label">Descripción</label> <div class="col-sm-10"> <textarea id="'+descripcion+'" name="descripcion" class="form-control" placeholder="Descripción del Compromiso"></textarea> </div>';
		},
		createSelectEst: function(){			

			var id_select_estado = "id_select_estado_"+this.randItemId(500);

			return '<label class="control-label">Estado</label> <select id="'+id_select_estado+'" name="fkID_estado" class="form-control" required="true" >'+
						this.getOptionSelEst()+
				   '</select>';
		},
		getOptionSelEst: function(){
			var opts = '<option value="1"></option>';
			//dbGen db_general
			var opts_sel = dbGen.db_general("SELECT pkID, nombre FROM `estado_compromiso`");

			opts_sel.success(function(data){
				console.log(data)

				if (data.estado == "ok") {
					$.each(data.mensaje, function(index, val) {
						//console.log(index)
						//console.log(val)

						opts += '<option value="'+val.pkID+'">'+val.nombre+'</option>';
					});
				} else {
					opts += '<option> -- </option>';
				}
			})

			//console.log(opts)
			return opts;
		},
		randItemId: function(mult){
			return Math.round(Math.random()*mult)
		},
		insertCompromiso: function(fkID_reunion, recarga){
			/*crea un objeto con todos los formularios frm_item_agenda_
			y agregar el id de la reunion recien creada
			*/
			var self = this;

			this.setFkidReu(fkID_reunion)
			/**/
			//serializar los forms para insertar
			var arr_serializa_forms = this.serializaForms();
			
			console.log(arr_serializa_forms);

			if (arr_serializa_forms.length > 0) {

				var it_forms = $.each(arr_serializa_forms, function(index, val) {
					console.log(val)

					self._ajaxA(val).success(function(data){
						console.log(data)
						//toma los datos para enviar el correo de asignacion
						//de compromisos.
					})
				});		
				
				$.when(it_forms).then(function(){
					console.log("Termino de iterar compromisos, btn_add_count: "+self.btn_add_count)
					//"pkID_usuario=1&tipo_asunto=1&fkID_reunion=14&tipo_cuerpo=asignado"
					if (self.btn_add_count > 0) {
						self.sendEmailCompromisos(fkID_reunion, 1, "asignado");
					}else{
						location.reload()
					}				

					if (recarga) {
						location.reload()
					}
				});

			} else {
				console.log("No hay nada que insertar.")
				location.reload()
			}
			
		},
		sendEmailCompromisos: function(fkID_reunion, tipo_asunto, tipo_cuerpo){
			var self = this;
			//revisa todos los imputs con id que empiece por id_select_participante_
			var ite_sel_participante = $.each(self.getIdsPartCompromisos(), function(index, val) {
				console.log(val)
				var data_options = "pkID_usuario="+val+"&tipo_asunto="+tipo_asunto+"&fkID_reunion="+fkID_reunion+"&tipo_cuerpo="+tipo_cuerpo+"&pkID_compromiso=0";
				self._send(data_options, true).success(function(data){
					
					console.log(data)
				})
			});
		},
		getIdsPartCompromisos: function(){
			
			var res = [];

			$.each($("[id*='id_select_participante_']"), function(index, val) {				
				//console.log(val["value"])
				//console.log($("#"+val["id"]).parent().parent().attr("data-mail-send"))
				//valida si el form esta para enviar mail o no
				if ($("#"+val["id"]).parent().parent().parent().attr("data-mail-send") === "true") {
					
					var pos = res.indexOf(val["value"]);

					if (pos === -1) {
						res.push(val["value"])
					}

				}				
				
			})

			return res;
		},	
		loadCompromiso: function(fkID_reunion){

			var self = this;

			this.btn_add_count = 0;

			var query = "SELECT compromisos.*, CONCAT(usuarios.nombre,' ',usuarios.apellido) as nom_usuario FROM `compromisos` INNER JOIN usuarios ON usuarios.pkID = compromisos.fkID_usuario WHERE fkID_reunion = "+fkID_reunion;

			var loadA = dbGen.db_general(query);

			loadA.success(function(data){
				console.log(data)

				if (data.estado == "ok") {

					self.resetDivAdd();

					$.each(data.mensaje, function(index, val) {
														
						self.div_add.append(self.createFormItem("cargar"));
					});
					
					self.createAnLoadDataFrmC(data.mensaje)

				} else {
					self.resetDivAdd();
				}
			})
		},		
		createAnLoadDataFrmC: function(data){		

			//
			var self = this;
			var forms = $("[id*='frm_item_compromiso_']")
			//console.log(forms)

			$.each(forms, function(index, val) {
				
				//console.log(index)
				
				//console.log(val["id"])
				if (userAdmin()) {
					$("#"+val["id"]).prepend('<button type="button" title="Eliminar Compromiso" class="close btn_rm_compromiso" data-dismiss="alert" aria-label="Close" data-id-compromiso="'+data[index]["pkID"]+'" data-id-frm="'+val["id"]+'">'+
										  '<span aria-hidden="true">&times;</span>'+
										 '</button>');
				}						

				$.each(val, function(llave, valor) {
					
					$("#"+valor["id"]).val(data[index][valor["name"]]).attr('disabled', 'true');
					
				});
				
			});

			//listener click del btn remove tema
			$(".btn_rm_compromiso").click(function(event) {
				//console.log($(this).data('id-tema'));
				var id_frm = $(this).data('id-frm');
				var data_del = "pkID="+$(this).data('id-compromiso')+"&tipo=eliminar&nom_tabla="+self.nom_tabla;
				//confirmarle al usuario si desea o no eliminar el tema de la agenda
				var confirma = confirm("Realmente quiere eliminar este compromiso?.");

				if (confirma) {
					self._ajaxA(data_del).success(function(data){
						console.log(data)
						alert(data.mensaje.mensaje)
						$("#"+id_frm).remove()	
					})	
				}
				
			});
		},
		resetDivAdd: function(){
			this.div_add.html("");
			this.btn_add_count=0;
		},
		setFkidReu: function(fkID_reunion){
			//id_fkid_reunion_
			var arr_inputs = $("[id*='id_fkid_reunion_']");
			//console.log(arr_inputs);
			/**/
			$.each(arr_inputs, function(index, val) {
				 //console.log(val["id"])
				 $("#"+val["id"]).val(fkID_reunion)
			});
		},
		serializaForms: function(){
			var self = this;
			var res = [];
			var arr_frm = $("[id*='frm_item_compromiso_']");

			$.each(arr_frm, function(index, val) {
				 //console.log(val["id"])
				 res.push($("#"+val["id"]).serialize()+"&tipo=inserta&nom_tabla="+self.nom_tabla);				 
			});

			//console.log(res)
			return res;
		},
		_ajaxA: function(data){
			/**/
			return $.ajax({
	    	  async: false,
	          url: "../controller/ajaxController12.php",
	          data: data,
	        })
	        .done(function(data) {	          
	          //---------------------	                  
	        })
	        .fail(function(data) {
	          console.log(data);	          
	          //alert(data[0].mensaje);          
	        })
	        .always(function() {
	          console.log("complete");
	        });		
		},
		//"pkID_usuario=1&tipo_asunto=1&fkID_reunion=14&tipo_cuerpo=asignado"
		_send: function(data, recarga){
			/**/
			var self = this;
			//this.div_add = div_add;
			//this.btn_action = btn_action;
			
			var msg_err = '<div id="not_email_comp" class="alert alert-'+self.clase_not+'" role="alert">'+self.not_msg+'</div>';
			
			return $.ajax({
	    	  //async: false,
	          url: "../controller/ajaxController12.php",
	          data: data+"&tipo=email_compromisos",
	          beforeSend: function(){

	          	if(document.getElementById("not_email_comp") == null){
		    		self.div_add.append(msg_err);
		    		console.log("no hay div notificacion")
		    	}else{
		    		console.log("si hay div notificacion")
		    	}

	          	self.btn_action.attr('disabled', 'true');
	          }
	        })
	        .done(function(data) {	          
	          //---------------------
	          //console.log(data)

	          if (recarga) {
	          	location.reload()
	          }	                  
	        })
	        .fail(function(data) {
	          console.log(data);	          
	          //alert(data[0].mensaje);          
	        })
	        .always(function() {
	          console.log("complete");
	        });
		}
	}

})();


//-------------------------------------------------------------
//ejemplo de clases privadas
/*
(function(){

	self.clase = function(){

		saluda = "hola";

		_comp = function(){
			//return saluda+" mundol";
			console.log(saluda)
		}

		this.execomp = function(){
			_comp()
		}
	}

})();

self.cl = new clase();*/
//-------------------------------------------------
//prueba apply call bind
/*
var persona = {
	nombre:"Johan",
	saludar:function(apell1,apell2){
		console.log("El nombre es "+this.nombre+" "+apell1+" "+apell2)
	}
}

//en esta variable solo se llama la funcion saludar
//la cual queda sin contexto
var saluda = persona.saludar;
	
//call define el contexto de la función
saluda.call(persona, 'Morales', 'Rodríguez');
//saluda('Morales', 'Rodríguez')*/
//-------------------------------------------------

//
//-------------------------------------------------------------

//-------------------------------------------------------------
//envio de correo reuniones


self.correoReuniones = function(){

}

self.correoReuniones.prototype = {
	//"pkID_usuario=1&tipo_asunto=1&fkID_reunion=14&tipo_cuerpo=asignado"
	_send: function(data){
		/**/
		return $.ajax({
    	  async: false,
          url: "../controller/ajaxController12.php",
          data: data+"&tipo=email_compromisos",
        })
        .done(function(data) {	          
          //---------------------
          console.log(data)	                  
        })
        .fail(function(data) {
          console.log(data);	          
          //alert(data[0].mensaje);          
        })
        .always(function() {
          console.log("complete");
        });
	}
};
//-------------------------------------------------------------
//funcionalidad de las tabs en las vistas con pestañas
(function(){

	self.tabs = {
		nombre_storage : "",
		id_li_activo :  null,
		arr_no_permit : [],
		nom_tab_default : "",
		value_tab : true,
		valida_tab : function(){

			this.id_li_activo = sessionStorage.getItem(this.nombre_storage);

			console.log(this.id_li_activo)

			$.each(this.arr_no_permit, function(index, val) {
				
				console.log("index: "+index+" valor: "+val);

				
				if (val == tabs.id_li_activo) {

					/*break;*/
					//le da clase activa a default
					$("#"+tabs.nom_tab_default).addClass('active');
					
					//console.log(tabs.nom_tab_default.substr(3))

					var nom_gen = tabs.nom_tab_default.substr(3);
					
					$("#"+nom_gen).addClass('active');

					tabs.value_tab = false;

					return false;								

				}else{

					tabs.value_tab = true;
				} 

				
			});

			if (this.value_tab) {
				//console.log(tabs.id_li_activo)

				$("#"+tabs.id_li_activo).addClass('active');

				$('ul a[href="#'+tabs.id_li_activo.slice(3,20)+'"]').tab('show');

				$("#"+tabs.id_li_activo.slice(3,20)).addClass('active');

			}

		},
		setClickRole : function(){

			$("[role=presentation]").click(function(event) {
				/* Act on the event */
				tabs.id_li_activo = $(this)[0].id;

				console.log($(this)[0].id);

				// Store
				sessionStorage.setItem(tabs.nombre_storage, $(this)[0].id);
			});

		},
		setTabs : function(){

			this.valida_tab()

			this.setClickRole();
		}		

	}
	
})();
//-------------------------------------------------------------

//--------------------------------------------------------------------
(function(){
	//helper para novedades u observaciones

	self.follow = function(selector,btn_nuevo,parentModal,selectorModal,nomTabla,btn_action){

		this.selector = selector;
		this.btn_nuevo = btn_nuevo;
		this.parentModal = parentModal;
		this.selectorModal = selectorModal;
		this.nomTabla = nomTabla;		
		this.btn_action = btn_action;
		//valores por defecto en el form
		this.selectorFecha = "fecha_observacion";
		this.selectorIdOwner = "pkIDObservacionOwner";
		this.selectorNewNovedad = "novedadNuevo";
		this.selectorAction = "btn_actionobservacion";
		this.selectorForm = "form_observacion";		
		//variables resultantes
		this.followLast = "";
		this.followFinal = "";				
	}

	self.follow.prototype = {

		newOwner:function(action){

			if (action != "editar") {        		
        		$("#"+this.selector)[0]["value"] = date+" : Creado. -- ";        		
        	};

		},
		hideParent:function(val){			

			if (val == true) {

				$("#"+this.selector).parent().attr('hidden', 'true');				
				$("#"+this.selector).removeAttr('readonly');

			} else {

				$("#"+this.selector).parent().removeAttr('hidden');				
				$("#"+this.selector).attr('readonly', 'true');

			}
			
		},
		newFollow:function(){

			var self = this;

			$("#"+self.selectorFecha).val(date);
			$("#"+self.selectorIdOwner).val($("#pkID").val());

			this.setLastFollow($("#pkID").val())

			//cierra modal papá
			$('#'+self.parentModal).modal('hide');

			$('#'+self.selectorModal).on('hidden.bs.modal', function (e) {
			  //cuando cierra modal muestra papá
			  $('#'+self.parentModal).modal('show');
			});
			//setea la validacion de caracteres no permitidos
			$("#"+this.selectorNewNovedad).keyup(function(event) {  		
		  		$(this).val(validateFollow.valida($(this).val()))
		  	});

		},
		setLastFollow:function(pkID){

			var self = this;

			var cons = "SELECT "+this.selector+" FROM `"+this.nomTabla+"` WHERE pkID = "+pkID;
			//console.log(cons)

			var last = this.dbFollow(cons, "consulta_gen");

			last.success(function(data){
				//console.log(data)
				self.followLast = data.mensaje[0][self.selector];
			})

			//console.log(self.followLast)
		},
		updateFollow:function(){

			var self = this;

			$("#"+this.btn_action).click(function(event) {
				
				var frm_nov = $("#"+self.selectorForm).valida();

  				//console.log(frm_nov);

  				if (frm_nov.estado) {
		  			self.createFollow($("#pkID").val());		  			 
		  		} else {
		  			alert("No se permiten novedades vacías.");
		  		}
			});
		},
		createFollow:function(pkID){
			
			//var self = this;
			
			this.followFinal = this.followLast + $("#"+this.selectorFecha).val() + " : " + $("#"+this.selectorNewNovedad).val() + " -- "; 

			var cons = "UPDATE "+this.nomTabla+" SET "+this.selector+" = '"+this.followFinal+"' WHERE pkID = "+pkID;

			console.log(cons)

			var update = this.dbFollowA(cons);

			update.success(function(data){
				console.log(data)
				alert("El campo se actualizó correctamente.");
	        	location.reload();
			})
		},
		dbFollow:function(query){

			return $.ajax({
				async: false,
		        url: '../controller/ajaxController12.php',
		        data: "query="+query+"&tipo=consulta_gen",
		    })
		    .done(function(data) {    	
		   
		    })
		    .fail(function() {
		        console.log("error");
		    })
		    .always(function() {
		        console.log("complete");
		    });
		},
		dbFollowA:function(query){

			return $.ajax({
				async: false,
		        url: '../controller/ajaxController12.php',
		        data: "query="+query+"&tipo=actualiza_gen",
		    })
		    .done(function(data) {    	
		   
		    })
		    .fail(function() {
		        console.log("error");
		    })
		    .always(function() {
		        console.log("complete");
		    });
		},

	}

	self.validateFollow = {
 		exp : /[#%&!()\/]/g,
 		search : [],
 		res : '',
 		valida : function(str){ 			
 			this.search = str.match(this.exp);
 			if (this.search) {
 				this.reemplaza(str); 				
		 		return this.res;
		 	}else{
		 		return str;
		 	};
 		}, 		
 		reemplaza : function(str){
 			this.res = str.replace(this.exp, ""); 			
 		}
 	}

})();
//--------------------------------------------------------------------


//--------------------------------------------------------------------

(function(){

	//funciones de subida de archivos

	self.funcionesUpload = function(fileupload,btn_accion,selector_form_res,notificador,nom_tabla,fkID){
		//this.data = {};
		this.selector = fileupload;
		this.btn_accion = btn_accion;
		this.selector_form_res = selector_form_res;
		this.notificador = notificador;
		this.nom_tabla = nom_tabla;
		this.fkID = fkID;
		this.action_actual = "";
		this.contDetailName = 0;
		this.arregloDeArchivos = [];
		this.archCoincide = "";
	}

	self.funcionesUpload.prototype = {

		init: function(){

			var self = this;

			$('#'+this.selector).fileupload({
		        dataType: 'json',
		        add: function (e, data) {   

		          self.functionAdd(data)
		                  
		        },
		        done: function (e, data) {            
		            console.log('Load finished.');            
		        }
		    });
		},
		functionAdd : function(data){

			var self = this,

				rand = Math.round(Math.random()*10),

	    		rand1 = Math.round(Math.random()*10);

	    	var frm = 'frm_group_'+this.selector_form_res+rand*rand1;			

			data.context = $("#"+this.selector_form_res).append(

			'<div class="form-group" id="'+frm+'">'+

	    		'<label class="control-label">Nombre para el archivo: '+data.files[0].name+'</label>'+

	    		'<input type="text" class="form-control add-selectElement" name="nombres['+this.contDetailName+']" data-name-file="'+data.files[0].name+'" required="true" /> <button name="btn_actionRm_'+frm+'" data-id-frm-group="'+frm+'" data-name-file="'+data.files[0].name+'" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button> <br>'+

			'</div>'

			);

			this.contDetailName++;

			this.arregloDeArchivos.push(data.files[0]);

			console.log(this.arregloDeArchivos);

			//------------------------------------------------------------
				$("[name*='btn_actionRm_"+frm+"']").click(function(event) {
					//console.log($(this).data('name-file'))
					//console.log($(this).data('id-frm-group'))

					//remueve el elemento del DOM
					self.removeElemento($(this).data('id-frm-group'))
					//console.log(self.indexElemento($(this).data('name-file')))

					//quita el elemento del array de archivos segun el index que indique
					//el nombre del archivo dentro del mismo.
					self.arregloDeArchivos.splice(self.indexElemento($(this).data('name-file')),1);

					console.log(self.arregloDeArchivos)
				});
			//------------------------------------------------------------        	

		},
		removeElemento : function(id_elem){
	    	$("#"+id_elem).remove();	    	
	    },
	    indexElemento : function(searchTerm){
	    	//http://stackoverflow.com/questions/8668174/indexof-method-in-an-object-array
			    index = -1;

			for(var i = 0, len = this.arregloDeArchivos.length; i < len; i++) {
			    if (this.arregloDeArchivos[i].name === searchTerm) {
			        index = i;
			        break;
			    }
			}

			return index;
	    },
	    validateUpload : function(result){
	    	//------------------------------------------------------
	    		var self = this,
	    		    valor = true;

	    		$.each(result.files, function(index, val) {
	    			console.log("index: "+index+" val: "+val)
	    			if(val.error){
	    				console.log("Hubo un error, no se subió el archivo.")
	    				//$("#"+self.notificador).html("Error: No se pudo subir un archivo -> "+val.error)
	    				console.log(val.error)
	    				valor = false;
	    				//return
	    			}else{
	    				console.log("Subió el archivo correctamente.")
	    				//$("#"+self.notificador).html("Ok: Subió el archivo -> "+val.name)
	    			};
	    		});

	    		return valor;
	    	//------------------------------------------------------
	    },
		functionSend : function(id_last,result){

			var self = this;
			//result del send del complemento
			if (this.validateUpload(result)) {

				console.log("Salio todo bien vamos a insertar!")

				//-----------------------------------------------------------------
				var iterate = $.each(this.arregloDeArchivos, function(index, val) {
		          	 
			      	 
			      	 //notificacion de subida de archivo
			      	 $("#"+self.btn_accion).attr('disabled', 'true');

			      	 $("#"+self.notificador).html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
			        												'Guardando registro archivo: '+val.name);
			      	 
			      	 self.getValoresDesc(val.name);
			    
					 //inserta_documento("ruta="+val.name+"&nom_doc="+archCoincide+"&fkID_tipo="+$("#fkID_tipo").val()+"&fkID_subtipo="+$("#fkID_subtipo").val()+"&fkID_proyecto="+$("#fkID_proyecto").val());
					 console.log("url="+val.name+"&nombre="+self.archCoincide+"&"+self.fkID+"="+id_last);

					 var insert = self.inserta_doc("url="+val.name+"&nombre="+self.archCoincide+"&"+self.fkID+"="+id_last);
				
					
					 insert.success(function(data){
					 	console.log(data);
					 });

			    });
				//-----------------------------------------------------------------

			    //-----------------------------------------------------------------
				$.when(iterate).then(subidaOK, subidaFail );

				function subidaOK(){
					//-----------------------------------------------------------------------------------
			        $("#"+self.notificador).html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
			    												' Subida de archivos Realizada con éxito. Por favor espere...');	        
			        
			        setTimeout(function() {
			           location.reload();
			        }, 2000);
			        //-----------------------------------------------------------------------------------
			    }

				function subidaFail(){
					$("#"+self.notificador).html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
			    												'Hubo un error en la creación de registro.');	
				}
				//-----------------------------------------------------------------
				/**/

			} else {
				
				console.log("Algo salió mal!")

				$("#"+self.notificador).html("Error: No se puede(n) subir este(os) archivo(s).")
				
				setTimeout(function() {
		           //location.reload();
		        }, 2000);				
			}		

		},
		getValoresDesc : function(nomArch){

			var self = this;

			console.log("nomArch: "+nomArch)
			
			var nombreControl = "";					

			$.each($("[name*='nombres']"), function(index, val) {
				 
				 nombreControl = $(this).attr("data-name-file");

				 console.log("nombreControl: "+nombreControl)				 

				 if(nomArch == nombreControl){
				 	self.archCoincide = val.value;
				 	console.log("Coicidió: "+val.value)				 	
				 }
			});

		},
		inserta_doc : function(srlz){

			var self = this;
	    		      	
	        return $.ajax({
	          async: false,
	          url: "../controller/ajaxController12.php",
	          data: srlz+"&tipo=inserta&nom_tabla="+self.nom_tabla,                 
	        })
	        .done(function(data) {	          
	          	                   
	        })
	        .fail(function(data) {
	          console.log(data);	          
	        })
	        .always(function() {
	          console.log("complete");
	        });	      

	    },
	    cons_doc : function(query) {
	    	
	    	var self = this;

	    	return $.ajax({
	          async: false,
	          url: "../controller/ajaxController12.php",
	          data: "query="+query+"&tipo=consulta_gen",                 
	        })
	        .done(function(data) {	          
	          	                   
	        })
	        .fail(function(data) {
	          console.log(data);	          
	        })
	        .always(function() {
	          console.log("complete");
	        });

	    },
	    elimina_doc : function(pkID) {
	    	
	    	  var self = this;

		      //si confirma es true ejecuta ajax
		      return $.ajax({
		      		async: false,
		            url: '../controller/ajaxController12.php',
		            data: "pkID="+pkID+"&tipo=eliminar&nom_tabla="+self.nom_tabla,
		        })
		        .done(function(data) {            
		            //---------------------
		            //console.log(data);		            
		        })
		        .fail(function() {
		            console.log("error");
		        })
		        .always(function() {
		            console.log("complete");
		        });
		    
	    },
	    functionLoad : function(query){

	    	var self = this;

	    	var cons = this.cons_doc(query);

	    	cons.success(function(data){
	    		
	    		console.log(data)

	    		$("#"+self.selector_form_res).html("");
	    		//------------------------------------------

	    		if (data.estado == "ok") {
	    		
		    		var itera = $.each(data.mensaje, function(index, val) {
		    			 
		    			 console.log("index: "+index+" val: "+val.nombre)

		    			 $("#"+self.selector_form_res).append(

			        		'<div class="form-group">'+

			        			' <button type="button" class="close delete-doc" data-id-doc="'+val.pkID+'" style="color: red!important;" title="Eliminar Documento">&times;</button>'+

				        		'<strong>Nombre: </strong>'+val.nombre+'<br>'+

				        		' <strong>Archivo: </strong> <a target="_blank" href="../server/php/files/'+val.url+'">'+val.url+'</a><br>'+			        		

			        		'</div>'

			        	 );

		    			 
		    		});

	    		

		    		$.when(itera).then(function(){
		    			
		    			console.log("Termino de cargar los documentos! ")

		    			$(".delete-doc").click(function(event) {
		    			 	console.log("Elimina reg doc: "+$(this).data('id-doc'))
		    			 	
			    			var confirma = confirm("En realidad quiere eliminar este documento?");
						    
						    if(confirma == true){

						    	var elimina = self.elimina_doc($(this).data('id-doc'));

						    	elimina.success(function(data){
						    		console.log(data)
						    		alert(data.mensaje.mensaje);			            
				            		location.reload();
			    				});
						    }

		    			 });    			
		    			

		    		});

	    		}
	    		
	    		//------------------------------------------
	    	});

	    },
	    sendFiles: function(id){

	    	var self = this;

			if (this.arregloDeArchivos.length > 0) {

				$('#'+this.selector).fileupload('send', {files:this.arregloDeArchivos})
				.success(function (result, textStatus, jqXHR) {           
					self.functionSend(id,result);
				});

			}else{
				//o funcion de eliminar campo del DOM
				location.reload()
			}
	    },
	    functionReset:function(){

	    	$("#"+this.selector_form_res).html("")
	    }

	}

})();

//------------------------------------------------------------