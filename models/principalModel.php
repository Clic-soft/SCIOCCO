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
}

?>
