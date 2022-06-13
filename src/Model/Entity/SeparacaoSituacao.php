<?php
namespace App\Model\Entity;

use App\Util\EntityUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * SeparacaoSituacao Entity
 *
 * @property int $id
 * @property string $descricao
 *
 * @property \App\Model\Entity\SeparacaoCargaItem[] $separacao_carga_itens
 */
class SeparacaoSituacao extends Entity
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
    protected $_accessible = [
        'descricao' => true,
        'separacao_carga_itens' => true,
    ];

    public static function setSituacao($aSeparacaoIDs, $sSituacao)
    {
        $oResponse = new ResponseUtil;
        $iSituacao = self::getSituacao($sSituacao, false);
        $iCount = 0;

        if (!$iSituacao)
            return $oResponse->setMessage('A situação "'.$sSituacao.'" não pode ser encontrada!')->getArray();

        foreach ($aSeparacaoIDs as $key => $iSeparacaoID) {
            $oSeparacao = TableRegistry::get('SeparacaoCargas')->find()
                ->where(['id' => $iSeparacaoID])
                ->first();

            if (!$oSeparacao)
                return $oResponse->setMessage('A Separação "'.$iSeparacaoID.'" não foi encontrada!');

            $oSeparacao->separacao_situacao_id = $iSituacao;

            if ($oSeparacao->getErrors())
                return $oResponse->setMessage(EntityUtil::dumpErrors($oSeparacao))->getArray();

            TableRegistry::get('SeparacaoCargas')->save($oSeparacao);

            $iCount++;
        }

        return $oResponse
            ->setMessage('No total, ' . $iCount . ' Separação(ões) Recusada(s) com sucesso!')
            ->setStatus(200)
            ->setDataExtra(['refresh' => true])
            ->getArray();
    }

    public static function getSituacao($sDescricao, $uDefault = 1)
    {
        $oSituacao = TableRegistry::get('SeparacaoSituacoes')->find()
            ->where(['descricao' => $sDescricao])
            ->first();

        return $oSituacao ? $oSituacao->id : $uDefault;
    }

}
