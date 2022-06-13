<?php

namespace App\View\Helper;

use App\Controller\Component\AclComponent;
use Cake\View\Helper\HtmlHelper;

class AclHtmlHelper extends HtmlHelper {

    public function link($title, $url = null, array $options = array())
    {
        //ajeitando o link
        $link = $url;
        if (is_array($link) && isset($link['controller'])) {
            $link = $link['controller'] . '/' . $link['action'];
        } elseif ($link['action']) { // tem url que vem apenas action...
            $link = $this->request->params['controller'] . '/' . $link['action'];
        }
        //se retorna link ou apenas string, depois apaga isso
        $retorno = isset($options['returnTitle']) ? $title : null;
        unset($options['returnTitle']);
        //pegando dados do link
        list($controller, $action) = explode('/', $link);
        //pegando id do perfil atual
        $session = $this->request->session();
        $id = $session->read('Auth.User.perfil_id');
		//ajuste conforme a tabela de grupos do seu app
        $usuarioGrupos = \Cake\ORM\TableRegistry::get('Perfis');
        $lista = $usuarioGrupos->get($id)->acl;
        //vendo se manda o link ou vai null
        $acl = new AclComponent(new \Cake\Controller\ComponentRegistry());
        return $acl->check($controller, $action, $lista) ? parent::link($title, $url, $options) : $retorno;
    }

}
