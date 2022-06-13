<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * ChecklistResvResposta Entity
 *
 * @property int $id
 * @property string $resposta
 * @property int $checklist_resv_id
 * @property int $checklist_pergunta_resposta_id
 * @property int $checklist_resv_pergunta_id
 *
 * @property \App\Model\Entity\ChecklistResv $checklist_resv
 * @property \App\Model\Entity\ChecklistPerguntaResposta $checklist_pergunta_resposta
 * @property \App\Model\Entity\ChecklistResvPergunta $checklist_resv_pergunta
 */
class ChecklistResvResposta extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
     /* Default fields
        
        'resposta' => true,
        'checklist_resv_id' => true,
        'checklist_pergunta_resposta_id' => true,
        'checklist_resv_pergunta_id' => true,
        'checklist_resv' => true,
        'checklist_pergunta_resposta' => true,
        'checklist_resv_pergunta' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function updateChecklistResvRespostas($aData)
    {
        $oResponse = new ResponseUtil();

        $oChecklistResvResposta = LgDbUtil::getByID('ChecklistResvRespostas', $aData['resposta_id']);

        if ($aData['checked'] == "true")
            $iSelecionado = 1;
        else if ($aData['checked'] == "false")
            $iSelecionado = 0;
        
        $oChecklistResvResposta->selecionado = $iSelecionado;
        if (!LgDbUtil::save('ChecklistResvRespostas', $oChecklistResvResposta, true))
            return $oResponse
                ->setStatus(400)
                ->setMessage('Ocorreu algum erro ao atualizar a resposta!');

        return $oResponse->setStatus(200);
    }

    public static function updateChecklistResvPerguntas($aData)
    {
        $oResponse = new ResponseUtil();

        $oChecklistResvPergunta = LgDbUtil::getByID('ChecklistResvPerguntas', $aData['pergunta_id']);

        $oChecklistResvPergunta->observacoes = $aData['observacao'];
        if (!LgDbUtil::save('ChecklistResvPerguntas', $oChecklistResvPergunta, true))
            return $oResponse
                ->setStatus(400)
                ->setMessage('Ocorreu algum erro ao atualizar a observação!');

        return $oResponse->setStatus(200);
    }

}
