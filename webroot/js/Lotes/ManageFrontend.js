const ManageFrontend = {

    render: async function(id, oResponse) {
        switch (id) {
            case 'Carga':
                this.renderCarga(oResponse)
                break
            case 'Di':
                this.renderDi(oResponse)
                break
            case 'Servico':
                this.renderServico(oResponse)
                break
            case 'Tfa':
                this.renderTfa(oResponse)
                break
            case 'Pesagem':
                this.renderPesagem(oResponse)
                break
            // case 'Observacao':
            //     this.renderCarga(oResponse)
            //     break
            case 'Apreensao':
                this.renderApreensao(oResponse)
                break
            case 'Agendamento':
                this.renderAgendamento(oResponse)
                break
            case 'ContainerLotes':
                this.renderContainerLotes(oResponse)
                break
            case 'Estoques':
                this.renderEstoques(oResponse)
                break
            case 'Financeiros':
                this.renderFinanceiros(oResponse)
                break
            default:
                break
        }
    },

    renderCarga: function(oResponse) {

        aContainers = oResponse.dataExtra.containers

        var $table = $('.table_carga')

        if (aContainers.length < 1) {
            $table.find('tbody tr:not(:first-child)').remove()
            $table.find('tbody').append('<tr><td colspan="10" align="center">Vazio</tr>')
            return
        }

        $table.find('tbody tr:not(:first-child)').remove()
        aContainers.forEach(oContainer => {
            $table.find('tbody').append(`
            <tr>
                <td>${oContainer.container_numero ?? 'Sem Container'}</td>
                <td>${oContainer.container_tamanho ?? '---'}</td>
                <td>${oContainer.container_iso ?? '---'}</td>
                <td>${oContainer.volumes ?? ''}</td>
                <td>${oContainer.especie ?? ''}</td>
                <td>${oContainer.produto ?? ''}</td>
                <td>${oContainer.peso_bruto ?? ''}</td>
                <td>${oContainer.tipo_documento ?? ''}</td>
                <td>${oContainer.documento_entrada ?? ''}</td>
                <td>${oContainer.status_mapa ?? ''}</td>
            </tr>`)
        })

    },

    renderEstoques: function(oResponse) {

        aEstoques = oResponse.dataExtra.estoques;

        var $table = $('.table_estoques')

        if (aEstoques.length < 1) {
            $table.find('tbody tr:not(:first-child)').remove()
            $table.find('tbody').append('<tr><td colspan="10" align="center">Vazio</tr>')
            return
        }

        $table.find('tbody tr:not(:first-child)').remove()
        aEstoques.forEach(oEstoque => {
            const fQuantidade = Utils.showFormatFloat(oEstoque.qtde ?? 0);
            const fPeso       = Utils.showFormatFloat(oEstoque.peso ?? 0, 3);
            $table.find('tbody').append(`
            <tr>
                <td>${oEstoque.lote_codigo ?? ''}</td>
                <td>${oEstoque.lote_item ?? ''}</td>
                <td>${oEstoque.produto ?? ''}</td>
                <td>${oEstoque.endereco ?? ''}</td>
                <td>${oEstoque.etiqueta ?? ''}</td>
                <td>${oEstoque.unidade_medida ?? ''}</td>
                <td>${fQuantidade}</td>
                <td>${fPeso}</td>
                <td class="text-center">
                    <button class="btn btn-primary btn-avarias" data-estoque="${oEstoque.estoque_id}" data-endereco="${oEstoque.endereco_id}" data-etiqueta="${oEstoque.etiqueta_id}">
                        Avarias
                    </button>
                </td>
            </tr>`)
        })

        $('.btn-avarias').click(function(){
            SaveBackModal.showModal('lotes/avarias', $(this).data());
        })

    },

    renderDi: function(oResponse) {

        aLiberacoes = oResponse.dataExtra.liberacoes

        var $table = $('.table_di')

        if (aLiberacoes.length < 1) {
            $table.find('tbody tr:not(:first-child)').remove()
            $table.find('tbody').append('<tr><td colspan="7" align="center">Vazio</td></tr>')
            return
        }

        $table.find('tbody tr:not(:first-child)').remove()

        aLiberacoes.forEach(oLiberacao => {
            $table.find('tbody').append(`
            <tr>
                <td>${oLiberacao.lote_codigo ?? ''}</td>
                <td>${oLiberacao.regime ?? ''}</td>
                <td>${oLiberacao.numero_liberacao ?? ''}</td>
                <td>${oLiberacao.data_desembaraco ? moment(oLiberacao.data_desembaraco).format('DD/MM/YYYY HH:mm:ss') : ''}</td>
                <td>${oLiberacao.data_registro ? moment(oLiberacao.data_registro).format('DD/MM/YYYY HH:mm:ss') : ''}</td>
                <td>${oLiberacao.tipo_documento ?? ''}</td>
                <td>${oLiberacao.canal ?? ''}</td>
            </tr>`)
        })

    },

    renderServico: function(oResponse) {

        aServicos = oResponse.dataExtra.servicos

        var $table = $('.table_servicos')

        var $iDocumentoMercadoriaId = $('#documento_mercadoria_id').val()

        if (aServicos.length < 1) {
            $table.find('tbody tr:not(:first-child)').remove()
            $table.find('tbody').append('<tr><td colspan="9" align="center">Vazio</td></tr>')
            return
        }

        $table.find('tbody tr:not(:first-child)').remove()

        aServicos.forEach(oServico => {

            $table.find('tbody').append(`
            <tr>
                <td>${oServico.ordem_servico ?? ''}</td>
                <td>${moment(oServico.data_solicitacao).format('DD/MM/YYYY HH:mm:ss')}</td>
                <td>${oServico.solicitante ?? ''}</td>
                <td>${oServico.data_agendamento ? moment(oServico.data_agendamento).format('DD/MM/YYYY HH:mm:ss') : ''}</td>
                <td>${oServico.container ?? 'Carga Geral'}</td>
                <td>${oServico.servico ?? ''}</td>
                <td>${oServico.data_entrada ? moment(oServico.data_entrada).format('DD/MM/YYYY HH:mm:ss') : ''}</td>
                <td>${oServico.data_inicio ? moment(oServico.data_inicio).format('DD/MM/YYYY HH:mm:ss') : ''}</td>
                <td>${oServico.data_termino ? moment(oServico.data_termino).format('DD/MM/YYYY HH:mm:ss') : ''}</td>
                <td class="text-center">
                    <button class="btn btn-primary btn-ordem-detalhes" data-ordem_servico="${oServico.ordem_servico}"  data-documento_mercadoria="${$iDocumentoMercadoriaId}">
                        Detalhes
                    </button>
                </td>
            </tr>`)
        })

        $('.btn-ordem-detalhes').click(function(){
            SaveBackModal.showModal('lotes/ordem-servicos', $(this).data());
        })

    },

    renderTfa: function(oResponse) {

        aVistorias = oResponse.dataExtra.vistorias

        var $table = $('.table_vistorias')

        if (aVistorias.length < 1) {
            $table.find('tbody tr:not(:first-child)').remove()
            $table.find('tbody').append('<tr><td colspan="4" align="center">Vazio</td></tr>')
            return
        }

        $table.find('tbody tr:not(:first-child)').remove()

        aVistorias.forEach(oVistoria => {

            if (oVistoria.vistoria_tipo_carga == 'Carga Geral' && oVistoria.ordem_servico_id)
                sLink = '<a href="/vistorias/imprimir-layout-vistoria-carga-geral/'+ oVistoria.vistoria_id +'" title="Termo de Falta e Avaria de Containers" target="blank"><i class="fas fa-file-pdf"></i> '+ oVistoria.vistoria_id +'</a>'
            else if (oVistoria.vistoria_tipo_carga == 'Container' && oVistoria.vistoria_item_id)
                sLink = '<a href="/vistorias/imprimir-layout-vistoria-containers/'+ oVistoria.vistoria_item_id +'" title="Termo de Falta e Avaria de Containers" target="blank"><i class="fas fa-file-pdf"></i> '+ oVistoria.vistoria_id +'</a>'

            $table.find('tbody').append(`
            <tr>
                <td>${sLink ?? oVistoria.vistoria_id}</td>
                <td>${oVistoria.data_hora_vistoria ? moment(oVistoria.data_hora_vistoria).format('DD/MM/YYYY HH:mm:ss') : ''}</td>
                <td>${oVistoria.data_hora_fim ? moment(oVistoria.data_hora_fim).format('DD/MM/YYYY HH:mm:ss') : ''}</td>
                <td>${oVistoria.programacao_id ?? ''}</td>
                <td>${oVistoria.ordem_servico_id ?? ''}</td>
            </tr>`)
        })

    },

    renderPesagem: function(oResponse) {

        aPesagens = oResponse.dataExtra.pesagens

        var $table = $('.table_pesagens')

        if (aPesagens.length < 1) {
            $table.find('tbody tr:not(:first-child)').remove()
            $table.find('tbody').append('<tr><td colspan="4" align="center">Vazio</td></tr>')
            return
        }

        $table.find('tbody tr:not(:first-child)').remove()

        aPesagens.forEach(oPesagem => {
            $table.find('tbody').append(`
            <tr>
                <td>${oPesagem.resv_id ?? ''}</td>
                <td>${oPesagem.peso_entrada ?? ''}</td>
                <td>${oPesagem.peso_saida ?? ''}</td>
                <td>${oPesagem.peso_armazenagem ?? ''}</td>
            </tr>`)
        })

    },

    renderFinanceiros: function(oResponse) {

        aFinanceiros = oResponse.dataExtra.financeiros;

        var $table = $('.table_financeiros')

        if (aFinanceiros.length < 1) {
            $table.find('tbody tr:not(:first-child)').remove()
            $table.find('tbody').append('<tr><td colspan="10" align="center">Vazio</tr>')
            return
        }

        $table.find('tbody tr:not(:first-child)').remove()
        aFinanceiros.forEach(aFinanceiro => {
            const fValorDevido     = Utils.showFormatFloat(aFinanceiro.valor_devido ?? 0);
            const fValorPago       = Utils.showFormatFloat(aFinanceiro.valor_pago ?? 0, 3);
            $table.find('tbody').append(`
            <tr>
                <td>${aFinanceiro.numero_documento ?? ''}</td>
                <td>${aFinanceiro.tipo_faturamento ?? ''}</td>
                <td>${aFinanceiro.codigo_fatura ?? ''}</td>
                <td>${aFinanceiro.forma_pagamento ?? ''}</td>
                <td>${aFinanceiro.periodo_atual ?? ''}</td>
                <td>${fValorDevido ?? ''}</td>
                <td>${aFinanceiro.data_ultima_baixa ?? ''}</td>
                <td>${fValorPago}</td>
            </tr>`)
        })
    },

    renderAgendamento: function(oResponse) {

        aAgendamentos = oResponse.dataExtra.agendamentos

        var $table = $('.table_agendamentos')

        if (aAgendamentos.length < 1) {
            $table.find('tbody tr:not(:first-child)').remove()
            $table.find('tbody').append('<tr><td colspan="6" align="center">Vazio</td></tr>')
            return
        }

        $table.find('tbody tr:not(:first-child)').remove()

        aAgendamentos.forEach(oAgendamento => {
            $table.find('tbody').append(`
            <tr>
                <td>${oAgendamento.numero_agendamento ?? ''}</td>
                <td>${oAgendamento.data_hora_programada ? moment(oAgendamento.data_hora_programada).format('DD/MM/YYYY HH:mm:ss') : ''}</td>
                <td>${oAgendamento.grade_horario ?? ''}</td>
                <td>${oAgendamento.data_hora_chegada ? moment(oAgendamento.data_hora_chegada).format('DD/MM/YYYY HH:mm:ss') : ''}</td>
                <td>${oAgendamento.data_hora_entrada ? moment(oAgendamento.data_hora_entrada).format('DD/MM/YYYY HH:mm:ss') : ''}</td>
                <td>${oAgendamento.resv_id ?? ''}</td>
            </tr>`)
        })

    },

    renderApreensao: function(oResponse) {

        aApreensoes = oResponse.dataExtra.apreensoes

        var $table = $('.table_apreensoes')

        if (aApreensoes.length < 1) {
            $table.find('tbody tr:not(:first-child)').remove()
            $table.find('tbody').append('<tr><td colspan="6" align="center">Vazio</td></tr>')
            return
        }

        $table.find('tbody tr:not(:first-child)').remove()

        aApreensoes.forEach(oApreensao => {
            $table.find('tbody').append(`
            <tr>
                <td>${oApreensao.numero ?? ''}</td>
                <td>${oApreensao.tipo_documento ?? ''}</td>
                <td>${oApreensao.data_apreensao ? moment(oApreensao.data_apreensao).format('DD/MM/YYYY HH:mm:ss') : ''}</td>
                <td>${oApreensao.item ?? ''}</td>
                <td>${oApreensao.quantidade ?? ''}</td>
            </tr>`)
        })

    },

    renderContainerLotes: function(oResponse) {

        oContainer = oResponse.dataExtra.container

        $('.titulo_container').text(oContainer.numero)
        $('.modelo_container').text(oContainer.tipo_iso.container_modelo.descricao)
        $('.tamanho_container').text(oContainer.tipo_iso.container_tamanho.tamanho)
        $('.tipo_iso_container').text(oContainer.tipo_iso.descricao)

        aContainerLotes = oResponse.dataExtra.lotes

        var $table = $('.table_container_lotes')

        if (aContainerLotes.length < 1) {
            $table.find('tbody tr:not(:first-child)').remove()
            $table.find('tbody').append('<tr><td colspan="6" align="center">Vazio</td></tr>')
            return
        }

        $table.find('tbody tr:not(:first-child)').remove()

        aContainerLotes.forEach(oContainerLote => {
            $table.find('tbody').append(`
            <tr>
                <td>${oContainerLote.lote ?? ''}</td>
                <td>${oContainerLote.conhecimento ?? ''}</td>
                <td>${oContainerLote.cliente ?? ''}</td>
                <td>${oContainerLote.produtos ?? ''}</td>
                <td>${oContainerLote.quantidade ?? ''}</td>
                <td>${oContainerLote.peso_bruto ?? ''}</td>
            </tr>`)
        })

        $('#modal-container-lotes').modal('toggle')

    }
}