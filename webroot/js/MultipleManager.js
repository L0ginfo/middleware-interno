var MultipleManager = {
    tagName :'select.manage-multiple, .manage-multiple.selectpicker select',
    dataOriginal:{},
    dataRemove:{},
    dataInclude:{},
    init:function(){
        try {
            MultipleManager.originals();
            MultipleManager.events();
        } catch (error) {
            console.error(error);
        }
    },
    events:function(){
        $('.form-manage-multiple').submit(function(e){
            try {
                MultipleManager.execute('.form-manage-multiple');
            } catch (error) {
                console.error(error);
            }
        }); 
    },
    originals:function(){
        document.querySelectorAll(MultipleManager.tagName).forEach(element => {
            MultipleManager.dataOriginal[MultipleManager.getName(element)] = MultipleManager.getList(element);
        });
    },
    execute:function(sFather){
        const father = document.querySelector(sFather);

        if(!father) return console.log('multiple invalid father.');

        document.querySelectorAll(MultipleManager.tagName).forEach(element => {
            MultipleManager.getLists(element);
        });

        for (prop in MultipleManager.dataRemove) {
            const child = document.createElement('input');
            child.setAttribute('type', 'hidden');
            child.setAttribute('name', prop+'_del');
            child.setAttribute('value', 
                JSON.stringify(MultipleManager.dataRemove[prop])
            );
            father.appendChild(child);
        }
        
        for (prop in MultipleManager.dataInclude) {
            const child = document.createElement('input');
            child.setAttribute('type', 'hidden');
            child.setAttribute('name', prop+'_add');
            child.setAttribute('value', JSON.stringify(
                MultipleManager.dataInclude[prop])
            );
            father.appendChild(child);
        }
    },
    getName: function (element){
        return element.name.replace(/[\[\]]/gi,'');
    },
    getList: function(element){
        return [...element.selectedOptions]
            .map(information => information.value);
    },
    getLists:function (element){
        MultipleManager.dataRemove[MultipleManager.getName(element)] = 
        MultipleManager.generateListOfDeletions(
            MultipleManager.dataOriginal[MultipleManager.getName(element)], 
            MultipleManager.getList(element)
        );
        MultipleManager.dataInclude[MultipleManager.getName(element)] =
        MultipleManager.generateListOfInclusions(
            MultipleManager.dataOriginal[MultipleManager.getName(element)], 
            MultipleManager.getList(element)
        );
    },
    generateListOfDeletions:function (listOriginal, listModify){
        return listOriginal
            .filter(original =>!listModify
            .some(modify => original == modify));
    },
    generateListOfInclusions:function(listOriginal, listModify){
        return listModify
            .filter((modify) => !listOriginal
            .some(original =>original == modify));
    }
};

$(function(){
    MultipleManager.init();
})

