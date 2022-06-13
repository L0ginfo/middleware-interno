<?php
namespace App\Model\Entity;

use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

class EntradaSaidaContainer extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getFilters()
    {
        return [
            [
                'name'  => 'container',
                'divClass' => 'col-lg-4',
                'label' => 'Container',
                'table' => [
                    'className' => 'EntradaSaidaContainers.Containers',
                    'field'     => 'numero',
                    'operacao'  => 'contem'
                ]
            ]
        ];
    }

    public static function saveEntradaSaidaContainerFromResvsContainers($oResvsContainers, $aDataOriginal)
    {
        if (!$oResvsContainers->container_id)
            return;

        $aReturn = self::getConditions($oResvsContainers, $aDataOriginal);

        $oEntradaSaidaContainer = LgDbUtil::getFirst('EntradaSaidaContainers', $aReturn['aConditions']);

        if ($oEntradaSaidaContainer) {
            $oEntradaSaidaContainer = LgDbUtil::get('EntradaSaidaContainers')->patchEntity($oEntradaSaidaContainer, $aReturn['aDataInsert']);
            LgDbUtil::save('EntradaSaidaContainers', $oEntradaSaidaContainer);
        } else {
            $oEntradaSaidaContainer = LgDbUtil::saveNew('EntradaSaidaContainers', $aReturn['aDataInsert']);
        }

        if ($oEntradaSaidaContainer && $oEntradaSaidaContainer->id){
            self::vinculaEntradaSaidaContainerNosDocumentos($oEntradaSaidaContainer, $aReturn);
        }

    }

    private static function vinculaEntradaSaidaContainerNosDocumentos($oEntradaSaidaContainer, $aData)
    {
        try {
            //se for de liberacao documental
            if (@$aData['aDataInsert']['resv_saida_id'] && $oEntradaSaidaContainer->tipo_saida == 'CHEIO') {
                $aResvsLiberacoesDocumentais = LgDbUtil::getAll('ResvsLiberacoesDocumentais', [
                    'resv_id' => $oEntradaSaidaContainer->resv_saida_id
                ]);

                /*LgDbUtil::get('ResvsLiberacoesDocumentais')->updateAll([
                    'entrada_saida_container_id' => $oEntradaSaidaContainer->id
                ],[
                    'resv_id' => $oEntradaSaidaContainer->resv_saida_id
                ]);*/

                foreach ($aResvsLiberacoesDocumentais as $oResvLiberacaoDocumental) {
                    LgDbUtil::get('LiberacoesDocumentaisItens')->updateAll([
                        'entrada_saida_container_id' => $oEntradaSaidaContainer->id
                    ],[
                        'liberacao_documental_id' => $oResvLiberacaoDocumental->liberacao_documental_id,
                        'container_id' => $oEntradaSaidaContainer->container_id
                    ]);
                }
            }elseif ($oEntradaSaidaContainer->tipo == 'CHEIO') {
            //se for de documento de transporte
    
                $aResvsDocumentosTransportes = LgDbUtil::getAll('ResvsDocumentosTransportes', [
                    'resv_id' => $oEntradaSaidaContainer->resv_entrada_id
                ]);

                /*LgDbUtil::get('ResvsDocumentosTransportes')->updateAll([
                    'entrada_saida_container_id' => $oEntradaSaidaContainer->id
                ],[
                    'resv_id' => $oEntradaSaidaContainer->resv_entrada_id
                ]);*/
    
                foreach ($aResvsDocumentosTransportes as $oResvDocumentoTransporte) {
                    LgDbUtil::get('ContainerEntradas')->updateAll([
                        'entrada_saida_container_id' => $oEntradaSaidaContainer->id
                    ],[
                        'documento_transporte_id' => $oResvDocumentoTransporte->documento_transporte_id,
                        'container_id' => $oEntradaSaidaContainer->container_id
                    ]);

                    LgDbUtil::get('ItemContainers')->updateAll([
                        'entrada_saida_container_id' => $oEntradaSaidaContainer->id
                    ],[
                        'documento_transporte_id' => $oResvDocumentoTransporte->documento_transporte_id,
                        'container_id' => $oEntradaSaidaContainer->container_id
                    ]);

                    LgDbUtil::get('Lacres')->updateAll([
                        'entrada_saida_container_id' => $oEntradaSaidaContainer->id
                    ],[
                        'documento_transporte_id' => $oResvDocumentoTransporte->documento_transporte_id,
                        'container_id' => $oEntradaSaidaContainer->container_id
                    ]);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    private static function desvinculaEntradaSaidaContainerNosDocumentos($oEntradaSaidaContainer, $oResvsContainers)
    {
        try {
            $aResvsLiberacoesDocumentais = LgDbUtil::getAll('ResvsLiberacoesDocumentais', [
                //'resv_id' => $oResvsContainers->resv_id,
                'entrada_saida_container_id' => $oEntradaSaidaContainer->id
            ]);
    
            foreach ($aResvsLiberacoesDocumentais as $oResvLiberacaoDocumental) {
                $oResvLiberacaoDocumental->entrada_saida_container_id = null;
                LgDbUtil::save('ResvsLiberacoesDocumentais', $oResvLiberacaoDocumental);
            }
    
            $aResvsDocumentosTransportes = LgDbUtil::getAll('ResvsDocumentosTransportes', [
                //'resv_id' => $oResvsContainers->resv_id,
                'entrada_saida_container_id' => $oEntradaSaidaContainer->id
            ]);
    
            foreach ($aResvsDocumentosTransportes as $oResvDocumentoTransporte) {
                $oResvDocumentoTransporte->entrada_saida_container_id = null;
                LgDbUtil::save('ResvsDocumentosTransportes', $oResvDocumentoTransporte);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public static function deleteEntradaSaidaContainerFromResvsContainers($oResvsContainers, $bIsEstornoCarga = false)
    {
        $aReturn = self::getConditions($oResvsContainers, false, $bIsEstornoCarga);

        if ($bIsEstornoCarga)
            $aWhere = [
                'resv_entrada_id IS NOT' => @$aReturn['aConditions']['resv_entrada_id IS NOT'],
                'resv_saida_id IS' => @$aReturn['aConditions']['resv_saida_id IS'],
                'container_id' => @$aReturn['aConditions']['container_id'],
            ];
        else
            $aWhere = [
                'resv_entrada_id' => @$aReturn['aConditions']['resv_entrada_id'],
                'resv_saida_id IS' => @$aReturn['aConditions']['resv_saida_id IS'],
                'container_id' => @$aReturn['aConditions']['container_id'],
            ];

        $oEntityEntradaSaidaContainer = LgDbUtil::get('EntradaSaidaContainers');
        $oEntradaSaidaContainer       = LgDbUtil::getFirst('EntradaSaidaContainers', $aWhere);

        #self::desvinculaEntradaSaidaContainerNosDocumentos($oEntradaSaidaContainer, $oResvsContainers);

        if ($oEntradaSaidaContainer) {
            if ($oEntradaSaidaContainer->resv_saida_id) {
                $oEntradaSaidaContainer->resv_saida_id = null;
                $oEntityEntradaSaidaContainer->save($oEntradaSaidaContainer);
            } else {
                
                LgDbUtil::get('EntradaSaidaContainerVistorias')->deleteAll([
                    'entrada_saida_container_id' => $oEntradaSaidaContainer->id
                ]);

                $oEntityEntradaSaidaContainer->delete($oEntradaSaidaContainer);
            }
        }
    }

    private static function getConditions($oResvsContainers, $aDataOriginal = false, $bIsEstornoCarga = false)
    {
        $oOperacao = LgDbUtil::getFirst('Operacoes', ['id' => $oResvsContainers->operacao_id]);

        $aConditions = [];
        $aDataInsert = [];
        if ($oOperacao->descricao == 'Descarga') {

            $iDriveEspacoID = @$aDataOriginal['drive_espaco_id'] ?: $oResvsContainers->drive_espaco_id;

            $aConditions = [
                'resv_entrada_id'  => @$aDataOriginal['resv_id'] ?: $oResvsContainers->resv_id,
                'resv_saida_id IS' => null,
                'container_id'     => @$aDataOriginal['container_id'] ?: $oResvsContainers->container_id,
                'tipo'             => @$aDataOriginal['tipo'] ?: $oResvsContainers->tipo,
                'drive_espaco_id IS' => $iDriveEspacoID
            ];
            
            $aDataInsert = [
                'resv_entrada_id'        => $oResvsContainers->resv_id,
                'resv_saida_id'          => null,
                'container_id'           => $oResvsContainers->container_id,
                'tipo'                   => $oResvsContainers->tipo,
                'tipo_atual'             => $oResvsContainers->tipo,
                'drive_espaco_id'        => $oResvsContainers->drive_espaco_id,
                'container_forma_uso_id' => $oResvsContainers->container_forma_uso_id,
                'super_testado'          => $oResvsContainers->super_testado,
                'container_destino_id'   => $oResvsContainers->container_destino_id,
                'cliente_id'             => $oResvsContainers->cliente_id,
                'beneficiario_id'        => $oResvsContainers->beneficiario_id,
            ];

            $aDataInsert['situacao_container_id'] = VistoriaItem::getDataContainerContainerSituacao([
                'resv_id'      => $oResvsContainers->resv_id,
                'container_id' => $oResvsContainers->container_id
            ]);
            
        } else if ($oOperacao->descricao == 'Carga') {

            $aConditions = [
                'resv_entrada_id IS NOT' => null,
                'container_id'           => @$aDataOriginal['container_id'] ?: $oResvsContainers->container_id,
                // 'tipo'                   => @$aDataOriginal['tipo'] ?: $oResvsContainers->tipo,
                // 'drive_espaco_id'        => @$aDataOriginal['drive_espaco_id'] ?: $oResvsContainers->drive_espaco_id
            ];

            // if (@$aDataOriginal['drive_espaco_id']) 
            //     $aConditions['drive_espaco_id'] = @$aDataOriginal['drive_espaco_id'];
            // else if ($oResvsContainers->drive_espaco_id)
            //     $aConditions['drive_espaco_id'] = $oResvsContainers->drive_espaco_id;

            // if ($oResvsContainers->isNew() || (array_key_exists('container_id', @$aDataOriginal) && $aDataOriginal['container_id'] == null)) {
            // if ($oResvsContainers->isNew() || (@$aDataOriginal && @$aDataOriginal['container_id'] == null)) {
                // $aConditions['resv_saida_id IS'] = null;
            // } else {
            //     $aConditions['resv_saida_id'] = $oResvsContainers->resv_id;
            // }

            if ($bIsEstornoCarga)
                $aConditions['resv_saida_id IS'] = $oResvsContainers->resv_id;
            else
                $aConditions['resv_saida_id IS'] = null;

            $aDataInsert = [
                'resv_saida_id'          => $oResvsContainers->resv_id,
                'container_id'           => $oResvsContainers->container_id,
                'tipo_saida'             => $oResvsContainers->tipo,
                'tipo_atual'             => $oResvsContainers->tipo,
                // 'drive_espaco_id'        => $oResvsContainers->drive_espaco_id,
                'container_forma_uso_id' => $oResvsContainers->container_forma_uso_id,
                'super_testado'          => $oResvsContainers->super_testado,
                'container_destino_id'   => $oResvsContainers->container_destino_id
            ];

            if ($oResvsContainers->drive_espaco_id)
                $aDataInsert['drive_espaco_saida_id'] = $oResvsContainers->drive_espaco_id;
        }

        return ['aConditions' => $aConditions, 'aDataInsert' => $aDataInsert];
    }

    public static function updateContainerFormaUso($iContainerID, $iContainerFormaUsoID)
    {
        $oResponse = new ResponseUtil();

        $aConditions = self::getConditionsByContainerId($iContainerID);

        $oEntradaSaidaContainer = LgDbUtil::getFirst('EntradaSaidaContainers', $aConditions, ['id' => 'DESC']);
        if ($oEntradaSaidaContainer) {

            $oEntradaSaidaContainerEntity = LgDbUtil::get('EntradaSaidaContainers');
            $oEntradaSaidaContainer->container_forma_uso_id = $iContainerFormaUsoID;
            if (!$oEntradaSaidaContainerEntity->save($oEntradaSaidaContainer))
                return $oResponse
                    ->setStatus(400);
                    
            return $oResponse
                ->setStatus(200);

        }

        return $oResponse
            ->setStatus(200);
    }

    public static function getConditionsByContainerId($iContainerID, $bResvSaida = false)
    {
        if ($bResvSaida) {
            $aConditions = [
                'container_id'           => $iContainerID,
                'resv_saida_id IS NOT'   => null,
                'resv_entrada_id IS NOT' => null
            ];
        } else {
            $aConditions = [
                'container_id'           => $iContainerID,
                'resv_saida_id IS'       => null,
                'resv_entrada_id IS NOT' => null
            ];
        }
        

        return $aConditions;
    }

    public static function updateSituacaoContainer($iContainerID, $iSituacaoContainerID)
    {
        $oResponse = new ResponseUtil();

        $aConditions = self::getConditionsByContainerId($iContainerID);

        $oEntradaSaidaContainer = LgDbUtil::getFirst('EntradaSaidaContainers', $aConditions, ['id' => 'DESC']);
        if ($oEntradaSaidaContainer) {

            $oEntradaSaidaContainerEntity = LgDbUtil::get('EntradaSaidaContainers');
            $oEntradaSaidaContainer->situacao_container_id = $iSituacaoContainerID;
            if (!$oEntradaSaidaContainerEntity->save($oEntradaSaidaContainer))
                return $oResponse
                    ->setStatus(400);
                    
            return $oResponse
                ->setStatus(200);

        }

        return $oResponse
            ->setStatus(200);

    }

    public static function verirySituacaoContainer($iContainerID)
    {
        $oResponse = new ResponseUtil();

        $aConditions = self::getConditionsByContainerId($iContainerID);

        $oEntradaSaidaContainer = LgDbUtil::getFirst('EntradaSaidaContainers', $aConditions, ['id' => 'DESC']);

        if (!$oEntradaSaidaContainer || !$oEntradaSaidaContainer->situacao_container_id)
            return $oResponse
                ->setStatus(200);

        $iNecessidadeReparo = EntityUtil::getIdByParams('SituacaoContainers', 'descricao', 'Necessidade de Reparo');
        if ($oEntradaSaidaContainer->situacao_container_id == $iNecessidadeReparo)
            return $oResponse
            ->setStatus(403)
            ->setTitle('Ops!')
            ->setMessage('O container está com situação de (Necessidade de Reparo), portanto não pode ser carregado.');

    }

    public static function getLastByContainerId($iContainerID, $bContainDriveEspacoAtual = false, $bResvSaida = false, $bResvEntradaSaida = false)
    {
        $aConditions = self::getConditionsByContainerId($iContainerID, $bResvSaida);

        if ($bContainDriveEspacoAtual)
            $oEntradaSaidaContainer = LgDbUtil::getFind('EntradaSaidaContainers')
                ->where($aConditions)
                ->contain([
                    'DriveEspacosAtual' => [
                        'ContainerFormaUsos',
                        'TipoIsos', 
                        'Empresas'
                    ]
                ])
            ->first();
        else
            $oEntradaSaidaContainer = LgDbUtil::getFirst('EntradaSaidaContainers', $aConditions, ['EntradaSaidaContainers.id' => 'DESC']);

        if (!$oEntradaSaidaContainer) {
            if ($bResvEntradaSaida) {

                $aConditions = self::getConditionsByContainerId($iContainerID, true);
                $oEntradaSaidaContainer = LgDbUtil::getFirst('EntradaSaidaContainers', $aConditions, ['EntradaSaidaContainers.id' => 'DESC']);
                if (!$oEntradaSaidaContainer) 
                    return null;

            } else {

                return null;

            }
        }

        return $oEntradaSaidaContainer;
    }

    public static function setContainerDestino($iEntradaSaidaContainerID, $iContainerDestinoID)
    {
        $oResponse = new ResponseUtil();

        $oEntradaSaidaContainer = LgDbUtil::getFirst('EntradaSaidaContainers', ['id' => $iEntradaSaidaContainerID]);
        $oEntradaSaidaContainer->container_destino_id = $iContainerDestinoID;

        if (!LgDbUtil::save('EntradaSaidaContainers', $oEntradaSaidaContainer))
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu algum erro ao atualziar o destino do container!');

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Destino do container atualizado com sucesso!');
    }

    public static function setDestinoByContainerId($iContainerID, $iDestinoID)
    {
        $oResponse = new ResponseUtil();

        $oEntradaSaidaContainer = self::getLastByContainerId($iContainerID);
        $oEntradaSaidaContainer->container_destino_id = $iDestinoID;

        if (!LgDbUtil::save('EntradaSaidaContainers', $oEntradaSaidaContainer))
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu algum erro ao atualizar o destino do container!');

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Destino do container atualizado com sucesso!');
    }

    public static function setDriveEspacoAtual($iContainerID, $iDriveEspacoID)
    {
        $oResponse = new ResponseUtil();

        $oEntradaSaidaContainer = self::getLastByContainerId($iContainerID);
        $oEntradaSaidaContainer->drive_espaco_atual_id = $iDriveEspacoID;

        if (!LgDbUtil::save('EntradaSaidaContainers', $oEntradaSaidaContainer))
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu algum erro ao atualizar o Drive de Espaço Atual!');

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Drive de Espaço Atual do container atualizado com sucesso!');
    }

    public static function getDriveEspacoAtualByContainerId($iContainerID)
    {
        $oEntradaSaidaContainer = self::getLastByContainerId($iContainerID, true);

        if (!@$oEntradaSaidaContainer->drive_espaco_atual)
           return null;
            
        return @$oEntradaSaidaContainer->drive_espaco_atual;
    }

    public static function checkExistsContainers($oProgramacao)
    {
        $sContainerNumero = '';

        if (!$oProgramacao->programacao_containers)
            return false;

        if ($oProgramacao->operacao_id == EntityUtil::getIdByParams('Operacoes', 'descricao', 'Descarga')) {
            foreach ($oProgramacao->programacao_containers as $oProgramacaoContainer) {

                if (!$oProgramacaoContainer->container_id)
                    continue;

                $sContainerNumero = '';
                
                /*
                $oEntradaSaidaContainer = LgDbUtil::getFind('EntradaSaidaContainers')
                    ->contain(['Containers'])
                    ->where([
                        'container_id' => $oProgramacaoContainer->container_id,
                        'resv_saida_id IS' => null
                    ])
                    ->first();

                if ($oEntradaSaidaContainer) {
                    $sContainerNumero = $oEntradaSaidaContainer->container->numero;
                }*/
                
                $oEstoqueEndereco = self::verifyIfContainerInEstoque($oProgramacaoContainer->container_id, $oProgramacao->operacao_id);

                $sContainerNumero =  $oEstoqueEndereco 
                    ? $oEstoqueEndereco->container->numero
                    : '';
                
                if ($sContainerNumero)
                    return $sContainerNumero;
            }
        }

        return false;
    }

    public static function verifyIfContainerInEstoque($iContainerId, $iOperacaoId)
    {
        if (EntityUtil::getIdByParams('Operacoes', 'descricao', 'Descarga') != $iOperacaoId)
            return null;

        if (!$iContainerId)
            return null;

        $oEstoqueEndereco = LgDbUtil::getFind('EstoqueEnderecos')
            ->contain('Containers')
            ->where([
                'container_id' => $iContainerId,
            ])
            ->first();

        return $oEstoqueEndereco;
    }

}
