import { Separacao, ManageFrontend }  from './OperacaoSeparacaoClass.js'

$(document).ready(function() {

    const init = async function() {
        await ManageFrontend.init()
        Separacao.init()
    }

    init()
}) 