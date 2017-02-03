<?php

class agenciaController extends Controller
{
    private $_agencia;
    
    public function __construct() {
        parent::__construct();
        
        $this->_agencia = $this->loadModel('agencia');
    }
    
    public function index()
{
		
       
        $this->_view->titulo = 'agencia';
      	$this->_view->setJs(array('index'));
       $this->_view->setCss(array('css'));
        
        if (isset($_GET["bn"])) {
          $rs=$this->_agencia->get_only_name($_GET["agencia_name"]);
          for ($i=0; $i < count($rs) ; $i++) { 
            $rs[$i]['foto']= $this->_agencia->get_photo_all($rs[$i]['id_agencia']);
            $rs[$i]['total']['damas']=$this->_agencia->get_count_camp($rs[$i]['id_agencia'],"damas");
            $rs[$i]['total']['caballeros']=$this->_agencia->get_count_camp($rs[$i]['id_agencia'],"caballeros");
            $rs[$i]['total']['trans']=$this->_agencia->get_count_camp($rs[$i]['id_agencia'],"trans");
          }
            
           $this->_view->agencias=$rs;

        }else{

         $rs=$this->_view->agencias=$this->_agencia->get_all();

         for ($i=0; $i < count($rs) ; $i++) { 
            $rs[$i]['foto']= $this->_agencia->get_photo_all($rs[$i]['id_agencia']);
              $rs[$i]['total']['damas']=$this->_agencia->get_count_camp($rs[$i]['id_agencia'],"dama");
            $rs[$i]['total']['caballeros']=$this->_agencia->get_count_camp($rs[$i]['id_agencia'],"caballero");
            $rs[$i]['total']['trans']=$this->_agencia->get_count_camp($rs[$i]['id_agencia'],"trans");
          }

          $this->_view->agencias=$rs;

        }

      

        $this->_view->renderizar('index');
     
}

    public function auto_completado()
{
        
    
      


       echo json_encode( $this->_agencia->get_all());
     
}


}

?>
