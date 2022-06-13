<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\SessionUtil;
use Cake\ORM\Entity;

/**
 * MapaTransacaoHistorico Entity
 *
 * @property int $id
 * @property int $mapa_transacao_tipo_id
 * @property int $mapa_id
 *
 * @property \App\Model\Entity\MapaTransacaoTipo $mapa_transacao_tipo
 * @property \App\Model\Entity\Mapa $mapa
 */
class MapaTransacaoHistorico extends Entity
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
        
        'mapa_transacao_tipo_id' => true,
        'mapa_id' => true,
        'mapa_transacao_tipo' => true,
        'mapa' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function consistencyStatusMapa($aDirty, $iMapaId)
    {
        $aStatus = self::getArrayMessage($aDirty);

        self::saveHistoricoTipo($aStatus, $iMapaId);
        
    }

    private static function getArrayMessage($aDirty)
    {
        $aMensagens = LgDbUtil::getFind('MapaTransacaoTipos')->toArray();
        
        $aCampos = [];
        foreach ($aMensagens as $oMensagem) {
            $aCampo = json_decode($oMensagem->coluna_referencia, true);

            if (!$aCampo)
                continue;

            $aColumns = [];
            foreach ($aCampo as $key => $aColumn) {

                foreach ($aColumn as $key => $column) {
                    $aColumn[$key]['mensagem'] = $oMensagem->mensagem;
                }

                $aColumns = $aColumns + $aColumn;
            }

            $aCampos[$oMensagem->id] = $aColumns;
        }

        $aMessageToSave = [];
        foreach ($aDirty as $sCampo => $dirty) {
            
            foreach ($aCampos as $key => $campo) {
                
                $aValidacao = [];

                if (in_array($sCampo, array_keys($campo)))
                    $aValidacao = $campo[$sCampo];
                
                if (empty($aValidacao))
                    continue;

                if ($aValidacao['tipo'] == 'contem') {
                    $aMessageToSave[$key] = $key;
                    continue;
                }

                if ($aValidacao['tipo'] == 'valor' && in_array($dirty, $aValidacao['valor'])) {
                    $aMessageToSave[$key] = $key;
                    continue;
                }

            }
        }

        return $aMessageToSave;
    }

    public static function saveHistoricoTipo($aMapaTransacaoTipos, $iMapaId)
    {
        $aMapaTransacaoTiposEntities = [];
        foreach ($aMapaTransacaoTipos as $key => $iMapaTransacaoTipoId) {
            $aMapaTransacaoTiposEntities[] = LgDbUtil::get('MapaTransacaoHistoricos')->newEntity([
                'mapa_transacao_tipo_id' => $iMapaTransacaoTipoId,
                'mapa_id' => $iMapaId,
                'created_by' => SessionUtil::getUsuarioConectado()
            ]);
        }

        LgDbUtil::get('MapaTransacaoHistoricos')->saveMany($aMapaTransacaoTiposEntities);
    }
}
