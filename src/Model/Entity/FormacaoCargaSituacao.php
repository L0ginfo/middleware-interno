<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * FormacaoCargaSituacao Entity
 *
 * @property int $id
 * @property string $descricao
 *
 * @property \App\Model\Entity\FormacaoCarga[] $formacao_cargas
 */
class FormacaoCargaSituacao extends Entity
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
        
        'descricao' => true,
        'formacao_cargas' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function setSituacao($iFormacaoCargaID, $sSituacao)
    {
        $oSituacao = TableRegistry::get('FormacaoCargaSituacoes')->find()
            ->where(['descricao' => $sSituacao])
            ->first();
        
        if (!$oSituacao || !$iFormacaoCargaID)
            return;
        
        TableRegistry::get('FormacaoCargas')->updateAll([
            'formacao_carga_situacao_id' => $oSituacao->id
        ], [
            'id' => $iFormacaoCargaID
        ]);
    }
}
