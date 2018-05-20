$(function(){
	$('.dinheiro').mask("#.##0,00", {reverse: true});
	$('.quantidade').mask("#0,00", {reverse: true});
	$('.inteiro').mask("#0", {reverse: true});
	$('input[name=cod]').mask("A");
	$('input[class=letras]').mask("S");
});


