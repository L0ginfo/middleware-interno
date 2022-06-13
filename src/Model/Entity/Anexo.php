<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use Cake\Filesystem\Folder;

/**
 * Anexo Entity
 *
 * @property int $id
 * @property string $nome
 * @property string $arquivo
 * @property string $diretorio
 */
class Anexo extends Entity
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
        'nome' => true,
        'arquivo' => true,
        'diretorio' => true,
        'mime' => true,
        'size' => true
    ];


    public static function saveFile($file, $diretorio) {
        $diretorio = isset($diretorio) ? $diretorio : '';

        $nome = $file['name'];
        $extensao = pathinfo($nome, PATHINFO_EXTENSION);
        $nomeArquivo = sha1(rand() . microtime()) . '.' . $extensao;

        $tempArquivo = $file['tmp_name'];          
        $caminhoAbsoluto = ROOT . DS;
        $caminhoRelativo =  'files'. DS . 'dropzone' . DS . $diretorio;
        $caminho = $caminhoAbsoluto . DS . $caminhoRelativo;

        if(!is_dir($caminho)) {
            mkdir($caminho, 0777, true);
        }

        move_uploaded_file($tempArquivo, $caminho . DS . $nomeArquivo);

        return str_replace("\\","/", $caminhoRelativo . DS . $nomeArquivo);
    }


    public static function saveFileFromBase64($base64, $diretorio)
    {
        $caminhoAbsoluto = ROOT . DS . 'webroot';
        $caminhoRelativo =  'files' . DS . $diretorio;
        $caminho = $caminhoAbsoluto . DS . $caminhoRelativo;

        if(!is_dir($caminho)) {
            mkdir($caminho, 0777, true);
        }

        $ext = substr($base64, 6);
        $nomeArquivo = sha1(rand() . microtime()) . '.jpg';
        $uri = substr($base64, strpos($base64, ",") + 1);
        file_put_contents($caminho . DS . $nomeArquivo, base64_decode($uri));

        return str_replace("\\","/", $caminhoRelativo . DS . $nomeArquivo);
    }

    public static function saveAnexoInEntity($that, $table, $data)
    {
        $tableEntity = $that->{$table}->newEntity();
        
        $tableEntity = $that->{$table}->patchEntity($tableEntity, $data);
        if ($saved = $that->{$table}->save($tableEntity))
            return [
                'message' => 'Anexo cadastrado com sucesso.',
                'status'  => 200,
                'idEntity' => $saved->id,
                'anexo_id' => $saved->anexo_id
            ];
        
        return [
            'message' => __('Não foi possivel cadastrar o anexo.' . EntityUtil::dumpErrors($tableEntity)),
            'status' => 400
        ];
    }

    public static function removeFileDB($that, $tabela, $id)
    {
        $entity = $that->{$tabela}->find('all')->where(['anexo_id' => $id])->first();
        $result = $that->{$tabela}->delete($entity);
        
        if (!$result)
            return [
                'message' => __('Erro ao excluir ligação de anexo.' . EntityUtil::dumpErrors($result)),
                'status'  => 400
            ];

        $entity = $that->Anexos->get($id);
        $result = $that->Anexos->delete($entity);

        if (!$result)
            return [
                'message' => __('Erro ao excluir anexo.' . EntityUtil::dumpErrors($result)),
                'status'  => 400
            ];
        
        return [
            'message' => __('Anexo excluído com sucesso.'),
            'status'  => 200
        ];
    }

    public static function getContentFileImgTcpdf($iAnexoID)
    {
        if (!$iAnexoID)
            return '';
            
        $oAnexo        = LgDbUtil::getByID('Anexos', $iAnexoID);
        $sCaminho      = ROOT . DS . $oAnexo->arquivo;
        $sFileContents = file_get_contents($sCaminho);

        return $sFileContents;
    }

    public static function create($uArquivo, $sDiretorio, $aAtributos = []){
        $sCaminho           = ROOT . DS;
        $sNome              = @$aAtributos['nome'];
        $sTipo              = @$aAtributos['tipo'];
        $sExtensao          = @$aAtributos['extensao'];

        if(empty($uArquivo)) return false;

        if(is_array($uArquivo)){
            $sNome      = $sNome ?:@$uArquivo['name'];
            $sTipo      = @explode('/', $uArquivo['file']['type']?:[])[1];
            $sExtensao  = $sExtensao ?: @pathinfo($sNome, PATHINFO_EXTENSION);
            $sArquivo = self::saveFile($uArquivo, $sDiretorio);
        }else{
            $sArquivo = self::saveTmpFile($uArquivo, $sDiretorio, $sExtensao);
        }

        $sNome              = $sNome        ?:'file_'.date('Ymdis');
        $sTipo              = $sTipo        ?:'application/pdf';
        $sExtensao          = $sExtensao    ?:'pdf';

        if(empty($sArquivo)) return false;

        if ($sTipo == 'octet-stream')
            $sTipo = 'rar';

        if ($sTipo == 'x-zip-compressed')
            $sTipo = 'zip';

        if(strpos($sNome, ".$sExtensao") === false)
            $sNome = "$sNome.$sExtensao";
        
        $iFileSize = @filesize($sCaminho. DS .$sArquivo)?:0;

        $data = [
            'nome'      => $sNome,
            'mime'      => $sTipo,
            'arquivo'   => $sArquivo,
            'diretorio' => $sDiretorio,
            'size'      => $iFileSize
        ];

        $anexo = LgDbUtil::get('Anexos')->newEntity($data);
        if(LgDbUtil::get('Anexos')->save($anexo)) return $anexo;

        $sCaminho =  ROOT . DS . 'files' . DS . 'dropzone';
        Anexo::removeFile($sArquivo, $sCaminho);
        return false;
    }

    public static function saveTmpFile($uFile, $diretorio, $extensao) {
        $diretorio = isset($diretorio) ? $diretorio : '';
        $nomeArquivo = sha1(rand() . microtime()) . '.' . $extensao;
        $caminhoAbsoluto = ROOT . DS;
        $caminhoRelativo =  'files'. DS . 'dropzone' . DS . $diretorio;
        $caminho = $caminhoAbsoluto . DS . $caminhoRelativo;

        if(!is_dir($caminho)) {
            mkdir($caminho, 0777, true);
        }

        if(is_string($uFile)){
            if(move_uploaded_file($uFile, $caminho . DS . $nomeArquivo)){
                return str_replace("\\","/", $caminhoRelativo . DS . $nomeArquivo);
            }
            return false;
        }

        if(is_resource($uFile)){
            $metaData = stream_get_meta_data($uFile);
            $tempArquivo = $metaData['uri'];
        
            if(copy($tempArquivo, $caminho . DS . $nomeArquivo)){
                @fclose($uFile);
                @unlink($tempArquivo);
                return str_replace("\\","/", $caminhoRelativo . DS . $nomeArquivo);
            }

            return false;
              
        }
    
        return false;
    }
    

    public static function removeFile($path, $sCaminho)
    {
        $sCaminho .= $path;

        if (file_exists($sCaminho)) {
            return @unlink($sCaminho);
        }

        return  true;
    }
}
