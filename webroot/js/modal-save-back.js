var SaveBackModal = {
    
    init: function() {
        $('.btn-modal-save-back').click(function(event){
            const sUrl = $(this).attr('url');
            const bReload = $(this).attr('reload') ? true : false;
            if(!sUrl) return console.log('Modal btn, sem url');
            SaveBackModal.__showModal(sUrl, bReload, $(this).data());
        });
    },

    __showModal:function(sUrl, bReload, oData){
        SaveBackModal.__getModalContent(sUrl, oData, function(ePageContent){
            SaveBackModal.__showModalPage(ePageContent);
            SaveBackModal.__saveModal(bReload);
            return false;
        });
    },

    __saveModal:function(bReload){
        SaveBackModal.__postModalForm(function(data){
            if(bReload) location.reload();
        });
    },

    showModal:function(sUrl, oData, bReload){        
        SaveBackModal.__getModalContent(sUrl, oData, function(ePageContent){
            const bResult = SaveBackModal.__showModalPage(ePageContent);
            if(bResult) SaveBackModal.__saveCallBackModal(function(){}, bReload);
        });
    },

    showCallBackModal:function(__callback, sUrl, oData){        
        SaveBackModal.__getModalContent(sUrl, oData, function(ePageContent){
            const bResult = SaveBackModal.__showModalPage(ePageContent);
            if(bResult) SaveBackModal.__saveCallBackModal(__callback);
        });
    },

    __saveCallBackModal:function(__callback, bReload){
        return SaveBackModal.__postModalForm(__callback, bReload);  
    },

    __postModalForm:function(__callback, bReload){
        $('#modal-save-back form').submit(function(event) {

            let eInput = document.createElement("input");
            eInput.setAttribute("name", 'ajax_save_back');
            eInput.setAttribute("type", "hidden");
            eInput.setAttribute("value", "1");
            this.appendChild(eInput);

            try {
                $.fn.doAjax({
                    url : $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize()
                })
                .then((data) =>{

                    try {
                        data = JSON.parse(data);
                    }catch (error) {
                        Swal.fire({
                            title: 'Ops..',
                            text: 'Falha ao cadastrar o item.',
                            type: 'error',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        return false;
                    }

                    if(data.status == 200){

                        Swal.fire({
                            title: 'Sucesso',
                            text: 'Registro salvo com sucesso.',
                            type: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $('#modal-save-back').modal('hide');

                        if (bReload)
                            location.reload();


                        return __callback(data.dataExtra);
                    }

                    Swal.fire({
                        title: 'Ops..',
                        text: 'Falha ao cadastrar o item.',
                        type: 'error',
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
                
            } catch (error) {

                Swal.fire({
                    title: 'Ops..',
                    text: 'Falha ao cadastrar o item.',
                    type: 'error',
                    timer: 2000,
                    showConfirmButton: false
                });
            }

            return false;
        });
    },

    __showModalPage:function(ePageContent){
        if(!ePageContent || !ePageContent.length) return false;
        ePageContent.removeClass();
        const eHeader = $('.page-header:first', $(ePageContent));
        const eFotter = $('.footer', $(ePageContent));
        const sTitle = eHeader.children().remove().end().text();
        eHeader.remove();
        eFotter.removeClass('footer');
        $('#modal-save-back .modal-header .modal-title .modal-title-ajax')
            .remove();
        $('#modal-save-back .modal-header .modal-title')
            .prepend(`<span class="modal-title-ajax" style="font-size:36px"><b>${sTitle}</b></span>`);
            $('#modal-save-back .modal-body')
            .html(ePageContent);
        $('#modal-save-back .selectpicker')
            .selectpicker('refresh');
        $('#modal-save-back').find('.modal-content').addClass('col-xs-12');
        $('#modal-save-back').modal();
        return true;
    },

    __getModalContent: function(sUrl, oData ,__callback){
        try {

            sUrl = SaveBackModal.__updateURLParameter(sUrl, 'historyback', '1');

            if(oData && oData.hasOwnProperty('id')) 
                sUrl = SaveBackModal.__updateURLParameter(sUrl, 'historybackid', oData.id);

            $.fn.doAjax({
                url : sUrl,
                type: 'GET',
                data: oData ? oData:{}
            })
            .then( (data) => {


                const ePageContent = $('#content', $(data));

                if(ePageContent){
                    __callback(ePageContent);
                    return false;
                }

                Swal.fire({
                    title: 'Ops..',
                    text: 'Falha ao renderizar o componente',
                    type: 'error',
                    timer: 2000,
                    showConfirmButton: false
                });

            }); 

        } catch (error) {

            console.log(error);

        }

    },

    __updateURLParameter : function(url, param, paramVal){
        var newAdditionalURL = "";
        var tempArray = url.split("?");
        var baseURL = tempArray[0];
        var additionalURL = tempArray[1];
        var temp = "";
        if (additionalURL) {
            tempArray = additionalURL.split("&");
            for (var i=0; i<tempArray.length; i++){
                if(tempArray[i].split('=')[0] != param){
                    newAdditionalURL += temp + tempArray[i];
                    temp = "&";
                }
            }
        }
        var rows_txt = temp + "" + param + "=" + paramVal;
        return baseURL + "?" + newAdditionalURL + rows_txt;
    },

    __doInjectData:function(oData){
        const oEntity = oData.hasOwnProperty('entity') ? oData.entity : null;
        SaveBackModal.__doSelectPicker(oEntity);
    },

    __doSelectPicker:function(oEntity){
        const eSelectPicker = $('.lf-selectpicker-ajax.watch .selectpicker');

        if(eSelectPicker){
            return;
        }
        
        const sKey = eSelectPicker.data('key') ?  
            eSelectPicker.data('key') : 'id';
        const sValue = eSelectPicker.data('value') ?  
            eSelectPicker.data('value') : 'descricao';
        let uKey = '';
        let uValue = '';
        let aValue = sValue.split('-');
        if(oEntity.hasOwnProperty(sKey)){
            uKey = oEntity[sKey];
            uValue = aValue.reduce((sum, sKeyValue) =>{
                if(oEntity.hasOwnProperty(sKeyValue)){
                    sum.push(oEntity[sKeyValue]);
                }
                return sum;
            }, []).join(' - ');
            uValue = uValue ? uValue: uKey;
        }

        if(uKey){
            eSelectPicker.append(
                `<option value="${uKey}">${uValue}</option>`);
            eSelectPicker.val(uKey);
            eSelectPicker
                .find('option[selected]')
                .removeAttr('selected');
            eSelectPicker
                .find('option[checked]')
                .removeAttr('checked');
            eSelectPicker
                .find(`option[value="${uKey}"]`)
                .attr('checked', 'checked');
            eSelectPicker
                .find(`option[value="${uKey}"]`).attr('selected', 'selected');
            eSelectPicker
                .selectpicker('render');
            eSelectPicker
                .selectpicker('refresh');
            eSelectPicker
                .closest('.btn-group')
                .find('button')
                .attr('title', uValue);
            eSelectPicker
                .closest('.btn-group')
                .find('.filter-option')
                .html(uValue);
        }
    },
};

