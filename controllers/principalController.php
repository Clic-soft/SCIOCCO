<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');

//Clase extendida de la clase controller
class principalController extends Controller {

    private $_principal;

    //Se crea el constructor
    function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_principal = $this->loadModel('principal');
    }

    //INDEX PRINCIPAL - DONDE APARECE EL INTRO
    public function index() {
        //Si el usuario esta autenticado
      
        //Titulo de la página
        Session::set('modulo', "prin");
        $this->_view->titulo = 'Inicio';
		$this->_view->navegacion = 'inicio';

		$this->_view->imgmarcas = $this->_principal->getimgmarcas();
		$this->_view->novedades = $this->_principal->getnovedades();


        $this->_view->renderizar('index', "principal");
    }

	
	//SEGUNDO INDEX PRINCIPAL
	public function mision() {
        //Si el usuario esta autenticado
      
        //Titulo de la página
        Session::set('modulo', "prin");
        $this->_view->titulo = 'Inicio';
		$this->_view->navegacion = 'inicio';
		$this->_view->quiensomos = $this->_principal->getqsomos(1);
		$this->_view->imgmarcas = $this->_principal->getimgmarcas();
		
        //Vista de la pagina actual
        $this->_view->renderizar('mision', "principal");
    }

    //SEGUNDO INDEX PRINCIPAL
	public function vision() {
        //Si el usuario esta autenticado
      
        //Titulo de la página
        Session::set('modulo', "prin");
        $this->_view->titulo = 'Inicio';
		$this->_view->navegacion = 'inicio';
		$this->_view->quiensomos = $this->_principal->getqsomos(2);
		$this->_view->imgmarcas = $this->_principal->getimgmarcas();
		
        //Vista de la pagina actual
        $this->_view->renderizar('vision', "principal");
    }

    //SEGUNDO INDEX PRINCIPAL
	public function historia() {
        //Si el usuario esta autenticado
      
        //Titulo de la página
        Session::set('modulo', "prin");
        $this->_view->titulo = 'Inicio';
		$this->_view->navegacion = 'inicio';
		$this->_view->quiensomos = $this->_principal->getqsomos(3);
		$this->_view->imgmarcas = $this->_principal->getimgmarcas();

		
        //Vista de la pagina actual
        $this->_view->renderizar('historia', "principal");
    }

    //SEGUNDO INDEX PRINCIPAL
	public function sciocco() {
        //Si el usuario esta autenticado
      
        //Titulo de la página
        Session::set('modulo', "prin");
        $this->_view->titulo = 'Inicio';
		$this->_view->navegacion = 'inicio';
		$this->_view->quiensomos = $this->_principal->getqsomos(4);
		$this->_view->imgmarcas = $this->_principal->getimgmarcas();
		
        //Vista de la pagina actual
        $this->_view->renderizar('sciocco', "principal");
    }

	
	//CCONTADOR DE CLICS
	public function Contador_Clics() {
		
			$idseccion = $this->getSql('idseccion');
			$ipclic = $_SERVER['REMOTE_ADDR'];
		if(Session::get('autenticado_paginwebacemcop') == true){
			$idafiliado = Session::get('id_afiliado');	
		}else{
			$idafiliado = 0;
		}
	
	
	
		$this->_principal->Contador_Clics($ipclic,$idafiliado,$idseccion);
			    
	}		
}

?>