(function(){
	
 	//----------------------------------------------------------------
 	//funcion que quita los caracteres especiales de las observaciones
 	//para que no halla errores al actualizarel campo.
 	self.observ = {
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