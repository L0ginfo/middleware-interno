<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * Operacao Entity
 *
 * @property int $id
 * @property string|null $descricao
 *
 * @property \App\Model\Entity\Resv[] $resvs
 */
class Operacao extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     * 
     * Default fields
     * 
     *  'descricao' => true,
     *  'resvs' => true
     * 
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function checkGeraDocAutomaticoByProgramacaoId($iProgramacaoID)
    {
        $oProgramacao = LgDbUtil::getFind('Programacoes')
            ->contain('Operacoes')
            ->where(['Programacoes.id' => $iProgramacaoID])
            ->first();

        if ($oProgramacao->operacao->gerar_documento_generico == 1)
            return true;

        return false;
    }

}
