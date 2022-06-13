<?php
namespace App\Model\Table;

use App\Model\Entity\EntradaSaidaContainer;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MovimentacoesEstoques Model
 *
 * @property \App\Model\Table\EstoquesTable&\Cake\ORM\Association\BelongsTo $Estoques
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\BelongsTo $Enderecos
 * @property \App\Model\Table\TipoMovimentacoesTable&\Cake\ORM\Association\BelongsTo $TipoMovimentacoes
 *
 * @method \App\Model\Entity\MovimentacoesEstoque get($primaryKey, $options = [])
 * @method \App\Model\Entity\MovimentacoesEstoque newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MovimentacoesEstoque[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MovimentacoesEstoque|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MovimentacoesEstoque saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MovimentacoesEstoque patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MovimentacoesEstoque[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MovimentacoesEstoque findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoItemLoteDesestufadosTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('ordem_servico_item_lote_desestufados');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');
    }

    public function beforeSave($event, $entity, $options)
    {
        if ($entity->container_id) {
            $oEntradaSaidaContainers = EntradaSaidaContainer::getLastByContainerId($entity->container_id, false, false, true);
            $entity->entrada_saida_container_id = @$oEntradaSaidaContainers->id;
        }
    }
}
