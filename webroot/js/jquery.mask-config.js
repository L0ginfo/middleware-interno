$(document).ready(function(){
	$('.lf-mask-veiculo').mask('AAA-0X00', {
		'translation': {
			X: {pattern: /[A-Za-z0-9]/},
			A: {pattern: /[A-Za-z]/}
		}
	});
});
