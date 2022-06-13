var oSubject = {
    observersEvents: new Array,

    init: function() {
        this.events()
        this.depalletizeEvents()
    },

    observersEvents: function() {
        return this.observersEvents
    },

    /**
     * É possivel salvar tambem eventos que nao sao dessa class
     * @param {*} eventName
     * @param {*} eventFunction
     */
    setEvents: function(eventName, eventFunction) {

        this.observersEvents[eventName] = {
            function: eventFunction,
            observers: []
        }

    },

    /**
     * Passa por todos eventos ativando as Triggers deles
     */
    depalletizeEvents: function() {
        var keys = Object.keys(this.observersEvents),
            that = this

        keys.forEach(function (eventName) {
            that.observersEvents[eventName].function()
        })

    },

    setObserverOnEvent: function(observer, events) {
        events.forEach(function (event) {

            if (typeof oSubject.observersEvents[event] === 'undefined') {
                oSubject.observersEvents[event] = {
                    observers: [],
                    function: () => {}
                }
            }

            oSubject.observersEvents[event].observers.push(observer)
        })
    },

    notifyAll: function(event) {
        var observersEvents = this.observersEvents

        observersEvents[event].observers.forEach(function (observer, index, arr) {
            observer()
        })
    },

    events: function() {
        this.setEvents('onDocumentChange', this.onDocumentChange)
        this.setEvents('onDocumentReady',  this.onDocumentReady)
    },

    /**
     * Eventos globais
     */
    onDocumentChange: function() {

        $(document).change(function () {
            oSubject.notifyAll('onDocumentChange')
        })
    },

    onDocumentReady: function() {

        $(document).ready(function () {
            oSubject.notifyAll('onDocumentReady')
        })
    },

}

oSubject.init()
