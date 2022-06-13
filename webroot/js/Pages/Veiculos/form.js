/*jshint esversion: 6 */

var Veiculos  = {

    init: function (){
        this.events();
        // this.isMaritimo();
    },

    events:function(){
        $('select[name="modal_id"]').change(function(){

            const url = new URL(window.location.href);
            const  historyback = url.searchParams.get("historyback");

        
            if(historyback){
                const element = document.createElement("input");
                element.setAttribute('type', 'hidden')
                element.setAttribute('name', 'historyback')
                element.setAttribute('value', parseInt(historyback)+1);
                $('#veiculos-form').append(element); 
            }

            // $('#veiculos-form').attr("method", "get");
            // $('input[name="_method"]').val('GET');
            // $('#veiculos-form').submit();
        });
    },

    isMaritimo:function () {
        if($('select[name="modal_id"]').val() == 3){
            $('select[name="tipo_veiculo_id"]').attr("required", "required");
            $('#imo').attr("required", "required");
            $('#loa').attr("required", "required");
            $('select[name="armador_id"]').attr("required", "required");
            $('#bandeira').attr("required", "required");

        }else{
            $('select[name="tipo_veiculo_id"]').removeAttr("required", "required");
            $('#imo').removeAttr("required");
            $('#loa').removeAttr("required");
            $('#bandeira').removeAttr("required", "required");
            $('select[name="armador_id"]').removeAttr("required");
        }
    }

}