<!-- <div class="alert alert-warning" onclick="this.classList.add('hidden');"><?= h($message) ?></div> -->

<script>
    var haveAnotherSwal = 'initial_only';
    var $that = ( typeof $ != 'undefined' ) ? $(this) : null
    Loader.close(true)

    Swal.fire({
        type: 'warning',
        title: '<?= isset($params['title']) ? h($params['title']) : '' ?>',
        text:  '<?= isset($message) ? h($message) : "" ?>',
        html: '<?= isset($message) ? h($message) : "" ?> <?= isset($params['html']) ? ($params['html']) : "" ?> ',
        showConfirmButton: false,
        timer: <?= isset($params['timer']) ? $params['timer'] : 2000 ?>,
        allowOutsideClick: <?= isset($params['allow_outside_click']) ? 'JSON.parse('.json_encode($params['allow_outside_click']).')' : true ?>,
        onClose: function () {
            alreadyExecutedOutside = true
    
            if ($.fn){
                $.fn.trigger('swal-flash-closed')
            }
        }

    });
</script>
