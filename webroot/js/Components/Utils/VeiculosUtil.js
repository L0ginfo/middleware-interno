var VeiculosUtil = {

    init: function($veiculoInput, $modalInput) {
        VeiculosUtil.manageMaskByModal($veiculoInput, $modalInput);
    },

    manageMaskByModal: function($veiculoInput, $modalInput) {

        if ($modalInput.find('option:selected').text().replace(' ', '').toLowerCase() == 'rodoviário') {
            $veiculoInput.addClass('lf-mask-veiculo');
            $veiculoInput.mask('AAA-0X00', {
                'translation': {
                    X: {
                        pattern: /[A-Za-z0-9]/
                    }
                }
            });
        }

        $modalInput.change(function() {
            if ($(this).find('option:selected').text().replace(' ', '').toLowerCase() != 'rodoviário') {
                $veiculoInput.removeClass('lf-mask-veiculo');
                $veiculoInput.unmask();
            } else {
                $veiculoInput.addClass('lf-mask-veiculo');
                $veiculoInput.mask('AAA-0X00', {
                    'translation': {
                        X: {
                            pattern: /[A-Za-z0-9]/
                        }
                    }
                })
            }
        });

    }
}