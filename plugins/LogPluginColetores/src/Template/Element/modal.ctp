<!-- The Modal -->

<?php $id = @$id ? : 'lf-modal-coletor' ;?>
<?php $footer = !isset($footer)? true : $footer;?>
<?php $showCancel = isset($showCancel)? $showCancel : false;?>

<div id="<?= $id ?>" class="lf-modal">

  <!-- Modal content -->
  <div class="lf-modal-content">
    <div class="lf-modal-header">
        <span class="lf-modal-icon lf-modal-close">&times;</span>
        <h3> <?= @$title ? : '' ?></h3>
    </div>

    <div class="lf-modal-body">
        <?= @$content ?>
    </div>

    <?php if($footer):?>

        <div class="lf-modal-footer text-center" >

            <a type="button" class="btn btn-success lf-modal-success" >
               <?= @$btnSucessTitle ?: 'Aceitar' ?>
            </a>

            <?php if($showCancel): ?>
                <a type="button" class="btn btn-danger lf-modal-close">
                    <?= @$btnDanferTitle ?: 'Cancelar' ?>
                </a>
            <?php endif; ?>
        </div>

    <?php endif;?>

  </div>

</div>


<script>

    var simpleModal  = {

        init : function(id, callback = null) {
            this.events(id);
            if(callback) this.sucesso(id, callback);
        },

        dimiss:function(){
            $('.lf-modal').hide();
        },

        sucesso:function(is, callback){
            $(id).click(callback(e));
        },

        events:function (id){

            $('.lf-modal .lf-modal-close').click(function(e){
                $('.lf-modal').hide();
            });

            $(window).click(function(e){
                //console.log(e);
                //console.log($(e));
                var modal = document.getElementById(id);
                if (event.target == modal) {
                    $('.lf-modal').hide();
                }
            });
        }
    };

    simpleModal.init("#<?=$id?>");

</script>