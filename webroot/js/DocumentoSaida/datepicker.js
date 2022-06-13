$(document).ready(function() {

	$('#data-registro').addClass('datetimepicker');
	$('#data-cadastro').addClass('datetimepicker');
	$('#data-recepcao').addClass('datetimepicker');
	$('#data-desembaraco').addClass('datetimepicker');
	

	$(".datetimepicker").datetimepicker({
		language: 'pt-BR',
		format: 'dd/mm/yyyy hh:ii',
		autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left",
	});
});