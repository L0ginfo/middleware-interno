/*jshint esversion: 6 */


(function(){    

    class PlanejamentoMaritimo {
        constructor() {
            this._onReady();
        }

        _onReady(){
            this.versao = 1;
            this.versao_atual = 1;
            this.eventos = [];
            this._addEvents();
            this._mask();
            this._mobile();

            if(this._canNotDo()){
                return;
            }
            
            this._setVersao();
            this._find();
            this._getLineUP();
        }

        _smallDevice(){
            return window.innerWidth < 1199 || window.Utils.isMobile();
        }

        _mobile(){

            if(this._smallDevice()){
                $('.block-system').addClass('block-system-mobile');
            }
        }

        _canNotDo(){
            return document.querySelector('#id') ? false : true;
        }

        _mask(){
            //$('#viagem-numero').mask('AAA/AAAA');
        }

        _find(){
            this.url = document.querySelector('#id').dataset.lineUp;
            this.deleteUrl = document.querySelector('#id').dataset.deleteLineUp;
            this.id = document.querySelector('#id').value;
        }

        _addEvents(){
            //Click Event
            this._showAndHideBlockEvent();
            //Mostra os elementos não preenchidos
            document.querySelector('form').addEventListener('invalid', (e)=>{
                if(e.target.parentElement.parentElement.classList.contains("block")){
                    e.target.parentElement.parentElement.classList.add('active');
        
                    if(e.target.parentElement.parentElement.previousElementSibling.classList
                        .contains("border-bottom")){
                        let element = e.target.parentElement.parentElement
                            .previousElementSibling.firstElementChild.firstElementChild;
                        element.classList.remove('fa-chevron-up');
                        element.classList.add('fa-chevron-down');         
                                
                    }
                    return; 
                }
        
                if(e.target.parentElement.parentElement.parentElement.classList.contains("block")){
                    e.target.parentElement.parentElement.parentElement.classList.add('active');
        
                    let element = e.target.parentElement.parentElement.parentElement
                            .previousElementSibling.firstElementChild.firstElementChild;
                        element.classList.remove('fa-chevron-up');
                        element.classList.add('fa-chevron-down'); 
        
                    return; 
                }
        
            },true);

            $('#back').click((function(event){
                this._showBackLineUp();
            }).bind(this));

            $('#next').click((function(event){
                this._showNextLineUp();
            }).bind(this));

            $('#plus').click((function(event){
                this._addNewVersao();
            }).bind(this));

            $('#start').click((function(event){
                this._showStartLineUp();
            }).bind(this));

            $('#end').click((function(event){
                this._showEndLineUp();
            }).bind(this));

            $('#minus').click((function(event){
                this._deleteVersao();
            }).bind(this));

            $('[name ="navio_id"]').change(function(){

                if(!this.value || this.value <= 0){
                    return;
                }

                $.fn.doAjax({
                    url:`planejamentoMaritimos/getNavio/${this.value}`
                })
                .then( res => {
                    console.log(res);
                    if(res && res.status == 200){
                        $('#loa').val(res.dataExtra.loa);
                        $('#imo').val(res.dataExtra.imo);
                    }
                });
            });

            this._toogleBlock();
        }

        _showAndHideBlockEvent(){
            //evento escoder e mostrar blocos 
    
            $('.fa-chevron-up').click(function(){
                if($(this).hasClass('fa-chevron-up')){
                    return $(this).removeClass('fa-chevron-up').addClass('fa-chevron-down');
                }
                $(this).removeClass('fa-chevron-down').addClass('fa-chevron-up');
            });

            $('.fa-chevron-down').click(function(){
                if($(this).hasClass('fa-chevron-up')){
                    return $(this).removeClass('fa-chevron-up').addClass('fa-chevron-down');
                }
                $(this).removeClass('fa-chevron-down').addClass('fa-chevron-up');
            });

        }

        _getLineUP(){

            fetch(this.url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(res => {
                if(!res.eventos || !res.versao || res.eventos.length <= 0)
                {  
                   return; 
                }
                this.versao = res.versao;
                this.versao_atual = res.versao;
                this.eventos = res.eventos;
                this._setVersao();
                this._setLineUpEvents(res.versao);
            });
        }

        _setLineUpEvents(versao){

            this._clearEventsInputs();

            this.eventos[versao].forEach((event, index) => {
                document.querySelector(
                    `#data-evento-id-${event.evento_id}`).value = event.data_hora_evento;
            });

            this._setSituacaoEvents(this.eventos[versao]);
        }

        _setSituacaoEvents(eventos){
            let situacao_line_up = document.querySelector( `#situacao-line-up`);
           
            if(!Array.isArray(eventos)){
                situacao_line_up.value = 1;
                return;
            }

            if(eventos.length == 0){
                situacao_line_up.value = 1;
                return;
            }

            situacao_line_up.value = eventos[0].situacao_id;
        }

        _setVersao(){
            document.querySelector(
                `#versao-line-up`).value = this.versao;
            this._setVersaoAtual();
        }

        _setVersaoAtual(){
            document.querySelector(`#label-versao`).innerHTML = `Versão ${this.versao_atual}/${this.versao}`;
            document.querySelector(`#versao-atual-line-up`).value = this.versao_atual;
        }

        _addNewVersao(){

            if(this.eventos.length == 0){
                return;
            }

            this.versao_atual = this.versao+1;
            this._setVersaoAtual();
            this._clearEventsInputs(true);

        }

        _deleteVersao(){

            const situacao = document.querySelector('#situacao-line-up').value;

            if(situacao != 1){
                return;
            }


            if(this.eventos.length == 0){
                return;
            }

            if(this.versao_atual > this.versao){
                this.versao_atual = this.versao;
                this._setVersao();
                this._setLineUpEvents(this.versao);
                return;
            }

            fetch(this.deleteUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body:JSON.stringify({
                    versao_atual:this.versao_atual,
                    planejamento_maritimo_id : this.id,
                })
            })
            .then(response => response.json())
            .then(res => {
                if(res.status == 200 ){

                    if(!res.dataExtra.eventos || !res.dataExtra.versao || res.dataExtra.eventos.length <= 0)
                    {  
                        this.versao = 1;
                        this.versao_atual = 1;
                        this.eventos = [];
                        this._setVersao();
                        this._clearEventsInputs();
                        return;
                    }


                    this.versao = res.dataExtra.versao;
                    this.versao_atual = res.dataExtra.versao;
                    this.eventos = res.dataExtra.eventos;
                    this._setVersao();
                    this._setLineUpEvents(res.dataExtra.versao);
                    return;
                } 

                Utils.swalUtil({
                    title : 'Erro',
                    text : 'Falha ao deletar a versao.',
                    type : 'error',
                    timer:3000
                }).then(() => Utils.refreshPage());
            });

        }

        _showNextLineUp(){
            this.versao_atual++;
            if(this.versao_atual > this.versao){
                this.versao_atual--;
                return;
            }
            this._setVersaoAtual();
            this._clearEventsInputs(true);
            this._setLineUpEvents(this.versao_atual);
        }

        _showBackLineUp(){
            this.versao_atual--;
            if(this.versao <= 1 || this.versao_atual < 1){
                this.versao_atual++;
                return;
            }
            this._setVersaoAtual();
            this._clearEventsInputs(true);
            this._setLineUpEvents(this.versao_atual);
        }

        _showStartLineUp(){

            if(this.versao_atual > 1){
                this.versao_atual = 1;
                this._setVersaoAtual();
                this._clearEventsInputs(true);
                this._setLineUpEvents(1);
            }
        }

        _showEndLineUp(){

            if(this.versao_atual < this.versao){
                this.versao_atual = this.versao;
                this._setVersaoAtual();
                this._clearEventsInputs(true);
                this._setLineUpEvents(this.versao);
            }
        }

        _clearEventsInputs(focus = false){
            [...document.querySelectorAll(".lf-line-up .block-body-2 input")]
                .forEach(function(value, index){
                    value.value = ''; if(focus && index ===0 ) value.focus();});
        }

        _toogleBlock(){
            $('.verticaly-buttom').click(function(event){
                $('.registers .one-component .element').toggleClass('col-lg-3');
                $('.registers .one-component .element').toggleClass('col-lg-6');
                $('.registers .two-components').toggleClass('col-lg-12');
                $('.registers .two-components').toggleClass('col-lg-6');
                $('.registers').toggleClass('col-lg-12');
                $('.registers').toggleClass('col-lg-6');
                $('.block-system-mobile .registers').toggleClass('hidden');
                $('.line-up .block-module').toggleClass('hidden');
                $('.line-up .verticaly-buttom i ').toggleClass('fa-chevron-left');
                $('.line-up .verticaly-buttom i').toggleClass('fa-chevron-right');

                if(this._smallDevice()){
                    $('.line-up').toggleClass('col-lg-12');
                }else{
                    $('.line-up').toggleClass('col-lg-6');
                }

            }.bind(this));

            $('.show-line-up').click(function(event){
                $('.registers .one-component .element').toggleClass('col-lg-3');
                $('.registers .one-component .element').toggleClass('col-lg-6');
                $('.registers .two-components').toggleClass('col-lg-12');
                $('.registers .two-components').toggleClass('col-lg-6');
                $('.registers').toggleClass('col-lg-12');
                $('.registers').toggleClass('col-lg-6');
                $('.block-system-mobile .registers').toggleClass('hidden');
                $('.line-up .block-module').toggleClass('hidden');
                $('.line-up .verticaly-buttom i ').toggleClass('fa-chevron-left');
                $('.line-up .verticaly-buttom i').toggleClass('fa-chevron-right');

                if(window.Utils.isMobile()){
                    $('.line-up').toggleClass('col-lg-12');
                }else{
                    $('.line-up').toggleClass('col-lg-6');
                }
            });
        }
    }
    
    const aux = new PlanejamentoMaritimo();
})();