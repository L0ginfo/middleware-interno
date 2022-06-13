var AnexoTabelasRender = {

    renderAnexos: function(oResponse, $this) {

        var oAnexoTabelas   = oResponse.dataExtra.AnexoTabelas
        var oAnexoSituacoes = oResponse.dataExtra.AnexoSituacoes
        
        var $table = $this.closest('.modal-body').find('.table_anexo_tabelas')

        if (oAnexoTabelas.length < 1) {
            $table.find('tbody tr:not(:first-child)').remove()
            $table.find('tbody').append('<tr><td colspan="4" align="center">Vazio</td></tr>')
            return
        }

        $table.find('tbody tr:not(:first-child)').remove()

        oAnexoTabelas.forEach(oAnexoTabela => {

            sLink = '<a href="/anexos/get-content-file/'+oAnexoTabela.anexo_id+'/'+oAnexoTabela.anexo_nome+'" title="" target="blank"><i class="fas fa-file-download"></i> '+ oAnexoTabela.anexo_nome +'</a>'
            sOptions = '<option>Selecione</option>'
            oAnexoSituacoes.forEach(oAnexoSituacao => {

                if (oAnexoTabela.anexo_situacao_id == oAnexoSituacao.id)
                    sOptions += '<option selected value="'+oAnexoSituacao.id+'">'+oAnexoSituacao.descricao+'</option>'
                else
                    sOptions += '<option value="'+oAnexoSituacao.id+'">'+oAnexoSituacao.descricao+'</option>'
                    
            })

            $table.find('tbody').append(`
            <tr class="tr_anexo_situacao">
                <input type="hidden" name="anexo_tabela_id_hidden" class="anexo_tabela_id_hidden" value="${oAnexoTabela.anexo_tabela_id}">
                <td>${sLink ?? ''}</td>
                <td>${oAnexoTabela.anexo_tipo_descricao ?? ''}</td>
                <td class="anexo_tabela">
                    <select style="width:100%;" class="form-control anexo_situacao_render">${sOptions}</select>
                </td>
                <td>
                    <button style="width:100%;" class="btn btn-danger btn_delete_anexo" data-id="${oAnexoTabela.anexo_tabela_id}" type="button">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </td>
            </tr>`)
        })

        AnexoTabelasManager.watchAnexoSituacaoRender()
        AnexoTabelasManager.watchBtnDeleteAnexo()

    },

}