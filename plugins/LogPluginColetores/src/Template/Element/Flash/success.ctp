<!-- <div class="message success" onclick="this.classList.add('hidden')"><?= h($message) ?></div> -->

<script>
    var haveAnotherSwal = true;
    var $that = ( typeof $ != 'undefined' ) ? $(this) : null
    Loader.close(true)
    
    Swal.fire({
        type: 'success',
        title: '<?= isset($params['title']) ? h($params['title']) : '' ?>',
        text:  '<?= isset($message) ? h($message) : "" ?>',
        html: '<?= isset($message) ? h($message) : "" ?> <?= isset($params['html']) ? ($params['html']) : "" ?> ',
        showConfirmButton: false,
        timer: <?= isset($params['timer']) ? $params['timer'] : 2000 ?>,
        onClose: function () {
            alreadyExecutedOutside = true
    
            if ($.fn){
                $.fn.trigger('swal-flash-closed')
            }
        }
    });
</script>
