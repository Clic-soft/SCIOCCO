<?php

class principalModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    /*public function Contador_Clics($ipclic,
								   $fk_afiliado,
								   $fk_link) {
		
		$fechaactual = date("Y-m-d H:i:s");	
			
        $this->_db->query("INSERT INTO ok_clics
							(
								ip,
								fecha,
								fk_afiliado,
								fk_link
							)
							VALUES
							(
								'".$ipclic."',
								'".$fechaactual."',
								".$fk_afiliado.",
								".$fk_link."
							);");
    }	*/	 		

    public function getimgmarcas() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM marca");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getnovedades() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT n.*,tn.nombre as tnov 
            									FROM novedades as n, tipo_novedad as tn
            									WHERE n.id_tipo_novedad=tn.id");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getqsomos($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT * FROM info_empresa where id=$id");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getnovedad($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT n.*,tn.nombre as tnov 
                                                FROM novedades as n, tipo_novedad as tn
                                                WHERE n.id_tipo_novedad=tn.id AND n.id=$id");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
}

?>
