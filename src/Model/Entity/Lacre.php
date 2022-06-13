<?php
namespace App\Model\Entity;

use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Lacre Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int|null $resv_id
 * @property int|null $ordem_servico_id
 * @property int $container_id
 * @property int|null $documento_transporte_id
 * @property int $lacre_tipo_id
 *
 * @property \App\Model\Entity\Resv $resv
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\Container $container
 * @property \App\Model\Entity\DocumentosTransporte $documentos_transporte
 * @property \App\Model\Entity\LacreTipo $lacre_tipo
 */
class Lacre extends Entity
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
        'resv_id' => true,
        'ordem_servico_id' => true,
        'container_id' => true,
        'documento_transporte_id' => true,
        'lacre_tipo_id' => true,
        'resv' => true,
        'ordem_servico' => true,
        'container' => true,
        'documentos_transporte' => true,
        'lacre_tipo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getFilters()
    {
        return [
            [
                'name'  => 'descricao',
                'divClass' => 'col-lg-3',
                'label' => 'Descrição',
                'table' => [
                    'className' => 'Lacres',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'container',
                'divClass' => 'col-lg-3',
                'label' => 'Container',
                'table' => [
                    'className' => 'Lacres.Containers',
                    'field'     => 'numero',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'documento_transporte',
                'divClass' => 'col-lg-3',
                'label' => 'Documento Transporte',
                'table' => [
                    'className' => 'Lacres.DocumentosTransportes',
                    'field'     => 'numero',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'lacre_tipo',
                'divClass' => 'col-lg-3',
                'label' => 'Lacre Tipo',
                'table' => [
                    'className' => 'Lacres.LacreTipos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ]
        ];
    }

    public static function saveLacre($that, $aContainer, $iDocumentoTransporte_id)
    {
        unset($aContainer['lacres']['$$$$$']);
        foreach ($aContainer['lacres'] as $aLacre) {
            
            $aData = [
                'id'                      => $aLacre['lacre_id'] ? $aLacre['lacre_id'] : '',
                'descricao'               => $aLacre['lacre_descricao'],
                'lacre_tipo_id'           => $aLacre['lacre_tipo_id'],
                'container_id'            => $aContainer['container_id'],
                'documento_transporte_id' => $iDocumentoTransporte_id
            ];

            $oEntityLacre = TableRegistry::getTableLocator()->get('Lacres');

            $that->loadModel('Lacres');
            $entidadeLacre = $that->setEntity('Lacres', $aData);

            $entidadeLacre = $oEntityLacre->patchEntity($entidadeLacre, $aData);
            $oEntityLacre->save($entidadeLacre);
            
        }
    }

    public static function deleteLacre ($iLacreId)
    {
        $oResponse = new ResponseUtil();
        
        $oEntityLacre = TableRegistry::getTableLocator()->get('Lacres');
        $oLacre = $oEntityLacre->find()->where(['id' => $iLacreId])->first();

        if ($oEntityLacre->delete($oLacre)) {
            return $oResponse
                ->setStatus(200)
                ->setMessage('Lacre removido com sucesso!')
                ->setTitle('Sucesso!');
        }

        return $oResponse
            ->setStatus(400)
            ->setMessage('Erro ao remover lacre!')
            ->setTitle('Ops...!');

    }
}
