<?php

class appModel extends Model
{
    public function __construct() {
        parent::__construct();
    }

    

public function menu($id = false){

	if ($id!=false) {
		$sql = "SELECT menu.* FROM menu,permisos,role,usuario WHERE\n"
    . "menu.id_menu=permisos.id_menu and \n"
    . "role.id_role = permisos.id_role and\n"
    . "permisos.permiso=1 and \n"
    . "role.id_role=usuario.id_role and\n"
    . "usuario.id_usuario=".$id."\n"
    . "order by id_menu asc\n";
	$menu = $this->_db->query($sql);
	return $menu->fetchall();
		
	}else{
		$sql = "SELECT DISTINCT menu.* FROM menu,permisos,role,usuario WHERE\n"
    . "menu.id_menu=permisos.id_menu and \n"
    . "role.id_role = permisos.id_role and\n"
    . "permisos.permiso=1 and \n"
    . "role.id_role=2 \n"
    . "order by id_menu asc\n";
	$menu = $this->_db->query($sql);
	return $menu->fetchall();


	}
}



    public function traer_menus(){


    $sql="select * from menu";
       

        $datos = $this->_db->query($sql);
              //  $datos->setFetchMode(PDO::FETCH_ASSOC);

        return $datos->fetchall();


    }
      public function traer_roles(){


    $sql="select * from role";
       

        $datos = $this->_db->query($sql);
              //  $datos->setFetchMode(PDO::FETCH_ASSOC);

        return $datos->fetchall();


    }

 public function traer_permisos($id,$id2){


$sql = "SELECT permisos.* FROM role,permisos,menu WHERE role.id_role = permisos.id_role and permisos.id_menu=menu.id_menu and menu.id_menu ='$id' and role.id_role='$id2'";    
        $datos = $this->_db->query($sql);
              //  $datos->setFetchMode(PDO::FETCH_ASSOC);

        return $datos->fetch();


    }

     public function permisos_ch($menu,$rol,$estado){

        $retVal = ($estado=='true') ? "1" : "0" ;

$sql = "SELECT COUNT(permisos.id_permisos) as numero FROM permisos WHERE id_menu = $menu   and id_role = $rol";
        $datos = $this->_db->query($sql);
$rs=$datos->fetch();
    if ($rs['numero']==0) {

        $sql="INSERT INTO permisos values('',$menu,$rol,$retVal)";
        $this->_db->query($sql);
    }else{

$sql = "UPDATE permisos SET permiso = $retVal WHERE id_menu = $menu AND id_role= $rol";  

        $datos = $this->_db->query($sql);
    }



    }


    public function log($ip,$peticion,$usuario){


      
        $controlador=$peticion->getControlador();
        $metodo=$peticion->getMetodo();
       date_default_timezone_set('America/Caracas');
       echo date('H-i-s');
         $sql="INSERT INTO log values ('',$usuario,'$ip','$controlador','$metodo','".date("Y-m-d")."','".date("H:i:s")."')";
        $this->_db->query($sql);
        

    }

     public function all_logs(){

       
        $sql = "SELECT * FROM log"; 
        
        $res=$this->_db->query($sql);

          return $res->fetchall();
    }

         public function all_cont(){

       //total
    $sql = "SELECT count(*) as num \n"
    . " FROM (SELECT log.ip FROM log GROUP BY ip) as tabla";
     $res=$this->_db->query($sql);
      $res->setFetchMode(PDO::FETCH_ASSOC);
     $cont['total']=$res->fetch();
        //las de hoy
    $sql = "SELECT count(*) as num \n"
    . " FROM (SELECT log.ip FROM log WHERE log.fecha = curdate() GROUP BY ip) as tabla";
     $res=$this->_db->query($sql);
     $res->setFetchMode(PDO::FETCH_ASSOC);
     $cont['hoy']=$res->fetch();
        //semana
    $sql = "SELECT count(*) as num \n"
    . " FROM (SELECT log.ip FROM log WHERE week(log.fecha) = week(curdate()) GROUP BY ip) as tabla";
     $res=$this->_db->query($sql);
     $res->setFetchMode(PDO::FETCH_ASSOC);
     $cont['semana']=$res->fetch();
        //mes
    $sql = "SELECT count(*) as num \n"
    . " FROM (SELECT log.ip FROM log WHERE MONTH(log.fecha) = MONTH(curdate()) GROUP BY ip) as tabla";
     $res=$this->_db->query($sql);
     $res->setFetchMode(PDO::FETCH_ASSOC);
     $cont['mes']=$res->fetch();

    
          return $cont;
    }

         public function gf($rs=false){

            if ($rs==false) {
                $sql = "DELETE FROM `switch` WHERE 1";
                $this->_db->query($sql);
            }
            else{
                $sql = "DELETE FROM `switch` WHERE 1";
                $this->_db->query($sql);
                $fecha=$rs['fecha'];
                $sql = "INSERT INTO `switch` (`id`, `accion`, `fecha`) VALUES ('',0,'$fecha')";
                $this->_db->query($sql);
            }

    }
             public function bloqueo(){

         
                $sql = "SELECT * FROM switch";
                $rs=$this->_db->query($sql);
                if(count($rs->fetchall())>0){
                  return true;
                }else
                {
                  return false;
                }

            
        

    }
                 public function bloqueo_datos(){

         
                $sql = "SELECT * FROM switch";
                $rs=$this->_db->query($sql);
               
                  return $rs->fetch();
                

            
        

    }

}

?>
