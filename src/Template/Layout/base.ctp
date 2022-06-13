<?php
// echo $this->Html->meta('icon');

echo $this->Html->css([
    'datatables.min',
    '/bower_components/metisMenu/dist/metisMenu.min',
    '/bower_components/font-awesome/css/font-awesome.min',
    'bootstrap-datepicker3',
    // 'jquery.fancybox',
    // 'jquery.fancybox-buttons',
    // 'jquery.fancybox-thumbs',
    'style',
    // 'jquery.qtip.min.css',
    '/bower_components/bootstrap-select/dist/css/bootstrap-select',
    '/bower_components/datetimepicker/css/bootstrap-datetimepicker',
]);

echo $this->Html->script([
    'geral',
    '/bower_components/jquery/dist/jquery.min',
    'datatables.min',
    '/bower_components/metisMenu/dist/metisMenu.min',
    'bootstrap-datepicker',
    '/locales/bootstrap-datepicker.pt-BR',
    'datepicker.config',
    // 'jquery.fancybox.pack',
    'jquery.mask.min',
    // 'jquery.qtip.min.js',
    '/bower_components/bootstrap-select/dist/js/bootstrap-select',
    'button',
]);

echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');

?>


