$(document).ready(function() {

    const init = async function() {
        await AvariasManager.init()
    }

    init()

    const watchGetAvarias = async function() {
        await AvariasManager.watchGetAvarias()
    }

    watchGetAvarias()

});