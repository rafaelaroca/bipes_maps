<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('grocery_CRUD');
	}
	 
	public function index()
	{
		echo "Please, specify a path";
		die();
	}

	public function dynamic()
	{
		$crud = new grocery_CRUD();
		$tabela = "viaturas";
		$crud->set_table($tabela);
		$crud->set_subject("dynamic marker");
	
		$crud->limit(25);

		$crud->required_fields('sigla','nome','descricao','publico','numero_de_funcionarios','receita_bruta_anual','data_fundacao');

		$crud->unset_fields('owner','meta');
		$crud->limit(25);

		$output = $crud->render();
		$this->loadView($output);
	}
	
	public function static()
	{
		$crud = new grocery_CRUD();
		$tabela = "sensores";
		$crud->set_table($tabela);
		$crud->set_subject("static marker");
	
		$crud->set_field_upload('logotipo','assets/uploads/files');
	
		$crud->limit(25);

		$crud->required_fields('sigla','nome','descricao','publico','numero_de_funcionarios','receita_bruta_anual','data_fundacao');

		$crud->unset_fields('owner','meta');
		$crud->limit(25);

		$output = $crud->render();
		 
		$this->loadView($output);        

	}

	function loadView($output = null)
	{
		$this->load->view('view.php',$output);    
	}
}
 
/* End of file Main.php */
/* Location: ./application/controllers/Main.php */


