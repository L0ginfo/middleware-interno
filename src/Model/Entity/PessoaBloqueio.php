<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\Database\Expression\IdentifierExpression;
use Cake\ORM\Entity;

/**
 * PessoaBloqueio Entity
 *
 * @property int $id
 * @property int $created_by
 * @property int $pessoa_bloqueada_id
 * @property \Cake\I18n\Time $data_inicio_bloqueio
 * @property \Cake\I18n\Time $data_fim_bloqueio
 * @property string|null $observacao
 * @property int $pessoa_bloqueio_motivo_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Pessoa $pessoa
 * @property \App\Model\Entity\PessoaBloqueioMotivo $pessoa_bloqueio_motivo
 */
class PessoaBloqueio extends Entity
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
        
        'created_by' => true,
        'pessoa_bloqueada_id' => true,
        'data_inicio_bloqueio' => true,
        'data_fim_bloqueio' => true,
        'observacao' => true,
        'pessoa_bloqueio_motivo_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'pessoa' => true,
        'pessoa_bloqueio_motivo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function isBloqueada($iPessoaID)
    {
        $oResponse = new ResponseUtil;
        $sDate = date('Y-m-d H:i:s');

        $oBloqueio = LgDbUtil::getFirst('PessoaBloqueios', [
            'pessoa_bloqueada_id' => $iPessoaID,
            LgDbUtil::getFind('PessoaBloqueios')->newExpr()->between(
                "'" .$sDate. "'",
                new IdentifierExpression('PessoaBloqueios.data_inicio_bloqueio'),
                new IdentifierExpression('PessoaBloqueios.data_fim_bloqueio')
            )
        ]);

        if ($oBloqueio) {
            $sDataFim = $oBloqueio->data_fim_bloqueio
                ? $oBloqueio->data_fim_bloqueio->format('d/m/Y H:i')
                : '<b>sem previsão</b>';

            return $oResponse
                ->setTitle('Pessoa Bloqueada!')
                ->setMessage('A pessoa selecionada está bloqueada até: <br>' 
                    . $sDataFim . '<br><br>'
                    . 'Observação do Bloqueio: ' . $oBloqueio->observacao
                )
                ->setDataExtra([
                    'bloqueio' => $oBloqueio,
                ]);
        }

        return $oResponse->setStatus(200);
    }

    public static function getFilters()
    {
        return [
            [
                'name'  => 'p',
                'divClass' => 'col-lg-2',
                'label' => 'Nome Pessoa',
                'table' => [
                    'className' => 'PessoaBloqueios.Pessoas',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ]
        ];
    }
}
