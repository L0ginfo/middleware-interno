$(document).ready(function () {
       $('#descricao').change((e) => {
        //Uppercase value
        $("input#descricao").val(function(i,val) {
            return val.toUpperCase().trim();
        });
       });
   })