<?php

class registroModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
    


          public function guardar_publicacion($datos,$fotos)
      {    

 $publico="no plica";
if (isset($datos['publico'])) {
 $publico="";
 for ($i=0; $i < count($datos['publico']) ; $i++) { 
    
    $publico.= "(".$datos['publico'][$i].")";


}
}

 $agencia="NULL";
if (isset($datos['agencia']) && $datos["agencia"]!=0) {


    
    $agencia=$datos['agencia'];



}



 echo $sql="insert into chicas values ('',
    '".strtoupper ($datos['nombre'] )."',
    '".strtoupper ($datos['fecha_nacimiento'])."',
    '".strtoupper ($datos['destrezas'] )."',
    '".strtoupper ($datos['especialidad'])."',
    '".strtoupper ($datos['medidas'] )."',
    '".strtoupper ($datos['peso'])."',
    '".strtoupper ($datos['color_cabello'] )."',
    '".strtoupper ($datos['color_ojos'])."',
    '".strtoupper ($datos['color_piel'] )."',
    '".strtoupper ($datos['telefono'])."',
    '".strtoupper ($publico)."',
    ".$agencia."
    )";


$this->_db->query($sql);
            $id_publicacion=$this->_db->lastInsertId();



            for ($i=0; $i < count($fotos['fotos']['name']) ; $i++) 
            { 
                  $target_path = "public/img/imagenes/";
                  $nombre=uniqid('sosmedica').$fotos['fotos']['name'][$i];
                  $target_path = $target_path .$nombre;
                  $sql="insert into fotos_chicas values ('','".$id_publicacion."','".$nombre."')";
                  $this->_db->query($sql);
                  move_uploaded_file($fotos['fotos']['tmp_name'][$i], $target_path); 
                 // $obj_img = new SimpleImage();
                 // $obj_img->load($target_path);
                 // $obj_img->resize(300,300);
                 // $obj_img->save($target_path);
            }


                    $target_path = "public/video/publicaciones/";
                  $nombre=uniqid('nenas').$fotos['video']['name'];
                  $target_path = $target_path .$nombre;
                  $sql="insert into video_chica values ('','".$id_publicacion."','".$nombre."')";
                  $this->_db->query($sql);
                  move_uploaded_file($fotos['video']['tmp_name'], $target_path); 
                 // $obj_img = new SimpleImage();
                 // $obj_img->load($target_path);
                 // $obj_img->resize(300,300);
                 // $obj_img->save($target_path);



      }
        

}

?>


