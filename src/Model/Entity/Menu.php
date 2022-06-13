<?php
namespace App\Model\Entity;

use App\Util\SessionUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Menu Entity
 *
 * @property int $id
 * @property string $titulo
 * @property int $ordem
 * @property int $nivel
 * @property string|null $controller
 * @property string|null $action
 * @property string|null $params
 * @property string|null $url
 * @property string $icon
 * @property int|null $menu_id
 *
 * @property \App\Model\Entity\Menu[] $menus
 */
class Menu extends Entity
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
        'titulo' => true,
        'ordem' => true,
        'nivel' => true,
        'controller' => true,
        'action' => true,
        'params' => true,
        'url' => true,
        'icon' => true,
        'menu_id' => true,
        'menus' => true
    ];

    public function getMenus() {
        $iPerfil = SessionUtil::getPerfilUsuario();

        $oMenu = TableRegistry::getTableLocator()->get('Menus')
            ->find()
            ->order(['nivel' => 'ASC', 'ordem' => 'ASC', 'id' => 'ASC']);

        $oMenuPai = $oMenu->newExpr()
            ->add('SELECT pai.titulo 
                FROM menus pai 
                WHERE Menus.menu_id = pai.id'
        );

        $oMenuPerfilLiberado = $oMenu->newExpr()
            ->add("SELECT liberados.perfil_id FROM menu_restricoes liberados 
                WHERE Menus.id = liberados.menu_id AND liberados.perfil_id = $iPerfil");

        $oHasRestricoes = $oMenu->newExpr()
            ->add("SELECT COUNT(1) FROM menu_restricoes restricoes WHERE 
                Menus.id = restricoes.menu_id");

        $oMenu->select(['pai_titulo' => $oMenuPai]);
        $oMenu->select(['menu_restringido' => $oHasRestricoes]);
        $oMenu->select(['perfil_liberado' => $oMenuPerfilLiberado]);
        $oMenu->select(['id', 'titulo', 'ordem', 'nivel', 'controller', 'action', 'params', 'url', 'icon', 'menu_id']);

        return $oMenu->toArray();
    }

    public static function getFilters()
    {
        return [
            [
                'name'  => 'desc',
                'divClass' => 'col-lg-2',
                'label' => 'Título',
                'table' => [
                    'className' => 'Menus',
                    'field'     => 'titulo',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'contr',
                'divClass' => 'col-lg-2',
                'label' => 'Controller',
                'table' => [
                    'className' => 'Menus',
                    'field'     => 'controller',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'act',
                'divClass' => 'col-lg-2',
                'label' => 'Ação',
                'table' => [
                    'className' => 'Menus',
                    'field'     => 'action',
                    'operacao'  => 'contem'
                ]
            ],
        ];
    }
}
