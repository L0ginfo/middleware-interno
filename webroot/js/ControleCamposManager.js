var ControleCamposManager = {
    init:function(){
        this.execute();
    },

    execute:function(){
        const oInputs = ControleCamposManager.getDepth(oControleCampos, `${sNameController}`);
        const aInputs = (function(oItens, controller, action, perfil){
            let inputs = [];
            for (const key in oItens) {
                const oItem = ControleCamposManager.getControleManager(key , controller, action, perfil);
                inputs.push(oItem);
            }
            return inputs;
        })(oInputs, sNameController, sNameAction, sPerfilUsurio);
        console.log('ControleCampos:', sNameController, sNameAction, sPerfilUsurio);
        console.log(aInputs);
        aInputs.forEach(item => {
            item.execute();
        });
    },
    
    get: function (sInput, sController, sAction, iPerfil){        
        const aCampos = ControleCamposManager.getDepth(oControleCampos, `${sController}.${sInput}`);
        if(!aCampos) return null;
        const oItem = aCampos.find((value) =>{
            const aAcoes = value.controle_campo_acoes;

            if(!aAcoes || aAcoes.length == 0 || !sAction) 
                return true;

            if(aAcoes.hasOwnProperty(sAction)){
                const aPerfis = aAcoes[sAction].perfis;
                if(!aPerfis || aPerfis.length == 0 || !iPerfil) return true;
                if(aPerfis.hasOwnProperty(iPerfil)) return true;
                return false;
            }
        });
        return oItem;
    },

    getControleManager:function(sInput, sController, sAction, iPerfil){
        const oItem = ControleCamposManager.get(sInput, sController, sAction, iPerfil);
        const clone = Object.assign({}, CamposManager);
        clone.init(oItem);
        return clone;
    },

    getDepth:function(oObject, sString){
        try {
            return ObjectUtil.getDepth(oObject, `${sString}`);  
        } catch (error) {
            return null;
        }
    }
};


var CamposManager = {
    oCampo: {},

    init:function(oCampo){
        this.oCampo = oCampo ? oCampo : {};
    },

    getCampo:function(){
        return this.oCampo;
    },

    getEmpty:function(){
        return !this.oCampo ||  this.oCampo.length == 0;
    },

    isHidden:function(defaultValue){
        defaultValue = defaultValue ? defaultValue : 0;
        return this.oCampo.hasOwnProperty('hidden') ? this.oCampo.hidden:defaultValue;
    },

    isReadOnly:function(defaultValue){
        defaultValue = defaultValue ? defaultValue : 0;
        return this.oCampo.hasOwnProperty('readonly') ? this.oCampo.readonly:defaultValue;
    },

    isRequired:function(defaultValue){
        defaultValue = defaultValue ? defaultValue : 0;
        return this.oCampo.hasOwnProperty('readonly') ? this.oCampo.required:defaultValue;
    },

    getPattern:function(){
        return this.oCampo.hasOwnProperty('pattern') ? this.oCampo.pattern: '';
    },

    getOcorrencia:function(){
        return this.oCampo.hasOwnProperty('ocorrencia') ? this.oCampo.ocorrencia: 0;
    },

    getOcorrencias:function(sFind){
        const iOcorrencia = this.getOcorrencia();
        const sPattern = this.getPattern();

        switch (iOcorrencia) {
            case 1:
                return $(sPattern).first();

            case 2:
                return $(sPattern);

            case 3:
                return $(sPattern).find(sFind);
        
            default: return false;
        }
    },

    execute:function(){
        const oObject = this.getOcorrencias();

        if(!oObject) return true;

        if(this.isHidden()){
            oObject.addClass('hidden');
        }else{
            oObject.removeClass('hidden');
        }

        if(this.isReadOnly()){
            oObject.attr('readonly', true);
            if(oObject.is('select')) oObject.attr('disabled', true);
        }else{
            oObject.attr('readonly', false);
            if(oObject.is('select')) oObject.attr('disabled', false);
        }

        if(this.isRequired()){
            oObject.attr('required', true);
        }else{
            oObject.attr('required', false);
        }

    }
}



setTimeout(function(){
    $(function(){
        ControleCamposManager.init();
    });
}, 3000);



