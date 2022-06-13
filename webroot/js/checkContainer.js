$('#container').change(function(){
    checkContainerNumber($(this).val())
})

function checkContainerNumber(container) {
    //para testar
    //container = "HOYU7510136"
    letras = {
        A: 10, B: 12, C: 13, D: 14, E: 15, F: 16, G: 17, H: 18, I: 19, J: 20,
        K: 21, L: 23, M: 24, N: 25, O: 26, P: 27, Q: 28, R: 29, S: 30, T: 31,
        U: 32, V: 34, W: 35, X: 36, Y: 37, Z: 38
    }
    soma = 0
    for (var x = 0; x < container.length - 1; x++) {
        if (isNaN(container[x])) {
            soma = soma + letras[container[x]] * Math.pow(2, x)
        } else {
            soma = soma + container[x] * Math.pow(2, x)
        }
    }
    if (!soma % 11 == container.slice(-1)) {
        alert('Número do container errado!')
    }
}