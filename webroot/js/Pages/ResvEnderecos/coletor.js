const ColetorEnderecos = {
  init: function() {
    this.manageFocusInputs()
    this.onDoubleClickEndereco()
    this.onDoubleClickResv()
    this.onClickBtn()
    this.watchSubmit()
    this.onEnterResv()
  },

  watchSubmit: function() {
    $('.resv-enderecos-submit').submit(function(e){

      if (Utils.manageRequiredCustom()) {
        e.preventDefault()
        return false
      }


      return true
    })
  },
  manageFocusInputs: function() {
    $('.endereco-digitado').focusin(function() {
        Utils.focusInShadow('.endereco-digitado, .endereco-barcode')
    })

    $('.endereco-digitado').focusout(function() {
        Utils.focusOutShadow('.endereco-digitado, .endereco-barcode')
        $(this).attr('inputmode', 'none')
    })

    $('.resv-id').focusin(function() {
        Utils.focusInShadow('.resv-id')
    })

    $('.resv-id').focusout(function() {
        Utils.focusOutShadow('.resv-id')
        $(this).attr('inputmode', 'none')
    })
  },
  onDoubleClickEndereco: function() {
      oHooks.watchDoubleClick('.endereco-digitado', () => { alert(); $('.endereco-digitado').attr('inputmode', 'decimal') })
  },
  onDoubleClickResv: function() {
      oHooks.watchDoubleClick('.resv-id', () => { $('.resv-id').attr('inputmode', 'decimal') })
  },
  onClickBtn: function() {
    var prepareInput = async function() {
      $('.endereco-digitado').removeClass('exibindo-composicao')
      $('.endereco-digitado').val(null)
      $('.endereco-digitado').prop('readonly', false)
      setTimeout(() => Utils.focusOnElem('.endereco-digitado'), 300)
    }

    $('.endereco-barcode').click( function() {
      prepareInput()
    })
  },
  onEnterResv: function() {
    var prepareInput = async function() {
      $('.endereco-digitado').removeClass('exibindo-composicao')
      $('.endereco-digitado').val(null)
      $('.endereco-digitado').prop('readonly', false)
      setTimeout(() => Utils.focusOnElem('.endereco-digitado'), 300)
    }

    $('.resv-id').keyup( function(e) {
      if (e.keyCode == 13) {
        prepareInput()
      }
    })
  }
}

$(document).ready(function() {
  ColetorEnderecos.init()
})