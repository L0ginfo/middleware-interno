var intervalo = window.setTimeout(
function() {

	$.ajax({
	  url: "mapas/sincronizar/1",
	  context: "",
	  type: "post",
	  success: function(){

	  }
	});
},120000);

