<?php

  class EntidadBase{
    private $table;
    private $db;
    private $conectar;
    private $currentYear;
    private $currentMonth;
    private $trimestreActual;

    public function __construct($table){
      $this->table = (string) $table;
      require_once 'Conectar.php';
      $this->conectar = new Conectar();
      $this->db = $this->conectar->conexion();
    }

    public function getConectar(){
      return $this->conectar;
    }

    public function db(){
      return $this->db;
    }

    public function getAll(){
      $query = $this->db->query("SELECT * FROM $this->table ORDER BY id ASC");

      while($row = $query->fetch_object()){
        $resultSet[] = $row;
      }

      return $resultSet;
    }

    public function getById($id){
      $query = $this->db->query("SELECT * FROM $this->table WHERE id = $id");

      if($row = $query->fetch_object()){
        $resultSet = $row;
      }

      return $resultSet;
    }

    public function getBy($column, $value){
      $query = $this->db->query("SELECT * FROM $this->table WHERE $column LIKE '$value'");

      while($row = $query->fetch_object()){
        $resultSet[] = $row;
      }

      return $resultSet;
    }

    public function establecerYearActual(){
      $this->currentYear = (int)date("Y");
    } 

    public function establecerMesActual(){
      $this->currentMonth = (int)date("m");
      $this->trimestreActual = $this->obtenerTrimestreActual();
    }

    public function obtenerTrimestreActual(){
      if(!empty($this->currentMonth)){
        if($this->currentMonth >= 1 && $this->currentMonth <= 3){
            return 1;
        }if($this->currentMonth >= 4 && $this->currentMonth <= 6){
            return 2;
        }if($this->currentMonth >= 7 && $this->currentMonth <= 9){
            return 3;
        }else{
            return 4;
        }
      }
    }

    public function tipo_contribuyente($id){
      $sql = "SELECT tipo FROM contribuyente WHERE id = $id";
      $resultado = $this->db->query($sql);
      while($datos[] = $resultado->fetch_assoc());
      array_pop($datos);
      return $datos[0]["tipo"];
    }

    public function tipo_contribuyente_rif($rif,$deudor = "NULL"){
      if($deudor == "NULL"){
        $sql = "SELECT contribuyente FROM empresa WHERE rif = '$rif' AND contribuyente != 1";
        $empresa = $this->db->query($sql);

        $sql = "SELECT contribuyente FROM persona WHERE rif = '$rif' AND contribuyente != 1";
        $persona = $this->db->query($sql);
      }else{
        $deudor = (int)$deudor;
        $sql = "SELECT empresa.contribuyente FROM empresa INNER JOIN contribuyente ON empresa.contribuyente = contribuyente.id WHERE empresa.rif = '$rif' AND empresa.contribuyente != 1 AND contribuyente.deudor = $deudor";
        $empresa = $this->db->query($sql);

        $sql = "SELECT persona.contribuyente FROM persona INNER JOIN contribuyente ON persona.contribuyente = contribuyente.id WHERE persona.rif = '$rif' AND persona.contribuyente != 1 AND contribuyente.deudor = $deudor";
        $persona = $this->db->query($sql);
      }

      $search_emp = $empresa->num_rows;
      $search_per = $persona->num_rows;
     
      if($search_emp > 0 && $search_per == 0){
        return "emp";
      }else if($search_per > 0 && $search_emp == 0){
        return "per";
      }else{
        return false;
      }
    }

    public function id_contribuyente_rif($rif){
      $sql = "SELECT contribuyente FROM empresa WHERE rif = '$rif' AND contribuyente != 1";
      $empresa = $this->db->query($sql);
      $search_emp = $empresa->num_rows;

      $sql = "SELECT contribuyente FROM persona WHERE rif = '$rif' AND contribuyente != 1";
      $persona = $this->db->query($sql);
      $search_per = $persona->num_rows;

      if($search_emp > 0 && $search_per == 0){
        $datos = array();
        while($datos[] = $empresa->fetch_assoc());
        array_pop($datos);
        return $datos[0]["contribuyente"];
      }else if($search_per > 0 && $search_emp == 0){
        $datos = array();
        while($datos[] = $persona->fetch_assoc());
        array_pop($datos);
        return $datos[0]["contribuyente"];
      }else{
        return 0;
      }
    }

    public function deleteById($id){
      $query = $this->db->query("DELETE FROM $this->table WHERE id = $id");
      return $query;
    }

    public function deleteBy($column, $value){
      $query = $this->db->query("DELETE FROM $this->table WHERE $column LIKE '$value'");
      return $query;
    }

    public function TrimestresAnual(){
      $sql = "SELECT anyo FROM trimestre WHERE anyo = $this->currentYear GROUP BY anyo";
      $result = $this->db->query($sql);

      if($result->num_rows == 0){
        $b = 0;
        for($i = 1; $i <= 4; $i++){
          switch($i){
            case 1:
              $periodo = "Enero - Marzo";
            break;
            case 2:
              $periodo = "Abril - Junio";
            break;
            case 3:
              $periodo = "Julio - Septiembre";
            break;
            case 4:
              $periodo = "Octubre - Diciembre";
            break;
          }
          $sql = "INSERT INTO trimestre (numero, periodo, anyo) VALUES ($i,'$periodo',$this->currentYear)";
          $r = $this->db->query($sql);
          if($r){
            $b++; 
          }
        }
        if($b == 4){
          return true;
        }else{
          return false; 
        }
      }
    }

    public function DeudorTrimestreActual(){
      $sql = "SELECT id_trimestre FROM trimestre WHERE numero = $this->trimestreActual && anyo = $this->currentYear";
      $resultado = $this->db->query($sql);
      $it = $resultado->fetch_assoc();

      //VARIABLE QUE GUARDA EL ID DEL TRIMESTRE ACTUAL.
      $id_trimestre = $it["id_trimestre"];

      $sql = "SELECT id FROM contribuyente WHERE id NOT IN (1) AND deudor = 0";
      $resultado = $this->db->query($sql);
      while($contribuyentes[] = $resultado->fetch_assoc());

      //ARRAY QUE CONTIENE A TODOS LOS CONTRIBUYENTES QUE ESTAN SOLVENTES.
      array_pop($contribuyentes);

      $cant_contri = count($contribuyentes);

      for($i = 0; $i < $cant_contri; $i++){
        //VARIABLES QUE GUARDAN EL ID Y EL TIPO DEL CONTRIBUYENTE ACTUAL.
        $id_contribuyente = $contribuyentes[$i]["id"];

        //OBTENER EL ID DEL ULTIMO TRIMESTRE CANCELADO POR EL CONTRIBUYENTE.
        $sql = "SELECT detalle_factura.trimestre FROM detalle_factura INNER JOIN factura ON detalle_factura.factura = factura.cod_factura WHERE factura.contribuyente = $id_contribuyente GROUP BY detalle_factura.trimestre ORDER BY detalle_factura.trimestre DESC LIMIT 0,1";
        $resultado = $this->db->query($sql);
        $tm = $resultado->fetch_assoc();

        //VARIABLE QUE GUARDA EL ID DEL TRIMESTRE MAYOR DE PAGO 
        //DEL CONTRIBUYENTE.
        $trimestre_pago = $tm["trimestre"];

        //SI EL ULTIMO TRIMESTRE PAGADO POR EL CONTRIBUYENTE ES
        //MENOR QUE EL TRIMESTRE ACTUAL.
        if($trimestre_pago < $this->trimestreActual){
          //SE COLOCA COMO DEUDOR AL CONTRIBUYENTE.
          $sql = "UPDATE contribuyente SET deudor = 1 WHERE id = $id_contribuyente";
          $resultado = $this->db->query($sql);
        }
      }
    }
  }

?>
