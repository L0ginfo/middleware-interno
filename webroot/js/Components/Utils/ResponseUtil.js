/**
 * Classe de Responses
 * 
 * IMPORTANTE: Quando feita qualquer alteração nessa classe
 * favor alterar também na ResponseUtil.php
 */

/**
 * Respostas de informação (100-199),
 * Respostas de sucesso (200-299),
 * Redirecionamentos (300-399)
 * Erros do cliente (400-499)
 * Erros do servidor (500-599).
 */

class ResponseUtil 
{

    constructor() 
    {
        this.message = this.translate('NOK')
        this.title = this.translate('Ops!')
        this.type = 'warning'
        this.status = 400
        this.error = null
        this.dataExtra = []
    }
    
    setError(uError) 
    {
        this.error = uError
        return this
    }

    getError() 
    {
        return this.error
    }

    setType(sType) 
    {
        this.type = sType
        return this
    }

    getType() 
    {
        return this.type
    }

    translate(sString)
    {
        try {
            return __(sString)
        } catch (th) {
            return sString
        }
    }

    setStatus(iStatus) 
    {
        if (iStatus === 200){
            this.setType('success')

            if (this.getMessage() === 'NOK')
                this.setMessage('OK')

            if (this.getTitle() === 'Ops!')
                this.setTitle(' ')
        }else{
            this.setType('warning')

            if (this.getMessage() === 'OK')
                this.setMessage('NOK')
                
            if (this.getTitle() === ' ')
                this.setTitle('Ops!')
        } 

        this.status = iStatus
        return this
    }

    getStatus() 
    {
        return this.status
    }

    setTitle(sTitle) 
    {
        this.title = sTitle
        return this
    }

    getTitle() 
    {
        return this.title
    }

    setMessage(sMessage) 
    {
        this.message = this.translate(sMessage)
        return this
    }

    getMessage() 
    {
        return this.message
    }

    setDataExtra(aDataExtra) 
    {
        this.dataExtra = aDataExtra
        return this
    }

    getDataExtra() 
    {
        return this.dataExtra
    }

    /**
     * setJsonResponse method
     *
     * @param that == this ~> Controller (instance)
     * @param aResponse == array a retornar
     */
    setJsonResponse(that, aResponse = null)
    {
        if (!aResponse){
            aResponse = this
        }

        that.loadComponent('RequestHandler')
        that.RequestHandler.renderAs(that, 'json')
        that.response.type('application/json')
        that.set({
            'aResponse': aResponse, 
            '_serialize': 'aResponse'
        }) 
    }
}

window.ResponseUtil = ResponseUtil