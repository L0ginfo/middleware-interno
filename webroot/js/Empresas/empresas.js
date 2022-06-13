/*jshint esversion: 8 */

$(function() {

    const sMask = $('#tipo-codigo option:selected').data('mask');
    if(sMask) $('#cnpj').mask(sMask);

    $('#tipo-codigo').change(function(){
        const sMask = $('#tipo-codigo option:selected').data('mask');
        if(sMask) return $('#cnpj').mask(sMask);
        $('#cnpj').unmask();
    });

    $('#collapseExample').collapse('hide')

    $('#anexar-certificado-comex').click(function(event){
        $('#certificado').click();
    });

    $('#senha-certificado-comex').click(async function(event){
        const empresa_id = $('#empresa_id').val() ? $('#empresa_id').val() : '';
        sData = $('#certificado-password').val();

        if(!sData){
            Utils.swalUtil({
                type:'warning',
                title:'Ops..',
                text:'Valor do senha está vazia',
                timer:2000
            });
        }


        if(sData){

            const aData = await $.fn.doAjax({
                type: "POST",
                url: `empresas/uploadCertificado/${empresa_id}`,
                data:{
                    certificado: window.btoa(sData),
                    tipo:'PASS_PEM'
                },
            });

            if(aData.status == 200){

                $('#anexo').css('background-color:green');

                Utils.swalUtil({
                    type:'success',
                    title:'Sucesso',
                    text:'Senha salva com sucesso.',
                    timer:2000
                });

            }else{
                
                Utils.swalUtil({
                    type:'error',
                    title:'Ops..',
                    text:'Falha ao salvar a senha.',
                    timer:2000
                });
            }
        }
    });

    $('#certificado').change(async function(e){
        const empresa_id = $('#empresa_id').val() ? $('#empresa_id').val() : '';
        const tipo  = $('#tipo-certificado').val() ;
        const file = e.target.files[0];

        if(!tipo){
            Utils.swalUtil({
                type:'warning',
                title:'Ops..',
                text:'por favor, selecione tipo do certificado.',
                timer:2000
            });

            $('#certificado').val('');
        }

        sData = await getFileText(file);

        if(sData && tipo){
            $('#text-anexo').val(file.name);
            const aData = await $.fn.doAjax({
                type: "POST",
                url: `empresas/uploadCertificado/${empresa_id}`,
                data:{
                    certificado: window.btoa(sData),
                    tipo:tipo
                },
            });

            if(aData.status == 200){

                $('#anexo').css('background-color:green');

                Utils.swalUtil({
                    type:'success',
                    title:'Sucesso',
                    text:'certificado salvo com sucesso.',
                    timer:2000
                });

            }else{
                
                Utils.swalUtil({
                    type:'error',
                    title:'Ops..',
                    text:'Falha ao salvar o certificado.',
                    timer:2000
                });
            }
        }
    });

    let optionsTelefone =  {
        onKeyPress: function(telefone, e, field, options) {
            var masks = ['0000-00000', '0-0000-0000', '00-0000-00000'];
            var mask = (telefone.length > 9) ? masks[1] : masks[0];
            $('#telefone').mask(mask, options);
    }};

    $("#cep").mask("00.000-000");

    // $("#telefone").mask('00000-000000', optionsTelefone);

    // $('#cep').change(function(){
    //     let url = $(this).data('url');
    //     let valor = $(this).val();
    //     goSearch(url, valor);
    // });

    // $('#pais-id').blur(function(){
    //     let url = $(this).data('url');
    //     let valor = $(this).val();
    //     getUF(url, valor);
    // });
    
    function goSearch(urlG, dados){

        let request = $.ajax({
            url: urlG,
            method: "POST",
            data: { dado : dados},
            dataType: "json"
        });

        request.done(function(msg) {

            if(Array.isArray(msg) && msg.length){
                renderLogradouros(msg);
                return;
            }

            Swal.fire({
                type: 'error',
                title: 'ERRO',
                text: 'CEP não encontrado no sistema, por favor digitar manualmente.',
            });

        });

        request.fail(function(msg) {
            Swal.fire({
                type: 'error',
                title: 'ERRO',
                text: 'Falha ao buscar o registro, por favor tente novamente.',
            });
        });
    }

    function renderLogradouros(array){
        let _UF;
        let _PAIS;
        let _URL = $('#pais-id').data('url');
        let _OLD_PAIS = $('#pais-id').val();

        array.forEach(element => {
            $('#endereco').val(element.descricao);
            $('#bairro').val(element.bairro.nome);
            $('#cidade').val(element.bairro.cidade.nome);
            _UF = element.bairro.cidade.estado.id ;
            _PAIS = element.bairro.cidade.estado.pais.id;
            $('#pais-id').val(element.bairro.cidade.estado.pais.id);
            $('#logradouro-id').val(element.id);
        });

        if(_OLD_PAIS != _PAIS){
            getUF(_URL, _PAIS, _UF);
        }else{
            $('#uf-id').val(_UF);
        }

    }

    function getUF(urlG, dados, uf = null){

        let request = $.ajax({
            url: urlG,
            method: "POST",
            data: { dado : dados},
            dataType: "json"
        });

        request.done(function(msg) {

            if(Array.isArray(msg) && msg.length){
                renderUF(msg, uf);
                return;
            }

            Swal.fire({
                type: 'error',
                title: 'ERRO',
                text: 'Falha ao buscar o UFs, por favor tente novamente.',
            }); 
        });

        request.fail(function(msg) {
            Swal.fire({
                type: 'error',
                title: 'ERRO',
                text: 'Falha ao buscar o UFs, por favor tente novamente.',
            });
        });
    }


    function renderUF(array, uf){

        const html = array.reduce(function(acumulador, valorAtual) {
            return acumulador + `<option value="${valorAtual.id}">${valorAtual.nome}</option>`;
        }, '');

        $('#uf-id').html(html);

        if(uf){
            $('#uf-id').val(uf);
        }
    }

    function getFileText(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsText(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
        });
    }
    

    $('#collapse-title-button').click(function(){

        if($('#collapseExample').css('display') == 'block'){
            $("#icon-title-collapse")
                .addClass("fa-chevron-up");
            $("#icon-title-collapse")
                .removeClass("fa-chevron-down");
        }else{
            $("#icon-title-collapse")
                .removeClass("fa-chevron-up");
            $("#icon-title-collapse")
                .addClass("fa-chevron-down");
        }
    });
});