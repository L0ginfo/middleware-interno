<?php 

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

use App\Model\Entity\ParametroGeral;
use Cake\ORM\TableRegistry;

class UniversalCodigoUtil
{
    // Retornara um codigo universal de Resvs no formato:
    // 20190000000000000001
    // {ANO}{$iPadLength}{ID_RESVS}
    public static function codigoResvs ($iResvsID, $iPadLength = 20) 
    {   
        $iAno = date('Y');
        $aux = $iAno . $iResvsID;
        $aux = str_pad($aux, $iPadLength, 'X', STR_PAD_RIGHT);
        $count_pad = substr_count($aux, 'X');
        $codigo = $iAno;

        for ($i=0; $i < $count_pad; $i++) { 
            $codigo .= '0';
        }

        $codigo .= $iResvsID;

        return $codigo;
    }
    
    public static function codigoEtiqueta ($iNum, $iPadLength = 15) 
    {   
        $iAno = date('Y');
        $aux = $iAno . $iNum;
        $aux = str_pad($aux, $iPadLength, 'X', STR_PAD_RIGHT);
        $count_pad = substr_count($aux, 'X');
        $codigo = $iAno;

        for ($i=0; $i < $count_pad; $i++) { 
            $codigo .= '0';
        }

        $codigo .= $iNum;

        return $codigo;
    }
    
    public static function codigoLoteMercadoria($that = null, $iPadLength = 15) 
    {   
        $iFirstNum = 1;
        $iAno = date('Y');
        $aux = $iAno . 1;
        $aux = str_pad($aux, $iPadLength, 'X', STR_PAD_RIGHT);
        $count_pad = substr_count($aux, 'X');
        $codigo = $iAno;

        for ($i=0; $i < $count_pad; $i++) { 
            $codigo .= '0';
        }

        $codigo .= $iFirstNum;
        
        // $sNewLoteCodigo = $that->DocumentosMercadorias->find('all', [
        //     'fields' => array('lote_codigo' => 'IFNULL( (MAX(lote_codigo) + 1), "'.$codigo.'" )'),
        // ])
        // ->first(); 

        if($that){
            $oTableDocumento = $that->DocumentosMercadorias;
        }else{
            $oTableDocumento = TableRegistry::getTableLocator()->get('DocumentosMercadorias');
        }

        $sNewLoteCodigo = $oTableDocumento->find()
            ->select([
                'lote_codigo' => env('DB_ADAPTER', 'mysql') != 'sqlsrv'
                    ? 'IFNULL( (MAX(lote_codigo) + 1), "'.$codigo.'" )'
                    : $oTableDocumento->find()->func()->max('lote_codigo')
            ])
            ->where([
                'lote_codigo LIKE' => $iAno . '%'
            ])
            ->first();

        if (@$sNewLoteCodigo->lote_codigo && env('DB_ADAPTER', 'mysql') == 'sqlsrv')
            $sNewLoteCodigo->lote_codigo++;

        if (env('DB_ADAPTER', 'mysql') == 'sqlsrv')
            return $sNewLoteCodigo->lote_codigo ?: $codigo;

        return $sNewLoteCodigo->lote_codigo;
    }


    public static function codigoDigitoLoteReceita($sLote) 
    {
        $aLoteDigitos = str_split($sLote);
        $aMascara = array();
        $iUltimaMascara = 1;

        for ($i=0; $i < count($aLoteDigitos) ; $i++) { 
            
            if ($iUltimaMascara == 1)
                $iUltimaMascara = 2;
            else
                $iUltimaMascara = 1;

            $aMascara[] = $iUltimaMascara;
        }

        $aResultadoMultiplicacao = array();

        for ($i=0; $i < count($aLoteDigitos); $i++) { 
            $aResultadoMultiplicacao[] = $aLoteDigitos[$i] * $aMascara[$i];
        }

        $aResultadoMultiplicacaoAlgarismos = str_split( implode($aResultadoMultiplicacao) );
        
        $iResultadoAlgarismo = 0;

        foreach ($aResultadoMultiplicacaoAlgarismos as $key => $aAlgarismos) {
            $iResultadoAlgarismo += $aAlgarismos;
        }
        
        $iTempMod = $iResultadoAlgarismo % 10;
        $iDigito = (int) ( 10 - $iTempMod );

        if ($iDigito >= 10)
            $iDigito = 1;

        if ($iDigito < 0)
            $iDigito = 0;

        return $iDigito;
    }
    
    public static function codigoLoteItemEtiquetaProduto ($that = null, $sLoteCodigo, $iPadLength = 15, $iConhecSequenciaItem = null) 
    {   
        $iFirstNum = $iConhecSequenciaItem ? $iConhecSequenciaItem : 1;
        $iAno = date('Y');
        $aux = $iAno . $iFirstNum;
        $aux = str_pad($aux, $iPadLength, 'X', STR_PAD_RIGHT);
        $count_pad = substr_count($aux, 'X');
        $codigo = $iAno;

        for ($i=0; $i < $count_pad; $i++) { 
            $codigo .= '0';
        }

        $codigo .= $iFirstNum;

        if ($iConhecSequenciaItem) {
            return $codigo;
        }

        $oTableEstoqueEnderecos = TableRegistry::getTableLocator()->get('EstoqueEnderecos');
        
        // $oNewLoteItem = $that->EtiquetaProdutos->find('all', [
        //     'fields' => array('lote_item' => 'IFNULL( (MAX(lote_item) + 1), "'.$codigo.'" )'),
        // ])
        // ->first();

        $oNewLoteItem = $oTableEstoqueEnderecos->find()
            ->select([
                'lote_item' => 'COALESCE( (MAX(lote_item) + 1), "'.$codigo.'" )',
            ])
            ->where([
                'lote_item LIKE' => $iAno . '%',
                'lote_codigo' => $sLoteCodigo
            ])
            ->first();
        
        return $oNewLoteItem->lote_item;
    }
    
    public static function codigoFaturamento ($iNum, $sTipoFaturamento = 'DAPE') 
    {   
        $iPadLength = 15;
    
        if ($sTipoFaturamento != 'DAPE')
            $iPadLength = 15;
    
        $iAno = date('Y');
        $iAno = substr($iAno, 2, 3);
        $aux = $iAno . $iNum;
        $aux = str_pad($aux, $iPadLength, 'X', STR_PAD_RIGHT);
        $count_pad = substr_count($aux, 'X');
        $codigo = $iAno;

        for ($i=0; $i < $count_pad; $i++) { 
            $codigo .= '0';
        }

        $codigo .= $iNum;

        return $codigo;
    }

    /**
     * Funcao generica para pegar o numero da DA
     */
    public static function getNumeroDocumentoArrecadacao($oFaturamento, $bRetornaFormatado = true)
    {
        $sNumero = '';

        $oFaturamento = is_array($oFaturamento)
            ? (object) $oFaturamento
            : $oFaturamento;  

        $oFaturamento = $oFaturamento && @$oFaturamento->that
            ? (object) $oFaturamento->that
            : $oFaturamento;        

        if ($oFaturamento->count_generic_completo) {
            $sNumero = $oFaturamento->count_generic_completo;
        }else {

            if (@$oFaturamento->tipos_faturamento->descricao)
                $sTipoDescricao = @$oFaturamento->tipos_faturamento->descricao;
            else
                $sTipoDescricao =  @LgDbUtil::getByID('TiposFaturamentos', $oFaturamento->tipo_faturamento_id)->descricao;

            $sTipoDescricao = strtolower($sTipoDescricao);
            $sCampoPrimarioViaTipo = 'count_' . $sTipoDescricao . '_primario'; 
            $sCampoSecundarioViaTipo = 'count_' . $sTipoDescricao . '_secundario'; 
            
            $sSecundario = $oFaturamento->{$sCampoSecundarioViaTipo};
            $sSecundario = str_pad($sSecundario, 3, '0', STR_PAD_RIGHT);
            $sAuxSec = '';

            foreach (str_split($sSecundario) as $iKey => $sStr) {

                if ($iKey == 2)
                    $sAuxSec .= '.';

                $sAuxSec .= $sStr;
            }

            $sSecundario = $sAuxSec;

            $sNumero = $oFaturamento->{$sCampoPrimarioViaTipo} . '.' . $sSecundario;
        }
        
        if (!$bRetornaFormatado)
            return str_replace('.', '', $sNumero);

        return $sNumero;
    }

    public static function geraCodigoSecundarioFaturamento($oFaturamentoOld, $sOldSecundario, $iPadLength = 2)
    {
        $sSecundario = @$sOldSecundario 
            ? ($sOldSecundario + 1)
            : '0';

        $sCodigo = UniversalCodigoUtil::genericCode($sSecundario, $iPadLength);

        return $sCodigo;
    }

    public static function codigoFaturamentoDigitoVerificador($oFaturamento)
    {
        $sNossoNumero = $oFaturamento->tipo_faturamento_id;
        $sNossoNumero .= $oFaturamento->count_generic_primario . $oFaturamento->count_generic_secundario . '0';
        
        $sParam_FATU_COD_BARRA_IDEN_PRODUTO = ParametroGeral::getParameterByUniqueName('FATU_COD_BARRA_IDEN_PRODUTO');
        $sParam_FATU_COD_BARRA_IDEN_SEGMENTO = ParametroGeral::getParameterByUniqueName('FATU_COD_BARRA_IDEN_SEGMENTO');
        $sParam_FATU_COD_BARRA_IDEN_VALOR_REAL_REF = ParametroGeral::getParameterByUniqueName('FATU_COD_BARRA_IDEN_VALOR_REAL_REF');
        $sParam_AGENCIA_UNIDADE_PTN = ParametroGeral::getParameterByUniqueName('AGENCIA_UNIDADE_PTN');
        $sParam_CONTA_CORRENTE_UNIDADE_PTN = ParametroGeral::getParameterByUniqueName('CONTA_CORRENTE_UNIDADE_PTN');
        $sParam_DESCRICAO_BOLETO_DAPE_UNIDADE_PTN = ParametroGeral::getParameterByUniqueName('DESCRICAO_BOLETO_DAPE_UNIDADE_PTN');
        $oEmpresaMaster = LgDbUtil::getByID('Empresas', 1);

        $aFaturamentoInfo = [
            'IDEN_PRODUTO'        => $sParam_FATU_COD_BARRA_IDEN_PRODUTO->valor ?: 8,
            'IDEN_SEGMENTO'       => $sParam_FATU_COD_BARRA_IDEN_SEGMENTO->valor ?: 6,
            'IDEN_VALOR_REAL_REF' => $sParam_FATU_COD_BARRA_IDEN_VALOR_REAL_REF->valor ?: 7,
            'AGENCIA_UNIDADE_PTN' => $sParam_AGENCIA_UNIDADE_PTN->valor ?: 0,
            'CONTA_CORRENTE_UNIDADE_PTN' => $sParam_CONTA_CORRENTE_UNIDADE_PTN->valor ?: 0,
            'DESCRICAO_BOLETO_DAPE_UNIDADE_PTN' => $sParam_DESCRICAO_BOLETO_DAPE_UNIDADE_PTN->valor ?: 0,
            'CNPJ_MASTER'         => substr($oEmpresaMaster->cnpj, 0, 8),
            'CNPJ_MASTER_COMPLETO' => $oEmpresaMaster->cnpj,
            'CODIGO_EMPRESA'      => $oEmpresaMaster->codigo,
            'NOSSO_NUMERO'        => $sNossoNumero
        ];

        $sDigitoVerificador = UniversalCodigoUtil::geraCodBarrasFaturamento($aFaturamentoInfo, true);

        return $sDigitoVerificador;
    }

    public static function codigoFaturamentoCompleto($oFaturamento)
    {
        $sCountGenericCompleto = 
                    $oFaturamento->count_generic_primario 
            . '.' . $oFaturamento->count_generic_secundario
            . '.' . $oFaturamento->count_generic_dv;
        
        return $sCountGenericCompleto;
    }

    public static function geraCodigoPrimarioFaturamento($oFaturamento, $iPadLength = 12)
    {
        //$sCodigoEmpresaAtual = LgDbUtil::getByID('Empresas', 1)->codigo;
        $sStrAno = substr(date('Y'), 1, 3);
        $iFirstNum = 1;
        $aux = '';
        $aux = str_pad($aux, $iPadLength - 1, 'X', STR_PAD_RIGHT);
        $sCodigo = $sStrAno;

        $oFaturamentoLastPorAno = LgDbUtil::getFirst('Faturamentos', [
            'count_generic_primario LIKE' => $sCodigo . '%'
        ], [
            'count_generic_primario' => 'DESC'
        ]);

        $oFaturamentoLastPorAno = isset($oFaturamentoLastPorAno) 
            ? (object) $oFaturamentoLastPorAno->that 
            : null;

        if ($oFaturamentoLastPorAno) {
            $sCodigo = $oFaturamentoLastPorAno->count_generic_primario + 1;
        }else {
            // $sNewCodigo = str_pad(strval($oFaturamento->id), $iPadLength, '0', STR_PAD_LEFT); 020000000001

            // if ($sNewCodigo) {
            //     $count_pad = substr_count($aux, 'X') - count(str_split($sStrAno)) - count(str_split($sNewCodigo)) + 1;
            //     //dump('$count_pad', $count_pad);
            //     $codigo_encontrado = substr($sNewCodigo, count(str_split($sStrAno)), count(str_split($sNewCodigo)));
            // }else {
            //     $count_pad = substr_count($aux, 'X') - count(str_split($sStrAno)) - count(str_split($iFirstNum)) + 1;
            //     $codigo_encontrado = $iFirstNum;   
            // }

            $oFaturamentoLast = LgDbUtil::getFirst('Faturamentos', [], [
                'count_generic_primario' => 'DESC'
            ]);
            
            if ($oFaturamentoLast && $oFaturamentoLast->count_generic_primario) {
                $sNewCodigo = $oFaturamentoLast->count_generic_primario;
                $count_pad = substr_count($aux, 'X') - count(str_split($sStrAno)) - count(str_split(strval($sNewCodigo))) + 1;
                $codigo_encontrado = substr($sNewCodigo, count(str_split($sStrAno)), count(str_split($sNewCodigo)));
            }else {
                $count_pad = substr_count($aux, 'X') - count(str_split($sStrAno)) - count(str_split($iFirstNum)) + 1;
                $codigo_encontrado = $iFirstNum;   
            }

            for ($i=0; $i < $count_pad; $i++) { 
                $sCodigo .= '0';
            }

            $sCodigo .= $codigo_encontrado;
            // dump('$codigo_encontrado', $codigo_encontrado);
        }

        // dump('$codigo', $sCodigo);
        // LgDbUtil::get('Faturamentos')->delete($oFaturamento);
        // dd('$codigo', $sCodigo );

        $sCodigo = str_pad($sCodigo, $iPadLength, '0', STR_PAD_LEFT);

        return $sCodigo;
    }

    public static function codigoFaturamentoDAI($that, $iPadLength = 12)
    {
        $sCodigoEmpresaAtual = $that->getCodigoEmpresaAtual();
        $iFirstNum = 1;
        $aux = '';
        $aux = str_pad($aux, $iPadLength - 1, 'X', STR_PAD_RIGHT);
        $codigo = $sCodigoEmpresaAtual;

        $sNewCodigo = $that->Faturamentos->find('all', [
            'fields' => array('count_dai_primario' => '(MAX(count_dai_primario) + 1)'),
        ])
        ->first()
        ->that['count_dai_primario'];

        if ($sNewCodigo) {
            $count_pad = substr_count($aux, 'X') - count(str_split($sCodigoEmpresaAtual)) - count(str_split($sNewCodigo)) + 1;
            $codigo_encontrado = substr($sNewCodigo, count(str_split($sCodigoEmpresaAtual)) - 1, count(str_split($sNewCodigo)));
        }else {
            $count_pad = substr_count($aux, 'X') - count(str_split($sCodigoEmpresaAtual)) - count(str_split($iFirstNum)) + 1;
            $codigo_encontrado = $iFirstNum;   
        }
        
        for ($i=0; $i < $count_pad; $i++) { 
            $codigo .= '0';
        }

        $codigo .= $codigo_encontrado;

        return $codigo;
    }

    public static function codigoFaturamentoDAE($that, $iPadLength = 12)
    {
        $sCodigoEmpresaAtual = $that->getCodigoEmpresaAtual();
        $iFirstNum = 1;
        $aux = '';
        $aux = str_pad($aux, $iPadLength - 1, 'X', STR_PAD_RIGHT);
        $codigo = $sCodigoEmpresaAtual;

        $sNewCodigo = $that->Faturamentos->find('all', [
            'fields' => array('count_dae_primario' => '(MAX(count_dae_primario) + 1)'),
        ])
        ->first()
        ->that['count_dae_primario'];

        if ($sNewCodigo) {
            $count_pad = substr_count($aux, 'X') - count(str_split($sCodigoEmpresaAtual)) - count(str_split($sNewCodigo)) + 1;
            $codigo_encontrado = substr($sNewCodigo, count(str_split($sCodigoEmpresaAtual)) - 1, count(str_split($sNewCodigo)));
        }else {
            $count_pad = substr_count($aux, 'X') - count(str_split($sCodigoEmpresaAtual)) - count(str_split($iFirstNum)) + 1;
            $codigo_encontrado = $iFirstNum;   
        }
        
        for ($i=0; $i < $count_pad; $i++) { 
            $codigo .= '0';
        }

        $codigo .= $codigo_encontrado;
        
        return $codigo;
    }

    public static function codigoFaturamentoDAPE($that, $aData)
    {
        $sCodigoEmpresaAtual = $that->getCodigoEmpresaAtual();
        $iPadLength = 12;
        $iFirstNum = 1;
        $aux = '';
        $aux = str_pad($aux, $iPadLength - 1, 'X', STR_PAD_RIGHT);
        $codigo = $sCodigoEmpresaAtual;
        
        $checkFaturamentoDAPEExists = $that->Faturamentos->find()
            ->where([
                'liberacao_documental_id' => $aData['liberacao_documental_id'],
                'cliente_id' => $aData['cliente_id'],
                'count_dape_primario IS NOT NULL',
                'empresa_id' => $that->getEmpresaAtual()
            ])
            ->order('Faturamentos.id DESC')
            ->first();

        if ($checkFaturamentoDAPEExists) {
            $sNewCodigo = $checkFaturamentoDAPEExists
                ->that['count_dape_primario'];
        }else {
            $sNewCodigo = $that->Faturamentos->find('all', [
                'fields' => array(
                    'count_dape_primario' => '(MAX(count_dape_primario) + 1)'
                ),
            ])
            ->first()
            ->that['count_dape_primario'];

            if ($sNewCodigo) {
                $sNewCodigo = $sNewCodigo;
                $sNewCodigo = substr($sNewCodigo, count(str_split($sCodigoEmpresaAtual)) - 1, count(str_split($sNewCodigo)));
            }else {
                $sNewCodigo = $iFirstNum;
            }
        }
        $count_pad = substr_count($aux, 'X') - count(str_split($sCodigoEmpresaAtual)) - count(str_split($sNewCodigo)) + 1;

        for ($i=0; $i < $count_pad; $i++) { 
            $codigo .= '0';
        }

        $codigo .= $sNewCodigo;

        return $codigo;
    }

    public static function codigoFaturamentoDAPESecundario($that, $aData)
    {
        $iPadLength = 2;
        $iFirstNum = 0;
        $aux = '';
        $aux = str_pad($aux, $iPadLength - 1, 'X', STR_PAD_RIGHT);
        $count_pad = substr_count($aux, 'X');
        $codigo = '';

        for ($i=0; $i < $count_pad; $i++) { 
            $codigo .= '0';
        }

        $codigo .= $iFirstNum;

        $checkFaturamentoDAPEExists = $that->Faturamentos->find()
            ->select([
                'count_dape_secundario' => 'COALESCE( LPAD((MAX(count_dape_secundario) + 1), '.$iPadLength.', "0"), "'.$codigo.'" )'
            ])
            ->where([
                'liberacao_documental_id' => $aData['liberacao_documental_id'],
                'cliente_id' => $aData['cliente_id'],
                'count_dape_primario IS NOT NULL'
            ])
            ->order('Faturamentos.id DESC')
            ->first();

        if ($checkFaturamentoDAPEExists) {
            $oNewCodigo = $checkFaturamentoDAPEExists;
        }else {
            $oNewCodigo = $that->Faturamentos->find('all', [
                'fields' => array(
                    'count_dape_secundario' => 'COALESCE( LPAD((MAX(count_dape_secundario) + 1), '.$iPadLength.', "0"), "'.$codigo.'" )'
                ),
            ])
            ->first();
        }        

        return $oNewCodigo->that['count_dape_secundario'];
    }

    public static function codigoFaturamentoDAPESemCarga($that, $aData)
    {
        $sCodigoEmpresaAtual = $that->getCodigoEmpresaAtual();
        $iPadLength = 12;
        $iFirstNum = 1;
        $aux = '';
        $aux = str_pad($aux, $iPadLength - 1, 'X', STR_PAD_RIGHT);
        $codigo = $sCodigoEmpresaAtual;
        
        $sNewCodigo = $that->Faturamentos->find('all', [
            'fields' => array(
                'count_dapesc_primario' => '(MAX(count_dapesc_primario) + 1)'
            ),
        ])
        ->first()
        ->that['count_dapesc_primario'];
        

        if ($sNewCodigo) {
            $sNewCodigo = $sNewCodigo;
            $sNewCodigo = substr($sNewCodigo, count(str_split($sCodigoEmpresaAtual)) - 1, count(str_split($sNewCodigo)));
        }else {
            $sNewCodigo = $iFirstNum;
        }

        $count_pad = substr_count($aux, 'X') - count(str_split($sCodigoEmpresaAtual)) - count(str_split($sNewCodigo)) + 1;

        for ($i=0; $i < $count_pad; $i++) { 
            $codigo .= '0';
        }

        $codigo .= $sNewCodigo;

        return $codigo;
    }

    public static function codigoFaturamentoDAPESemCargaSecundario($that, $aData)
    {
        $iPadLength = 2;
        $iFirstNum = 0;
        $aux = '';
        $aux = str_pad($aux, $iPadLength - 1, 'X', STR_PAD_RIGHT);
        $count_pad = substr_count($aux, 'X');
        $codigo = '';

        for ($i=0; $i < $count_pad; $i++) { 
            $codigo .= '0';
        }

        $codigo .= $iFirstNum;

        $checkFaturamentoDAPEExists = $that->Faturamentos->find()
            ->select([
                'count_dapesc_secundario' => 'COALESCE( LPAD((MAX(count_dapesc_secundario) + 1), '.$iPadLength.', "0"), "'.$codigo.'" )'
            ])
            ->where([
                'tipo_faturamento_id' => $aData['tipo_faturamento_id'],
                'cliente_id' => $aData['cliente_id'],
                'count_dapesc_primario' => $aData['count_dapesc_primario']
            ])
            ->order('Faturamentos.id DESC')
            ->first();

        if ($checkFaturamentoDAPEExists) {
            $oNewCodigo = $checkFaturamentoDAPEExists->that['count_dapesc_secundario'];
        }else {
            $oNewCodigo = $codigo;
        }   

        return $oNewCodigo;
    }

    public static function geraCodBarrasFaturamento( $aInfos, $bOnlyReturnDigito = false )
    {
        $sCodigoBarrasSimples = null;
        $sCodigoBarrasSimples = $aInfos['IDEN_PRODUTO'] . $aInfos['IDEN_SEGMENTO'] . $aInfos['IDEN_VALOR_REAL_REF'] . 'Y';
        $sCodigoBarrasSimples = str_pad($sCodigoBarrasSimples, 15, 'X', STR_PAD_RIGHT);
        $sCodigoBarrasSimples .= $aInfos['CNPJ_MASTER'];       
        $sCodigoBarrasSimples .= str_pad($aInfos['NOSSO_NUMERO'], 21, 'X', STR_PAD_LEFT) ;
        $iUltimaMascara = 1;
        $aCodigoBarrasSimples = str_split( str_replace(['X', 'Y'], ['0', ''], $sCodigoBarrasSimples) );
        $iDigitoVerificador = 0;
        
        if (@$_GET['debug_boleto'] == 'true')
            dump(implode($aCodigoBarrasSimples));

        $aMascara = array();

        for ($i=0; $i < count($aCodigoBarrasSimples) ; $i++) { 
            
            if ($iUltimaMascara == 1)
                $iUltimaMascara = 2;
            else
                $iUltimaMascara = 1;

            $aMascara[] = $iUltimaMascara;
        }

        $aResultadoMultiplicacao = array();

        for ($i=0; $i < count($aCodigoBarrasSimples); $i++) { 
            if ($aCodigoBarrasSimples[$i] != 'Y')
                $aResultadoMultiplicacao[] = $aCodigoBarrasSimples[$i] * $aMascara[$i];
        }

        $aResultadoMultiplicacaoAlgarismos = str_split( implode($aResultadoMultiplicacao) );
        
        $iResultadoAlgarismo = 0;

        foreach ($aResultadoMultiplicacaoAlgarismos as $key => $aAlgarismos) {
            $iResultadoAlgarismo += $aAlgarismos;
        }
        
        $iTempMod = $iResultadoAlgarismo % 10;
        $iQuartoDigito = (int) ( 10 - $iTempMod );
        $iQuartoDigito = $iQuartoDigito == 10 ? 0 : $iQuartoDigito;
        
        if (@$_GET['debug_boleto'] == 'true')
            dump('quarto digito: ' . $iQuartoDigito);

        $sCodigoBarrasSimples = str_replace('Y', $iQuartoDigito, $sCodigoBarrasSimples);
        $sCodigoBarrasSimples = str_replace('X', '0', $sCodigoBarrasSimples);
        
        if (@$_GET['debug_boleto'] == 'true')
            dump($sCodigoBarrasSimples);

        $aCodigoDeBarras = str_split($sCodigoBarrasSimples);
        
        $iStart = 0;
        $sCodigoDeBarrasFinal = '';

        for ($o = 0; $o < 4; $o++) {
            
            $sAuxCodigoBarrasFinal = '';
            
            for ($k=0; $k < 11; $k++) {               
                $sAuxCodigoBarrasFinal .= $aCodigoDeBarras[$iStart];
                
                $iStart++;
            }
            
            $aMascara = array();
            $iUltimaMascara = 1;

            for ($i=0; $i < strlen($sAuxCodigoBarrasFinal); $i++) { 

                if ($iUltimaMascara == 1)
                    $iUltimaMascara = 2;
                else
                    $iUltimaMascara = 1;

                $aMascara[] = $iUltimaMascara;
            }

            if (@$_GET['debug_boleto'] == 'true')
                dump('mascara: ' . implode($aMascara));

            $aResultadoMultiplicacao = array();
            
            $aAuxCodigoBarrasFinal = str_split($sAuxCodigoBarrasFinal);

            for ($i = 0; $i < count($aAuxCodigoBarrasFinal); $i++) { 
                $aResultadoMultiplicacao[] = $aAuxCodigoBarrasFinal[$i] * $aMascara[$i];
            }

            $aResultadoMultiplicacaoAlgarismos = str_split( implode($aResultadoMultiplicacao) );
            
            $iResultadoAlgarismo = 0;

            if (@$_GET['debug_boleto'] == 'true')
                dump('algarismos: ' . implode($aResultadoMultiplicacaoAlgarismos));

            foreach ($aResultadoMultiplicacaoAlgarismos as $key => $aAlgarismos) {
                $iResultadoAlgarismo += (int) $aAlgarismos;
            }          

            $iTempMod = $iResultadoAlgarismo % 10;
            $iDigitoVerificador = (int) ( 10 - $iTempMod );
            $iDigitoVerificador = $iDigitoVerificador == 10 ? 0 : $iDigitoVerificador;

            if (@$_GET['debug_boleto'] == 'true')
                dump($sAuxCodigoBarrasFinal . ' : ' . $iDigitoVerificador);

            $sAuxCodigoBarrasFinal .= $iDigitoVerificador;                
            

            $sCodigoDeBarrasFinal .= $sAuxCodigoBarrasFinal;
        }

        if (@$_GET['debug_boleto'] == 'true')
            dd($sCodigoDeBarrasFinal);

        if ($bOnlyReturnDigito)
            return $iDigitoVerificador;
        
        return $sCodigoDeBarrasFinal;
    }

    static function genericCode($id, $length = 11){
        return str_pad($id, $length , '0', STR_PAD_LEFT);
    }

    public static function getPortoTrabalhoPeriodoAtual()
    {
        $aPortoTrabalhoPeriodos = LgDbUtil::getAll('PortoTrabalhoPeriodos', []);
        $oPortoTrabalhoPeriodoAtual = null;

        $sHoraAtual = date('Y-m-d H:i:s');

        $aPeriodos = [];

        $sDataFake = DateUtil::defautDatetime();

        foreach ($aPortoTrabalhoPeriodos as $oPortoTrabalhoPeriodo) {
            $sHoraIni = $oPortoTrabalhoPeriodo->hora_inicio->format('H:i:s');
            $sHoraFim = $oPortoTrabalhoPeriodo->hora_fim->format('H:i:s');

            if ($sHoraIni > $sHoraFim) {
                $aPeriodos[] = [
                    'inicio' => $sDataFake->modify('-1 day')->format('Y-m-d') . ' ' . $sHoraIni,
                    'fim' => DateUtil::defautDatetime()->format('Y-m-d') . ' ' . $sHoraFim,
                    'periodo' => $oPortoTrabalhoPeriodo
                ];
                $sDataFake = DateUtil::defautDatetime();
                $aPeriodos[] = [
                    'inicio' => $sDataFake->format('Y-m-d') . ' ' . $sHoraIni,
                    'fim' => $sDataFake->modify('+1 day')->format('Y-m-d') . ' ' . $sHoraFim,
                    'periodo' => $oPortoTrabalhoPeriodo
                ];
                $sDataFake = DateUtil::defautDatetime();
            }else {
                $aPeriodos[] = [
                    'inicio' => $sDataFake->format('Y-m-d') . ' ' . $sHoraIni,
                    'fim' => $sDataFake->format('Y-m-d') . ' ' . $sHoraFim,
                    'periodo' => $oPortoTrabalhoPeriodo
                ];
            }
        }

        foreach ($aPeriodos as $iKey => $aPeriodo) {
            if ($sHoraAtual >= $aPeriodo['inicio'] && $sHoraAtual <= $aPeriodo['fim']) {
                $oPortoTrabalhoPeriodoAtual = $aPeriodo['periodo'];
                $oPortoTrabalhoPeriodoAtual->inicio = $aPeriodo['inicio'];
                $oPortoTrabalhoPeriodoAtual->fim = $aPeriodo['fim'];
                break;
            }
        }

        return (object) $oPortoTrabalhoPeriodoAtual;
    }

    public static function removeCodigoBarrasDV($sCodigoBarrasComDV)
    {
        $sCodigoBarrasSemDV = '';

        foreach (str_split($sCodigoBarrasComDV) as $iKey => $sVal) {
            
            if ( ($iKey + 1) % 12 == 0)
                continue;

            $sCodigoBarrasSemDV .= $sVal;

        }

        return $sCodigoBarrasSemDV;
    }
}
?>
