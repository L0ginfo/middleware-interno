import { Ferroviario }  from './FerroviarioClass.js'

$(document).ready(function() {

    const init = async function() {
        await Ferroviario.init()
    }

    init()
}) 