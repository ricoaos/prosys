<?php

class Admin_ClienteController extends Util_Controller_Action2
{	
    public function init()
    {
    	parent::init();
    	$this->Model = new Model_Cliente();
    	$this->iduser = Zend_Auth::getInstance()->getStorage()->read();
    }

    /**
     * @var
     */
    public function indexAction()
    {       	
    	if($this->_request->getParam('id')){
    		
    		$dadospagina = $this->Model->find($this->_request->getParam('id'));
    		$cpf= null;
    		$dados=array();
	    	foreach ($dadospagina as $row){
	    		list($YY,$mm,$dd) = explode('-',$row["dtNascimento"]);
	    		$cpf = strlen($row["cpf"]) < 11 ? str_pad($row["cpf"], 11,0, STR_PAD_LEFT) : $row["cpf"];
		    	$dados = array(
		    		'idcliente' => $row["idcliente"],
				    'nmCliente' => strtoupper($row["nmCliente"]),
				    'cpf' => substr($cpf,0,3).'.'.substr($cpf,3,3).'.'.substr($cpf,6,3).'-'.substr($cpf,9),
				    'dtNascimento' => $dd.'/'.$mm.'/'.$YY,
				    'sexo' => $row["sexo"],
				    'cep' => $row["cep"],
				    'complemento' => strtoupper($row["complemento"]),
				    'endereco' => strtoupper($row["endereco"]),
				    'numero' => $row["numero"],
				    'bairro' => $row["bairro"],
				    'cidade' => $row["cidade"],
				    'estado' => $row["estado"],
				    'email' => $row["email"],
				    'telFixo' => '('.substr($row["telFixo"],0,2).')'.substr($row["telFixo"],2),
				    'telCelular' => '('.substr($row["telCelular"],0,2).')'.substr($row["telCelular"],2),
		    		'nrRG'=> $row["nrRG"]
		    	);
	    	}
	    	
    		$this->view->dadospagina = $dados;
    	}
    	
    	if($this->_request->isPost())
    	{
    		$post = $this->_request->getPost();
    		list($dd,$mm,$YY) = explode('/',$post["dtNascimento"]);    		
    		$dados = array(
    			'nrRG' => preg_replace('/\D+/', "", $post['nrRG']),
    			'bairro' => $post['bairro'],
    			'cep' => preg_replace('/\D+/', "", $post['cep']),
    			'cidade' => $post['cidade'],
    			'complemento' => $post['complemento'],
    			'cpf' => preg_replace('/\D+/', "", $post['cpf']),
    			'dtNascimento' => $YY."-".$mm."-".$dd,
    			'email' => $post['email'],
    			'endereco' => $post['endereco'],
    			'estado' => $post['estado'],
    			'nmCliente' => $post['nmCliente'],
    			'numero' => $post['numero'],
    			'sexo' => $post['sexo'],
    			'telCelular' => preg_replace('/\D+/', "", $post['telCelular']),
    			'telFixo' => preg_replace('/\D+/', "", $post['telFixo']),
    			'cdUser' => $this->iduser->idusuarios,
				'dt_hmUser' => date('Y-m-d H:i:s')
    		);

    		if(empty($post['idcliente'])){
    			$insert = $this->Model->save($dados);
    		}else{
    			//Zend_Debug::dump($dados);die;
    			$insert = $this->Model->update($dados,$post['idcliente']);
    		}
    		//Zend_Debug::dump($post);die;
    		
    		
    		//$msg = $insert != 0 ? "Registro cadastrado com sucesso!" : "Erro ao cadastrar registro";
    		//$this->view->resposta = $msg;
    		
    	}
    	
    	$this->view->usuario = $this->iduser->username;
    }
    
    /**
     * 
     */
    public function deleteAction()
    {
    	$post = $this->_request->getParam('id');
    	Zend_Debug::dump($post);die;
		$dados = array(
			'idExclusao'      => 'E',
			'cdUserE'         => $this->iduser->idusuarios,
			'dtUserE'         => date('Y-m-d H:i:s')		
		);
			
		$delete = $this->Model->update($dados, $post);
    	$msg = $delete != 0 ? "Registro excluido com sucesso!" : "Erro ao excluir registro";
		$this->view->resposta = $msg;
		$this->_redirect('admin/cliente/allclientes');
    }
    
    /**
     * 
     */
    public function allclientesAction()
    {
    	$getClientes = $this->Model->getClientes();
		$dados = array();
    	foreach ($getClientes as $row){
    		list($Y,$m,$d) = explode('-',$row["dtNascimento"]);
    		$cpf = strlen($row["cpf"]) < 11 ? str_pad($row["cpf"], 11,0, STR_PAD_LEFT) : $row["cpf"];
	    	$dados[] = array(
    			'idcliente' => $row["idcliente"],
    			'nmCliente' => strtoupper($row["nmCliente"]),
    			'cpf' => substr($cpf,0,3).'.'.substr($cpf,3,3).'.'.substr($cpf,6,3).'-'.substr($cpf,9),
    			'dtNascimento' => $d.'/'.$m.'/'.$Y,
    			'sexo' => $row["sexo"] == "M" ? "MASCULINO" : "FEMININO",
    			'email' => $row["email"],
    			'telFixo' => '('.substr($row["telFixo"],0,2).')'.substr($row["telFixo"],2),
    			'telCelular' => '('.substr($row["telCelular"],0,2).')'.substr($row["telCelular"],2),
    			'idExclusao' => $row["idExclusao"],
    			'RG'=> $row["nrRG"]
	    	);
    	}
    	    	
    	$this->view->clientes = $dados;
    	$this->view->usuario = $this->iduser->username;
    }
}