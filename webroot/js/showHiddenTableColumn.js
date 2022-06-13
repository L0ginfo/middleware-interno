/**
 * Este script serve para
 * mostrar ou ocultar colunas de tabelas
 */
$(document).ready(function () {
    indexes = getColunas()
   // console.log(indexes)
    if (indexes) {
        for (i in indexes) {
            addColuna(indexes[i].index, indexes[i].nome)
            removeColuna(indexes[i].index)
        }
    } else {
        $('.panel').hide()
    }
})

/**
 * Ocultar coluna
 */
$(document).on('click', '.ocultarColuna', function () {
    index = $(this).parent('th').index() + 1
    nome = $(this).prev('a').html() || $(this).parent('th').html().replace(/<(?:.|\n)*?>/gm, '')
    removeColuna(index)
    addColunaOculta(index, nome)
})

/**
 * Mostrar coluna
 */
$(document).on('click', '.mostrarColuna', function () {
    nome = $(this).html()
    index = $(this).attr('coluna')
    $('table tr td:nth-child(' + index + '), table tr th:nth-child(' + index + ')').show()
    removeColunaOculta(index, nome)
    $(this).remove()
    if (!($('.panel .mostrarColuna').length > 0 && localStorage.colunasOcultas)) {
        $('.panel').hide()
    }
})

function removeColuna(index) {
    $('table tr td:nth-child(' + index + '), table tr th:nth-child(' + index + ')').hide()
}

function addColuna(index, nome) {
    $('.panel').show()
    $('.panel').append('<span class="mostrarColuna click" coluna="' + index + '" style="margin-left:10px;" title="Mostrar coluna">' + nome + '</span>')
}

function addColunaOculta(index, nome) {
    indexes = getColunas()
    if (indexes) {
        // remover duplicado
        for (i in indexes) {
            if (!existeColuna(indexes, index, nome)) {
                indexes.push({index, nome})
                addColuna(index, nome)
            }
        }
    } else {
        indexes = []
        indexes.push({index, nome})
        addColuna(index, nome)
    }
    localStorage.setItem("colunasOcultas", JSON.stringify(indexes))
}

function getColunas() {
    return localStorage.colunasOcultas ? JSON.parse(localStorage.colunasOcultas) : false
}

function existeColuna(indexes, index, nome) {
    for (i in indexes) {
        if (indexes[i].nome == nome && indexes[i].index == index) {
            return true
        }
    }
    return false
}

function removeColunaOculta(index, nome) {
    indexes = getColunas()
    for (i in indexes) {
        if (existeColuna(indexes, index, nome)) {
            indexes.splice(i, 1)
        }
    }
    if (indexes.length > 0) {
        localStorage.setItem('colunasOcultas', JSON.stringify(indexes))
    } else {
        localStorage.removeItem('colunasOcultas')
    }
}
