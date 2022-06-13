<?php
namespace App\Model\Entity;

use App\Util\DateUtil;
use Cake\ORM\Entity;

/**
 * Apreensao Entity
 *
 * @property int $id
 * @property int $documento_mercadoria_id
 * @property int $empresa_id
 * @property int $fiscal_id
 * @property int $tipo_doc_apeend_id
 * @property string $numero_doc_apreend
 * @property \Cake\I18n\Date $data_apreensao
 * @property \Cake\I18n\Date $data_liberacao
 * @property string|resource $observacao
 *
 * @property \App\Model\Entity\DocumentosMercadoria $documentos_mercadoria
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\Aftm $aftm
 * @property \App\Model\Entity\TipoDocumento $tipo_documento
 */
class Apreensao extends Entity
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
        '*' => true,
        'id' => false,
    ];

    public function setDateLiberacao($date){
        $this->data_liberacao = $date;
    }
}
