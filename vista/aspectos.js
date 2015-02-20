$(document).ready(function(){

    $.ajax({
        url: "vista/function/calcSize.php",
        success: function(result){
            $(".porcentaje").html(result);
        }
    });

    $(".backupList").innerHeight( $(".contenidoList").innerHeight() );
    $(".check").css("margin-top", $(".contenidoList").innerHeight() / 5 );

    $("input.check").prettyCheckable({
        color: 'blue',
    });

    $("label[for='toBackup']").text("");

    $('#fileUpload').on('change', function() {

        $.ajax({
            url: "modelo/checkSpace.php",
            type: "POST",
            data: { archivoParaSubir: this.files[0].size },
            success: function(result){

                if( $(".mensaje-cloud") !== null ){
                    $(".mensaje-cloud").remove();
                }

                if( result > 20000 ){
                    $('.buttonUp').prop( "disabled", true );

                    $.ajax({
                       url: 'vista/errors/notSpace.php',
                       success: function(html) {

                           $(".bread-c").append(html);

                       }
                    });

                }else{
                    $('.buttonUp').prop( "disabled", false );
                }

            }
        });
    });

    $(".boton-envio").on("click",function(){
        $(".anadirImagen").fadeIn("slow");
        $(".appWrapper").fadeTo(400, 0.45);
        $("#boton-enviarCorreo").attr('name', $(".boton-envio").attr("name") );
    });
/*
    $('#loadImage').hide();
  */
    $(".spanCerrar").on("click",function(){
        $(".anadirImagen").fadeOut(500,function(){
            $("#preview").attr("src","");
            $("#inputImage").val("");
            $("#notImage").show(0);
            $("#notImage").html("No has seleccionado ninguna imagen");
        });
        $(".appWrapper").fadeTo(400, 2);
    });

    function readURL(input) {

    if (input.files && input.files[0]) {

        var val = $("#inputImage").val();

        switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
            case 'gif': case 'jpg': case 'png': case 'svg':
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview').attr('src', e.target.result);
                    $("#notImage").hide(0);
                }
                reader.readAsDataURL(input.files[0]);
                break;
            default:
                $("#inputImage").val('');
                $("#notImage").html("Eso no era una imagen");
            }
        }
    }

    $("#inputImage").change(function(){
        readURL(this);
    });
/*
    $("#boton-enviarCorreo").on("click",function(){

    });
*/
    $("#uploadForm").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	beforeSend: function(){
                $('#loadImage').show();
                $('#preview').fadeTo(400,0.4);
            },
            url: "modelo/upload.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data){
                $.ajax({

                    url: "modelo/sendEmail.php",
                    type: "GET",
                    data: { nombrePDF : $("#boton-enviarCorreo").attr('name') },
                    success: function(result){
                        $('#loadImage').hide();
                        $(".anadirImagen").fadeOut(400);
                        $(".appWrapper").fadeTo(400, 1);
                        $('#preview').fadeTo(400,1);
                        $.ajax({
                               url: 'vista/success/sentMessage.php',
                               success: function(html) {
                                   if( $(".mensaje-cloud") !== null ){
                                       $(".mensaje-cloud").remove();
                                   }
                                   $(".bread-c").append(html);
                               }
                        });
                    }
                });
            },
		  	error: function(){}
	   });
	}));

});

/*backups se ponen al mismo tamaño que las carpetas mientras hago zoom*/
$(window).resize(function() {
    $(".backupList").innerHeight( $(".contenidoList").innerHeight() );
    $(".check").css("margin-top", $(".contenidoList").innerHeight() / 5 );
});
