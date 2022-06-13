// Prevent load page
window.onbeforeunload = function() {
    if(oColetorApp.bOnline) {
        return null;
    }

    return "Você está offline, deseja recarregar a página mesmo assim?";
}

// Disable load page with F5 or Ctrl+R
$(document).ready(function(){
    var ctrlKeyDown = false;

    function keydown(e) {
        if(!oColetorApp.bOnline) {
            if ((e.which || e.keyCode) == 116 || ((e.which || e.keyCode) == 82 && ctrlKeyDown)) {
                // Pressing F5 or Ctrl+R
                e.preventDefault();
            }
            else if ((e.which || e.keyCode) == 17) {
                // Pressing  only Ctrl
                ctrlKeyDown = true;
            }
        }
    };

    function keyup(e){
        if(!oColetorApp.bOnline) {
            // Key up Ctrl
            if ((e.which || e.keyCode) == 17)
                ctrlKeyDown = false;
        }
    };

    $(document).on("keydown", keydown);
    $(document).on("keyup", keyup);
});



