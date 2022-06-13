<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * MenuRestricao Entity
 *
 * @property int $id
 * @property int $menu_id
 * @property int $perfil_id
 *
 * @property \App\Model\Entity\Menu $menu
 * @property \App\Model\Entity\Perfil $perfil
 */
class MenuRestricao extends Entity
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
        'menu_id' => true,
        'perfil_id' => true,
        'menu' => true,
        'perfil' => true,
    ];

    // public static function saveLacres($iMenu, $aData)
    // {
    //     $oMenusTable                  = TableRegistry::getTableLocator()->get('Menus');
    //     $oMenuRestricoesTable   = TableRegistry::getTableLocator()->get('MenuRestricoes');

    //     if (empty($aData)) 
    //         return $oMenuRestricoesTable->deleteAll(['menu_id' => $iMenu]);
        
    //     $aMenuRestricoes = $oMenuRestricoesTable
    //             ->find('list', ['keyField' => 'id', 'valueField' => 'perfil_id'])
    //             ->where(['menu_id' => $iMenu])
    //             ->toArray();

    //     foreach ($aMenuRestricoes as $oMenuRestricao) {
    //         # code...
    //     }

    //     $aLacresContainerIds = [];
    //     foreach ($aLacresContainer as $oLacre) {
    //         $aLacresContainerIds[$oLacre->numero] = $oLacre;
    //     }
               
    //     $aIds = array_keys($aLacresContainerIds);
    //     foreach ($aData as $sLacreTipo => $aLacres) {
    //         $aLacres = explode(',', $aLacres);
    //         $oTipoLacre = $oTipoLacresTable->find()->where(["lower(descricao) LIKE '%" . str_replace('_', ' ', $sLacreTipo) . "%'" ])->first();

    //         foreach ($aLacres as $lacre) {
    //             if (in_array($lacre, $aIds)) {
    //                 unset($aIds[array_search($lacre, $aIds)]);
    //             } else {
    //                 $data['numero'] = $lacre;
    //                 $data['tipo_lacre_id'] = $oTipoLacre->id;
    //                 $data['agendamento_container_id'] = $oAgendamentoContainer->id;
    //                 $oLacre = $oLacresTable->newEntity($data);
    //                 $oLacresTable->save($oLacre);
                    
    //                 if (!$oLacre->hasErrors())
    //                     $_SESSION['houve_alteracao_agendamento'] = true;
    //             }
    //         }
    //     }

    //     if (!empty($aIds)) {
    //         $iCount = $oLacresTable->deleteAll(['agendamento_container_id' => $oAgendamentoContainer->id, 'numero IN' => $aIds]);
            
    //         if ($iCount) {
    //             $_SESSION['houve_alteracao_agendamento'] = true;
    //         }
    //     }
    // }
    static public function salvarMenuRestricoes($iMenu, $aData)
    {
        $aMenuRestricoes = TableRegistry::getTableLocator()->get('MenuRestricoes')
            ->find('list', ['keyField' => 'id', 'valueField' => 'perfil_id'])
            ->where(['menu_id' => $iMenu])
            ->toArray();

        if (isset($aData)) {
            $selectedQuery = false;
            $deselectedQuery = false;
            $selected = array_diff($aData, $aMenuRestricoes);
            $deselected = array_diff($aMenuRestricoes, $aData);

            if(count($selected)) {
                $query = TableRegistry::getTableLocator()->get('MenuRestricoes')->query();
                $query->insert(['menu_id', 'perfil_id']);
                foreach ($selected as $selectedId) {
                    if($selectedId){
                        $query->values([
                            'menu_id' => $iMenu,
                            'perfil_id' => $selectedId
                        ]);
                    }
                }
                
                $selectedQuery = $query->execute();
            }
            
            if(count($deselected)) {
                $oMenuRestricoesSelected = TableRegistry::getTableLocator()->get('MenuRestricoes')->find('list')
                    ->select(['id'])
                    ->where(['menu_id' => $iMenu, 'perfil_id IN' => $deselected])
                    ->toArray();

                $deselectedQuery = TableRegistry::getTableLocator()->get('MenuRestricoes')->deleteAll(['id IN' => $oMenuRestricoesSelected]);
            }
            
            if ($selectedQuery || $deselectedQuery) {
                return true;
            } 
            else {
                return false;
            }
        }
    }
}
