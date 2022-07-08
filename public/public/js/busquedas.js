// buscarVocabulario();

// $(document).on('click', "input:checkbox", getChecked);

// var seleccionados = [];
// function getChecked(){
//     $("input[name='voc']:checked").each(function (){
//         seleccionados.push(($(this).attr("value")));
//     });
//     console.log(seleccionados);
// }

// $(document).on('keyup', '#buscarVoc', function(){
//     var palabra = $(this).val();
//     if( palabra != "" ){
//         buscarVocabulario(palabra);
//     }else{
//         buscarVocabulario();
//     }
// });

// function buscarVocabulario(palabra){
//     $.ajax({
//         url: "<?php echo base_url(); ?>/recursos/buscarVocabulario",
//         method: "POST",
//         data: {palabra: palabra}
//     }).done(function(res){
//         var datos = JSON.parse(res);
//         $("#tablaVocabulario tr").remove(); 
//         datos.forEach(function(dato, index) {
//             var num = index+1;
//             document.getElementById("tablaVocabulario").insertRow(-1).innerHTML = '<td id="'+index+'1"></td><td id="'+index+'2"></td><td id="'+index+'3"></td><td><input type="checkbox" name="voc[]" value="'+dato.valID+'"/></td>';
//             $('#'+index+'1').html(dato.at1);
//             $('#'+index+'2').html(dato.at2);
//             $('#'+index+'3').html(dato.at3);
//         });
//     })
// }