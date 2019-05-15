(function(){

	self.reprogramaCompromiso = function(contador, descripcion, div_descripcion, fecha_cumplimiento){
		this.contador = contador; 
		this.descripcion = descripcion;
		this.div_descripcion = div_descripcion;
		this.fecha_cumplimiento = fecha_cumplimiento;
		this.btn_reprograma = $("#btn_reprocompromiso");
		this.btn_action = $("#btn_actioncompromiso");		
		//---------------------------------------------------
		this.tipo_user = leerCookie("log_lunelAdmin_IDtipo");

		this.reprogramado = false;
		//---------------------------------------------------
		this.data_compromiso = {};
	}


	self.reprogramaCompromiso.prototype = {

		exe: function(){
			
			var self = this;

			if (this.userAdmin()) {
								

				var fecha_ant = this.fecha_cumplimiento.val();

				this.btn_reprograma.unbind("click");

				this.btn_reprograma.click(function(){
					self.enable(self.fecha_cumplimiento);						
					self.disable(self.btn_reprograma);					
				});

				this.fecha_cumplimiento.change(function(event) {
					/**/

					if ($(this).val() !== fecha_ant) {

						console.log("Cambió la fecha de cumplimiento!")

						/*muestra la descripcion como required
						*/

						//self.hideShow(self.div_descripcion, "show")

						self.descripcion.attr('required', 'true')

						self.enable(self.descripcion)

						self.reprogramado = true;

					} else {
						console.log("No cambió la fecha de cumplimiento!")

						$(this).val(fecha_ant)

						self.disable(self.fecha_cumplimiento)					
						
						self.enable(self.btn_reprograma)

						self.disable(self.descripcion)

						self.descripcion.removeAttr('required')

						//self.hideShow(self.div_descripcion, "hide")

						self.reprogramado = false;
					}
				});

				//self.contador.val(parseInt(self.contador.val()) + 1)

			} else {
				
				this.disable(this.fecha_cumplimiento)
				this.disable(this.btn_reprograma)
			}
		},
		validaAumentoContador: function(){
			if (this.reprogramado) {
				this.contador.val(parseInt(this.contador.val()) + 1)
			}
		},
		userAdmin: function(){			
			return this.tipo_user === "1" ? true : false;			
		},
		enable: function(elem){
			elem.removeAttr('disabled');
		},
		disable: function(elemento){
			//console.log(elemento)
			elemento.attr('disabled', 'true');
		},
		hideShow: function(elem, type){

			switch (type) {
				case "hide":
						elem.attr('hidden','true');
					break;
				case "show":
						elem.removeAttr('hidden');
					break;
				
			}
		},
		readOnly: function(elem, type){

			switch (type) {
				case true:
						elem.attr('readonly', 'true');
					break;
				case false:
						elem.removeAttr('readonly');
					break;
				
			}
		},
		setDataCompromiso: function(data){
			this.data_compromiso = data;
		},
		getDataCompromiso: function(){
			return this.data_compromiso;
		},
		getDataReunion: function(pkID_reunion){

			var query = "SELECT * FROM reuniones WHERE pkID = "+pkID_reunion,
				res = {};

			var cons_mod = dbGen.db_general(query);

			cons_mod.success(function(data){
				console.log(data)
				res = data;
			})

			return res.mensaje[0];
		}
	}

})();