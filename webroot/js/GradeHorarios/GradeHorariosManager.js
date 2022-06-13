var GradeHorariosManager = {

    init: function() {

        GradeHorariosManager.watchInputRedirecionamento()
        GradeHorariosManager.watchRedirecionamento()

    },

    watchInputRedirecionamento: function() {
        
        $('.grade_redirecionamento').change(function () {

            GradeHorariosManager.managerInputsUrl($(this).val())

        })

    },

    watchRedirecionamento: function() {

        GradeHorariosManager.managerInputsUrl($('.grade_redirecionamento').val())

    },

    managerInputsUrl: function(iValue) {

        if (iValue == 0) {
            $('.inputs_url').addClass('hidden')
            $('.input_controller').val('')
            $('.input_action').val('')
        } else {
            $('.inputs_url').removeClass('hidden')
        }

    }

}

$(document).ready(function() {

    GradeHorariosManager.init()

})