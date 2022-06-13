<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * ResvDriveEspaco Entity
 *
 * @property int $id
 * @property int $drive_espaco_id
 * @property int $resv_id
 *
 * @property \App\Model\Entity\DriveEspaco $drive_espaco
 * @property \App\Model\Entity\Resv $resv
 */
class ResvDriveEspaco extends Entity
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
        
        'drive_espaco_id' => true,
        'resv_id' => true,
        'drive_espaco' => true,
        'resv' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function updateDocumentoEntrada($iResvId, $iOsId){
        $oResv = LgDbUtil::getFirst('Resvs', ['id' => $iResvId]);
        $oOs = LgDbUtil::getFirst('OrdemServicos', ['id' => $iOsId]);
        $sNavioAeronave = '';
        $sViagemVoo = '';

        if(empty($oResv)) return (new ResponseUtil())
            ->setMessage("RESV não encontrada com id $iResvId");

        if(empty($oOs)) return (new ResponseUtil())
            ->setMessage("Ordem Servico não encontrada com id $iOsId");

        $aResvDrive = LgDbUtil::getFind('ResvDriveEspacos')
            ->contain(['DriveEspacos'])
            ->where(['ResvDriveEspacos.resv_id' => $iResvId])
            ->toArray();

        if($aResvDrive){
            foreach ($aResvDrive as $oResvDriveEspaco) {
                if(empty($sNavioAeronave) && $oResvDriveEspaco->drive_espaco){
                    $sNavioAeronave = $oResvDriveEspaco->drive_espaco->navio_aeronave;
                }
    
                if(empty($sViagemVoo) && $oResvDriveEspaco->drive_espaco){
                    $sViagemVoo = $oResvDriveEspaco->drive_espaco->viagem_voo;
                }
            }
        }

        $aEntradaSaidaContainers = LgDbUtil::getFind('EntradaSaidaContainers')
            ->contain(['DriveEspacosAtual'])
            ->where(['EntradaSaidaContainers.resv_saida_id' => $iResvId])
            ->toArray();

        if($aEntradaSaidaContainers){
            foreach ($aEntradaSaidaContainers as $oEntradaSaida) 
            {
                $oDrive = $oEntradaSaida->drive_espaco_atual;
                
                if(empty($sNavioAeronave) && $oDrive){
                    $sNavioAeronave = $oDrive->navio_aeronave;
                }
    
                if(empty($sViagemVoo) && $oDrive){
                    $sViagemVoo = $oDrive->viagem_voo;
                }
            }
        }

        if(empty($aResvDrive) && empty($aEntradaSaidaContainers)){
            return (new ResponseUtil())
                ->setMessage("Resv sem drive espacoes com is $iResvId."); 
        }

        if(empty($sNavioAeronave) && empty($sViagemVoo)){
            return (new ResponseUtil())
                ->setMessage("drives espaços sem navio e viagem."); 
        }

        $aOsCarregada = LgDbUtil::getFind('OrdemServicoCarregamentos')
            ->contain(['OrdemServicos'])
            ->where([
                'OrdemServicos.resv_id' => $iResvId,
                'OrdemServicos.id' => $iOsId
            ])
            ->group(['OrdemServicoCarregamentos.lote_codigo'])
            ->toArray();

        if(empty($aOsCarregada)){
            return (new ResponseUtil())
                ->setMessage("ordem servico sem carregamentos com id $iOsId"); 
        }

        foreach ($aOsCarregada as $key => $oOsCarreda) {
            if($oOsCarreda->lote_codigo){
                $oMercadoria = LgDbUtil::getFind('DocumentosMercadorias')
                    ->contain(['DocumentosTransportes'])
                    ->where([
                        'DocumentosMercadorias.lote_codigo' 
                            => $oOsCarreda->lote_codigo
                    ])
                    ->where([
                        'OR' =>[
                            'DocumentosTransportes.navio_aeronave is NULL',
                            'DocumentosTransportes.navio_aeronave' => '',
                            'DocumentosTransportes.numero_voo is NULL',
                            'DocumentosTransportes.numero_voo' => '',
                        ]
                    ])
                    ->first();

                if($oMercadoria){

                    $oTransporte = $oMercadoria->documentos_transporte;

                    if($oTransporte && empty($oTransporte->numero_voo)){
                        $oTransporte->numero_voo = $sViagemVoo;
                    }

                    if($oTransporte && empty($oTransporte->navio_aeronave)){
                        $oTransporte->navio_aeronave = $sNavioAeronave;
                    }

                    if($oTransporte) LgDbUtil::save('DocumentosTransportes', $oTransporte);

                }
            }
        }

        return (new ResponseUtil())->setStatus(200);
    }
}
