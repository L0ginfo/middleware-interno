<script>

    oColetorApp.nestedTree = {
        select: {
            __label__: {
                type: 'depth',
                referer: 'descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },

            __id__: {
                type: 'depth',
                referer: 'id',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            }
        },
        select_ternos: {
            __label__: {
                type: 'depth',
                referer: 'descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },

            __id__: {
                type: 'depth',
                referer: 'planejamento_maritimo_terno_id',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            }
        },
        select_poroes : {
            __label__: {
                type: 'depth',
                referer: 'descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },

            __id__: {
                type: 'depth',
                referer: 'id',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            }
        },
        select_produto : {
            __label__: {
                type: 'depth',
                referer: 'descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },

            __id__: {
                type: 'depth',
                referer: 'id',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            }
        },
        select_termos : {
            __label__: {
                type: 'depth',
                referer: 'terno.descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },

            __id__: {
                type: 'depth',
                referer: 'terno.id',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            }
        },
        lingadas:{
            __id__: {
                type: 'depth',
                referer: 'id',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __item__: {
                type: 'depth',
                referer: 'codigo',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __quantidade__: {
                type: 'depth',
                referer: 'qtde',
                rule:{
                    type:'floatPtBr',
                    precision:3
                },
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __peso__: {
                type: 'depth',
                referer: 'peso',
                rule:{
                    type:'floatPtBr',
                    precision:3
                },
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __datetime__: {
                type: 'depth',
                referer: 'created_at',
                rule:{
                    type:'dateAsDate',
                    format:'h:i',
                    divider:'T'
                },
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
        },
        associacao_ternos:{
            __id__: {
                type: 'depth',
                referer: 'id',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __porao__: {
                type: 'depth',
                referer: 'porao.descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __terno__: {
                type: 'depth',
                referer: 'terno.descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __periodo__: {
                type: 'depth',
                referer: 'porto_trabalho_periodo.descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __data__: {
                type: 'depth',
                referer: 'created_at',
                rule:{
                    type:'date',
                    format:'d/m/y',
                    divider:'T'
                },
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
        },
        lingadas_granel:{
            __id__: {
                type: 'depth',
                referer: 'id',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __item__: {
                type: 'depth',
                referer: 'codigo',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __terno__: {
                type: 'depth',
                referer: 'terno.descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __datetime__: {
                type: 'depth',
                referer: 'created_at',
                rule:{
                    type:'dateAsDate',
                    format:'h:i',
                    divider:'T'
                },
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
        },
        lingada_remocoes:{
            __id__: {
                type: 'depth',
                referer: 'id',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },

            __item__: {
                type: 'depth',
                referer: 'produto.codigo',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __remocao__: {
                type: 'depth',
                referer: 'remocao.descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __quantidade__: {
                type: 'depth',
                referer: 'qtde',
                rule:{
                    type:'floatPtBr',
                    precision:3
                },
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __datetime__: {
                type: 'depth',
                referer: 'created_at',
                rule:{
                    type:'dateAsDate',
                    format:'h:i',
                    divider:'T'
                },
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
        },
        lingada_historicos:{
            __id__: {
                type: 'depth',
                referer: 'id',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __porao__: {
                type: 'depth',
                referer: 'plano_carga_porao.porao.descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },

            __placa__: {
                type: 'depth',
                referer: 'resv.veiculo.veiculo_identificacao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },

            __item__: {
                type: 'depth',
                referer: 'codigo',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __quantidade__: {
                type: 'depth',
                referer: 'qtde',
                rule:{
                    type:'floatPtBr',
                    precision:3
                },
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __peso__: {
                type: 'depth',
                referer: 'peso',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __datetime__: {
                type: 'depth',
                referer: 'created_at',
                rule:{
                    type:'dateAsDate',
                    format:'h:i',
                    divider:'T'
                },
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
        },
        lingada_historicos_remocoes:{
            __placa__: {
                type: 'depth',
                referer: 'ordem_servico_item_lingada.resv.veiculo.veiculo_identificacao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __porao__: {
                type: 'depth',
                referer: 'plano_carga_porao.porao.descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __remocao__: {
                type: 'depth',
                referer: 'remocao.descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __item__: {
                type: 'depth',
                referer: 'produto.codigo',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __quantidade__: {
                type: 'depth',
                referer: 'qtde',
                rule:{
                    type:'floatPtBr',
                    precision:3
                },
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __peso__: {
                type: 'depth',
                referer: 'peso',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __datetime__: {
                type: 'depth',
                referer: 'created_at',
                rule:{
                    type:'dateAsDate',
                    format:'h:i',
                    divider:'T'
                },
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
        },
        lingada_saldo_poroes:{
            __porao__: {
                type: 'depth',
                referer: 'porao_descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __qtde_prevista__: {
                type: 'depth',
                referer: 'qtde_prevista',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __peso_previsto__: {
                type: 'depth',
                referer: 'peso_previsto',
                rule:{
                    type:'floatPtBr',
                    precision:3
                },
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __qtde_realizada__: {
                type: 'depth',
                referer: 'qtde_realizada',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __peso_realizado__: {
                type: 'depth',
                referer: 'peso_realizado',
                rule:{
                    type:'floatPtBr',
                    precision:3
                },
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __saldo_qtde__: {
                type: 'depth',
                referer: 'saldo_qtde',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __saldo_peso__: {
                type: 'depth',
                referer: 'saldo_peso',
                rule:{
                    type:'floatPtBr',
                    precision:3
                },
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
        },
        lingada_avarias:{
            __id__: {
                type: 'depth',
                referer: 'id',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __tipo_avaria_id__: {
                type: 'depth',
                referer: 'avaria_id',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __tipo_avaria__: {
                type: 'depth',
                referer: 'avaria.descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __descricao__: {
                type: 'depth',
                referer: 'descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            }
        },
        lingada_avaria_fotos:{
            __id__: {
                type: 'depth',
                referer: 'id',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __name__: {
                type: 'depth',
                referer: 'name',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            }
        },
        caracteriscas:{
            __label__: {
                type: 'depth',
                referer: 'descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },

            __id__: {
                type: 'depth',
                referer: 'id',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },

            __options__: {
                type: 'depth',
                referer: 'options',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
        },
        paralisacoes: {
            __id__: {
                type: 'depth',
                referer: 'id',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __porao__: {
                type: 'depth',
                referer: 'porao.descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
            __motivo__: {
                type: 'depth',
                referer: 'paralisacao_motivo.descricao',
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },

            __inicio__: {
                type: 'depth',
                referer: 'data_hora_inicio',
                rule:{
                    type:'date',
                    format:'d/m/y h:i',
                    divider:'T'
                },
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },

            __fim__: {
                type: 'depth',
                referer: 'data_hora_fim',
                rule:{
                    type:'date',
                    format:'d/m/y h:i',
                    divider:'T'
                },
                when: [
                    {
                        value_referer: {
                            type: 'static',
                            referer: null
                        },
                        value_replace: {
                            type: 'static',
                            referer: ''
                        }
                    }
                ]
            },
        },
    };

</script>