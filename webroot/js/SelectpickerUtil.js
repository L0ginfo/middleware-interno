const SelectpickerUtil = {
    init() {
        this.blockSelectNullValues()
    },
    blockSelectNullValues() {
        $('select.selectpicker.block-select-null-values:not(.watched-null)').each(function() {
            var $that = $(this)
            $that.addClass('watched-null')

            var todo = function() {
                $that.find('option:selected[value=""]').prop('selected', false)
                $('.selectpicker').selectpicker('refresh')
            }

            todo()

            $that.change(function() {
                todo()
            })
        })
    }
}

$(window).load(function() {
    SelectpickerUtil.init()
})