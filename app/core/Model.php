<?php
abstract class Model
{

    public $StatusMsg;
    public $DebugMsg;
    public $RecordSet;
    public $CantReg;
    public $qry;
    public $Record;
    public $LastID;
    public $Filtro;
    public $Sort;
    public $Limit;
    public $Group;
    public $CONN;
    
    /**
     * 
     * Constructor de la clase
     * @param constante $base
     */
    public function __construct ()
    {
        $this->db_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
    }
    
    public function db_connect($db_host, $db_user, $db_pass, $db_name, $db_port)
    {
        $db_connect = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
        
        if( !mysqli_connect_errno() )
        {
            $this->CONN = $db_connect;
            return $this->CONN ;
        }
    }
    
    /**
     * Inicia una transaccion
     */
    public function START_TRANSACTION ()
    {
        $this->CONN->query ( "SET AUTOCOMMIT = 0" );
        $this->CONN->query ( "START TRANSACTION" );
    }

    /**
     * Confirma las operaciones de una transacción
     */
    public function COMMIT ()
    {
        $result = $this->CONN->query ( "COMMIT" );
        $this->CONN->query ( "SET AUTOCOMMIT = 1" );
        return $result;
    }

    /**
     * Revierte las operaciones de una transaccion
     */
    public function ROLLBACK ()
    {
        $result = $this->CONN->query ( "ROLLBACK" );
        $this->CONN->query ( "SET AUTOCOMMIT = 1" );
        return $result;
    }

    
    /**
     * 
     * Realiza un query sobre la conexion CONN
     * @param string $qry
     */
    public function query($qry){
        $this->qry= $qry;
        return $this->CONN->query ( $qry );
    }
    
    
    /**
     * 
     * Retorna el numero y la descripcion del error MySql
     */
    public function dberror(){
        return $this->dberno() . '-' . $this->dbmsgerror();
    }

    
    /**
     * 
     * Retorna el numero del error MySql
     */
    public function dberno(){
        return $this->CONN->errno;
    }
    
    
    /**
     * 
     * Retorna la descripcion del error MySql
     */
    public function dbmsgerror(){
        return $this->CONN->error;
    }


    /**
     * 
     * posiciona el puntero sobre el recordset
     * @param unknown_type $numero
     */
    public function seek ( $numero )
    {
        $this->RecordSet->data_seek ( $numero );
    }
    
    
    /**
     * @return the $CantReg
     */
    public function getCantReg() {
        return $this->CantReg;
    }
    
    public function DebugMsg(){
        $this->DebugMsg = $this->dberror() . '<hr>' . $this->qry;
    }
    
    public function dblast_id(){
        return $this->CONN->insert_id;
    }
    
    public function esc($data){
        return $this->CONN->real_escape_string ($data);
    }
    
    public function dbrows($res){
        return $res->num_rows;
    }
    
    public function one_result_query ( $query ){
        
        $result = $this->query ( $query );
        if ( $result === false ) 
            return false;
        
        $temp = $result->fetch_row () ;
        $result->free();
        if ( count ( $temp ) == 1 )
            return $temp [ 0 ];
        else
            return $temp;
    }
    
    /**
     * Ordenamiento 
     * 
     * @param string $campo
     * @param string $direccion
     */
    public function setOrder ( $campo, $direccion )
    {
        $this->Sort = "";
        if ( $campo != "" ) {
            $this->Sort = ' 
            ORDER BY ' . $campo . ' ' . $direccion;
        }
    }

    /**
     * Definicion de limites
     * 
     * @param numeric $desde
     * @param numeric $hasta
     */
    public function setLimit ( $desde, $hasta )
    {
        $this->Limit = "";
        if ( $desde != 0 or $hasta != 0 ) {
            $this->Limit = ' 
            LIMIT ' . $desde . ',' . $hasta;
        }
    }

    /**
     * Definicion de limites
     * 
     * @param numeric $desde
     * @param numeric $hasta
     */
    public function setGroupBy ( $criterio )
    {
        $this->Group = "";
        if ( $criterio != '' ) {
            $this->Group .= " 
            GROUP BY $criterio ";
        }
    }
}