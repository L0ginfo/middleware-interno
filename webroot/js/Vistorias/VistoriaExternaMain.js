$(document).ready(function() {

    const init = async function() {
        await VistoriaExternaManager.init()
    }

    init()

    const watchGetLacres = async function() {
        await VistoriaExternaManager.watchGetLacres()
    }

    watchGetLacres()
    
});
