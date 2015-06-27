$(document).ready(function(){
	
	$("#cpf").mask('999.999.999-99');
	$("#telFixo,#telCelular").mask('(99)9999-9999');
	$("#cep").mask('99.999-999');
	$("#dtNascimento").mask('99/99/9999');
	$("#wrapper_booth").hide();
	             
    var count = 0;
   
    $("#foto").click(function(){
       
       count=1;
       
       if(count == 1){
           
            $("#wrapper_booth").show();
           
            $('#example').photobooth().on( "image", function( event, dataUrl ){
                $("#imagem").val(dataUrl);
                $("#foto").attr("src",dataUrl);
                $("#example").data( "photobooth" ).destroy();
                $("#wrapper_booth").hide();
                count=0;
            });
        }
    });
   
	$("#cep").change(function(){
        var cep = $('#cep').val().replace(/\D/g,"");
        $.ajax({
            url : 'http://cep.republicavirtual.com.br/web_cep.php?cep='+cep+'&formato=json' ,
            dataType: 'json',
            success: function(response){
              
                if(response.resultado == 1){
                    $("#tipo,#endereco,#numero,#complemento,#cidade,#bairro,#estado").attr('readonly',false).css({'background':'#FFF'});
                    $('#endereco').val(response.logradouro);
                    $('#bairro').val(response.bairro);
                    $('#cidade').val(response.cidade);
                    $('#estado').val(response.uf);
                    $("#tipo").val(response.tipo_logradouro);
                    $("#numero").focus();
                }else{
                    alert("Cep inválido")
                }
            }
       });
    });
   
    $("#cep").click(function(){
       
        $("#endereco,#bairro,#cidade,#estado,#tipo,#numero,#complemento").val('').attr('readonly',true).css({'background':'#CCC'});
        $("#cep").val('');
    });

	
	/*$("#dialog").dialog({
        closeOnEscape: false,
		modal: true,
        autoOpen: false,
        buttons: {
			Ok: function() {
				$( this ).dialog( "close" );
			}
		}
    });	*/	    
});