/*jshint esversion: 6 */

class ListMobileComponent {

    constructor(componetId, paginate = false) {
        this.componetId = componetId;
        this.paginate = paginate;
        this._getPagineteButtons();
        this._addEventListiners();
        this._setview(componetId);
    }

    _setview(componetId){
        this.view = document.querySelector(componetId);
    }

    _getPagineteButtons(){
        if(this.paginate){
            this.paginateStart = 1;
            this.paginatePosition = 1;
            this.paginateEnd = document.querySelector(`.list-mobile`).dataset.size;
            this.paginateBackButton = document.querySelector(`#back-button-list-mobile`);
            this.paginateNextButton = document.querySelector(`#next-button-list-mobile`);
            this._addEventListinersPagineteButton();
        }
    }

    _showView(){
        this.view.classList.toggle('active');
        return this.view.classList.contains('active'); 
    }


    _showPaginateButtons(show = true){
 
        if(!this.paginate){
            return ;
        }

        if(this.paginateStart == this.paginateEnd){
            return;
        }

        if(!show){
            this.paginateBackButton.classList.add("hidden");
            this.paginateNextButton.classList.add("hidden");
            this.paginateBackButton.disabled = true;
            this.paginateNextButton.disabled = true;
        }

        this.paginateBackButton.classList.remove("hidden");
        this.paginateNextButton.classList.remove("hidden");

        if(this.paginatePosition == 1){
            this.paginateBackButton.disabled = true;
            this.paginateNextButton.disabled = false;
            return;
        }

        if(this.paginatePosition == this.paginateEnd){
            this.paginateBackButton.disabled = false;
            this.paginateNextButton.disabled = true;
            return;
        }

        this.paginateBackButton.disabled = false;
        this.paginateNextButton.disabled = false; 
    }

    _addEventListiners(){
        document
        .querySelector('.list-mobile-click')
        .addEventListener("click", function(){
            const show = this._showView();
            this._showPaginateButtons(show);
        }.bind(this));
    }

    _addEventListinersPagineteButton(){

        this.paginateBackButton.addEventListener('click', function(){
            this.paginatePosition -= 1;
            document.querySelectorAll('.list-paginete-item').forEach(function(element){
                element.classList.add('hidden');
            });
            document.querySelector(`#list-page-${this.paginatePosition}`)
                .classList.remove('hidden');
            this._showPaginateButtons();
        }.bind(this));

        this.paginateNextButton.addEventListener('click', function(){
            this.paginatePosition += 1;
            document.querySelectorAll('.list-paginete-item').forEach(function(element){
                element.classList.add('hidden');
            });
            console.log(`#list-page-${this.paginatePosition}`);
            document.querySelector(`#list-page-${this.paginatePosition}`)
                .classList.remove('hidden');
            this._showPaginateButtons();
        }.bind(this));
    }
}

window.ListMobileComponent = ListMobileComponent;
