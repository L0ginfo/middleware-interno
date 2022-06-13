import { Separacao } from './OperacaoSeparacaoClass.js'
import { ManageFrontend } from './ManageFrontend.js'

export const ManageRoutineData = {
    params: {
        libera_qtde_divergente: true,
        libera_endereco_divergente: true,
        libera_campo_quantidade: false
    },
    
    /**
     * Retorna os dados para o usuario fazer o Picking
     * Poderá enviar a chave do endereco ou NULL para retornar
     * o primeiro endereco
     * 
     * @param {*} sEnderecoComposicao 
     */
    getDadosEndereco: function(sEnderecoComposicao = null, iPosition = null, bShowAllValidPicking = false) {
        var aEnderecosValidos = this.getDadosEnderecoComHeuristica()

        try {

            //Podera cair aqui caso nao houver nenhum produto localizado no estoque do sistema
            if (Object.keys(aEnderecosValidos) === 0)
                return []

            if (sEnderecoComposicao && iPosition === null)
                return aEnderecosValidos[sEnderecoComposicao]
            else if (bShowAllValidPicking)
                return aEnderecosValidos
            else if (iPosition !== null)
                return aEnderecosValidos[Object.keys(aEnderecosValidos)[iPosition]]

        } catch (error) {
            return []
        }

        return []
    },
    
    /**
     * Retorna os dados para o usuario fazer o Estorno
     * 
     * @param {*} sEnderecoComposicao 
     */
    getDadosEnderecoEstorno: function(sEnderecoComposicao, bShowAllValidEstorno = null) {
        var aEnderecosValidos = this.getDadosEnderecosSeparados()

        try {
            //Podera cair aqui caso nao houver nenhum produto separado
            if (Object.keys(aEnderecosValidos) === 0)
                return []

            if (sEnderecoComposicao)
                return aEnderecosValidos[sEnderecoComposicao]
            else if (bShowAllValidEstorno)
                return aEnderecosValidos

        } catch (error) {
            return []
        }

        return []
    },
    getDadosEnderecoSemHeuristica: function(sTipo) {
        try {
            
            if (['separados', 'sem_localizacoes'].includes(sTipo))
                return this.getDadosEnderecoInformativos()[sTipo]

            return []
        } catch (error) {
            return []
        }
    },
    getDadosEnderecoInformativos: function() {
        return aDadosOperacao.enderecos_ordenados.informativos
    },
    getDadosEnderecosSeparados: function() {
        return this.getDadosEnderecoInformativos().separados
    },
    getDadosEnderecoComHeuristica: function() {
        return aDadosOperacao.enderecos_ordenados.com_heuristica
    },
    getChaveEnderecoComposicao: function(sEnderecoComposicao = null, iPosition = null) {
        var aEnderecosValidos = this.getDadosEndereco(sEnderecoComposicao, iPosition)

        try {
            //Podera cair aqui caso nao houver nenhum produto localizado no estoque do sistema
            if (Object.keys(aEnderecosValidos) === 0)
                return []

            if (sEnderecoComposicao && iPosition === null)
                return sEnderecoComposicao
            else if (ObjectUtil.isset(aEnderecosValidos.chave_endereco_separacao))
                return aEnderecosValidos.chave_endereco_separacao
            else if (iPosition !== null)
                return Object.keys(aEnderecosValidos)[iPosition].chave_endereco_separacao


        } catch (error) {
            return []
        }

        return []
    },
    getQtdeSeparada: function(aDadosEndereco) {
        try {
            return aDadosEndereco.qtde_separada
        } catch (error) {
            return 0.0
        }
    },
    getQtdeRetirar: function(aDadosEndereco) {
        try {
            return aDadosEndereco.qtde_retirar
        } catch (error) {
            return 0.0
        }
    },
    getTotalQtdeSeparada: function() {
        var aSeparados = this.getDadosEnderecosSeparados(),
            aKeys = Object.keys(aSeparados),
            dQtdeTotal = 0.0
            
        for (var i in aKeys) 
            dQtdeTotal += aSeparados[ aKeys[i] ].qtde_separada
        
        return dQtdeTotal
    },
    getTotalQtdeRetirar: function() {
        var aReferencias = aDadosOperacao.referencias_produtos,
            dQtdeTotal = 0.0

        for (var i in aReferencias) 
            dQtdeTotal += aReferencias[i].qtde_total_pedido_real

        return dQtdeTotal
    },
    getComposicaoEnderecoSeparado: function(aDadosEndereco) {
        try {
            return aDadosEndereco.endereco_separado.composicao
        } catch (error) {
            return ''
        }
    },
    getEnderecoSeparado: function(aDadosEndereco) {
        try {
            return aDadosEndereco.endereco_separado
        } catch (error) {
            return null
        }
    },
    getEnderecoRetirar: function(aDadosEndereco) {
        try {
            return aDadosEndereco.localizacao.endereco.id
        } catch (error) {
            return null
        }
    },
    setLevelsValidacoes: function(iLevels) {
        var aValidations = new Array()

        for (var i = 0; i < iLevels; i++) 
            aValidations[i] = new Array()

        return aValidations
    },
    valida: async function(sTipo) {
        var aValidationsLevels = null

        if (sTipo == 'separacao')
            aValidationsLevels = await this.validaSeparacao()
        else if (sTipo == 'estorno')
            aValidationsLevels = await this.validaEstorno()
        else if (sTipo == 'finalizacao')
            aValidationsLevels = await this.validaFinalizacao()
        
        return await ManageFrontend.manageValidate(aValidationsLevels)
    },
    validaEstorno: async function() {
        var aValidations = this.setLevelsValidacoes(2)
            
        aValidations[0].push({
            status: 401,
            message: 'Você tem certeza que deseja Estornar?',
            text: false,
            libera: true
        })

        aValidations[1].push({
            message: 'OK',
            status: 200
        })

        return aValidations
    },
    validaFinalizacao: async function() {
        var aValidations = this.setLevelsValidacoes(2)

        if (this.getTotalQtdeSeparada() != this.getTotalQtdeRetirar())
            aValidations[0].push({
                message: 'A Quantidade Total Separada diverge da Quantidade Total Informada!',
                status: 401,
                libera: this.params.libera_qtde_divergente
            })

        aValidations[1].push({
            status: 401,
            message: 'Você tem certeza que deseja Finalizar?',
            libera: true
        })

        aValidations[1].push({
            message: 'OK',
            status: 200
        })

        return aValidations
    },
    validaSeparacao: async function() {
        var oState = Separacao.getState(),
            aDadosEndereco = oState.dados_endereco_picking,
            aValidations = this.setLevelsValidacoes(3)

        if (!oState.qtde_separada || !ObjectUtil.issetProperty(oState.endereco_separado, 'id'))
            aValidations[0].push({
                status: 400,
                message: 'Você precisa preencher todos os dados!'
            })

        if (aParams.leitura_produto && !ManageFrontend.getInputProduto().val())
            aValidations[0].push({
                status: 400,
                message: 'Você precisa bipar o Produto!'
            })

        if (oState.obriga_informar_serie && !ManageFrontend.getInputProdutoSerie().val())
            aValidations[0].push({
                status: 400,
                message: 'Você precisa bipar a Série!'
            })

        if (oState.qtde_separada != this.getQtdeRetirar(aDadosEndereco))
            aValidations[0].push({
                status: 401,
                libera: this.params.libera_qtde_divergente,
                message: 'A quantidade separada diverge da quantidade informada!'
            })

        if (ObjectUtil.issetProperty(oState.endereco_separado, 'id') && oState.endereco_separado.id != this.getEnderecoRetirar(aDadosEndereco))
            aValidations[0].push({
                status: 401,
                libera: this.params.libera_endereco_divergente,
                message: 'O endereço bipado diverge do endereço informado!',
            })

        aValidations[1].push({
            status: 400,
            libera: this.params.libera_endereco_divergente,
            action: async function() {
                var oReturn = await ManageRoutineData.estoqueExisteQuantidade()
                this.message = oReturn.message
                this.text    = oReturn.text
                this.status  = oReturn.status
            }
        })

        aValidations[2].push({
            message: 'OK',
            status: 200
        })

        return aValidations
    },
    estoqueExisteQuantidade: async function() {
        var oData = {
            state: Separacao.getState(),
            ordem_servico_id: aDadosOperacao.ordem_servico_id
        }
        
        var temEstoque = await $.fn.doAjax({
            url: 'estoques/produto-existe-quantidade',
            type: 'POST',
            data: oData
        })
        
        if (!temEstoque.tem_estoque_suficiente)
            return {
                message: 'Ops!',
                text: 'O sistema não encontrou a quantidade desejada desse produto nesse endereço, favor verificar o inventário!',
                status: 400,
            }

        return {
            message: 'OK',
            status: 200,
        }
    },
    restructureItemSeparado: async function() {
        return await $.fn.executeFirst(async function(resolve) {
            var sEnderecoComposicao = Separacao.getState('dados_endereco_picking.ordem_servico_item_separacao.endereco_composicao')

            await ManageRoutineData.setItemSeparado(sEnderecoComposicao)

            return resolve()
        })
    },
    setItemSeparado: async function(sEnderecoComposicao) {
        return await $.fn.executeFirst(async function(resolve) {
            var aDadosEndereco = ManageRoutineData.getDadosEndereco(sEnderecoComposicao)

            aDadosEndereco.qtde_separada = Separacao.getState('qtde_separada')
            aDadosEndereco.endereco_separado = Separacao.getState('endereco_separado')

            if (!ObjectUtil.isset(aDadosOperacao.enderecos_ordenados.informativos.separados)) 
                aDadosOperacao.enderecos_ordenados.informativos.separados = new Object;

            aDadosOperacao.enderecos_ordenados.informativos.separados[sEnderecoComposicao] = aDadosEndereco

            delete aDadosOperacao.enderecos_ordenados.com_heuristica[sEnderecoComposicao]

            return resolve()
        })
    }
}
