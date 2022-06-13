var simpleMask = {
    mask:function(string, mask){
        var maskared = '';
        var subIndex = 0;

        for (var index = 0; index < mask.length; index++) {
            if(this.exist(string, subIndex)){
                if(mask[index]  == '#'){
                    if(this.exist(string, subIndex)) maskared += string[subIndex++];
                }else{
                    maskared+=mask[index];
                }
            }
        }

        return maskared;
    },

    masks:function(string, masks){
        if(masks.length == 0) return string;
        for (var maskKey in masks) if(string.length > masks[maskKey].length) break;
        this.mask(string,  masks[maskKey]);
    },

    exist:function(string, pos){

        try {
            if(string.charAt(pos) != '') return true;
            return false;
        } catch (error) {
            return false;
        }
    }
};