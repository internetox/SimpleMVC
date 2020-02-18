<?php
/**
 * Questionnaire
 * Project Name: App
 * @package class
 * @author $Author: David $
 * @version $Revision: 0 $
 *
 */

class AdminsModel extends Model
{

	// ////////////////////////////////////////////////////////////////////////////
	// PROPIEDADES DE LA ENTIDAD
	// ////////////////////////////////////////////////////////////////////////////
	
	/**
	 * $id 
	 * @var int
	 */
	private $id;	
	
	/**
	 * $email 
	 * @var int
	 */
	private $email;	
	
	/**
	 * $password 
	 * @var int
	 */
	private $password;	
	
	/**
	 * $ip 
	 * @var int
	 */
	private $ip;	
	
	/**
	 * $datetime 
	 * @var int
	 */
	private $datetime;	
	
	/**
	 * $is_active 
	 * @var int
	 */
	private $is_active;	
	
	// ////////////////////////////////////////////////////////////////////////////
	// ////////////////////////////////////////////////////////////////////////////
	// METODOS
	// ////////////////////////////////////////////////////////////////////////////
	
	// ////////////////////////////////////////////////////////////////////////////
	// SETUP
	// ////////////////////////////////////////////////////////////////////////////
	
	/**
	 * Constructor.
	 *
	 * 
	 */
	public function __construct ()
	{
		parent::__construct ();
		$this->StatusMsg = '';
		$this->resetData ();
	}

	/**
	 * Definicion de filtro [$ID = 'xx' AND ]
	 * Los parametros definidos como "" no intervienen en el filtro
	 */
	public function setFilterAND ($filtros)	
	{
		//Si el filtro es un numero lo pasamos como ID
		if (is_numeric($filtros)) 
		{
			$filtros = '{"id":'.$filtros.'}';
			$this->Limit = '';
		}
		
		$filtros = json_decode($filtros, true);

		$this->Filtro = '';
		foreach($filtros as $filtro => $val)
		{
			if ( $this->Filtro != '' ) $this->Filtro .= " AND";
			$this->Filtro .= " admins.".$filtro." = '" . $val . "'";
		}

		if ( $this->Filtro != '' ) $this->Filtro = " WHERE " . $this->Filtro;
	}

	/**
	 * Limpia todas las propiedades del objeto
	 */
	public function resetData ()
	{
				$this->id = chr ( 0 );
				$this->email = chr ( 0 );
				$this->password = chr ( 0 );
				$this->ip = chr ( 0 );
				$this->datetime = chr ( 0 );
				$this->is_active = chr ( 0 );
			
	}
	
	// ////////////////////////////////////////////////////////////////////////////
	// QUERYS
	// ////////////////////////////////////////////////////////////////////////////
	
	/**
	 * Query de un solo registro
	 *
	 * @param numeric $ID        	
	 * @return boolean
	 */
	public function QueryRecord ( $ID )
	{
		if ( $ID == '' ) {
			return false;
		}
		
		$this->setFilterAND ( $ID );
		
		if ( ! $this->QueryRecordset () ) {
			return false;
		}
		return $this->GetNextRecord ();
	}

	/**
	 * Query principal.
	 *
	 * Se pueden definir Filtro, Sort, group y Limit antes de invocar este
	 * metodo para manejar la consulta
	 *
	 * @return boolean
	 */
	public function QueryRecordset ()
	{
		
		$sql = "
		SELECT *
			FROM
		admins		" . $this->Filtro . $this->Group . $this->Sort . $this->Limit;
		
		
		$res = $this->query ( $sql );
		if ( ! $res ) {
			$this->StatusMsg = 'Error de base de datos leyendo registros de items';
			$this->DebugMsg ();
			return false;
		}
		
		$this->CantReg = $this->dbrows ( $res );
		$this->RecordSet = $res;
		return true;
	}

	/**
	 * Conteo de registros
	 * Se pueden definir Filtro, Sort, group y Limit antes de invocar este
	 * metodo para manejar la consulta
	 *
	 * @return numeric
	 */
	public function QueryRecordsetCount ()
	{
		$sql = "
			SELECT 
			  COUNT(*) AS CANT
			FROM
			  admins 
		" . $this->Filtro . $this->Group;
		
		$res = $this->query ( $sql );
		if ( $res === false ) {
			$this->StatusMsg = "Error Contando registros de la consulta. Error " . $this->dberno ();
			$this->DebugMsg ();
			return false;
		}
		$row = $res->fetch_assoc ();
		return $row [ 'CANT' ];
	}

	/**
	 * Carga el proximo registro del ultimo recordset leido, en las propiedades
	 * del objeto
	 *
	 * @return boolean
	 */
	public function GetNextRecord ()
	{
		
		$this->Record = $this->RecordSet->fetch_assoc ();
		
		if ( ! $this->Record ) {
			return false;
		}
				$this->id = $this->Record [ 'id' ];
				$this->email = $this->Record [ 'email' ];
				$this->password = $this->Record [ 'password' ];
				$this->ip = $this->Record [ 'ip' ];
				$this->datetime = $this->Record [ 'datetime' ];
				$this->is_active = $this->Record [ 'is_active' ];
				
		return true;
	}
	
	// ////////////////////////////////////////////////////////////////////////////
	// INSERT / UPDATE / DELETE
	// ////////////////////////////////////////////////////////////////////////////
	
	/**
	 * Inserta un registro.
	 * Deben cargarse las propiedades con los datos de la entidad antes de
	 * llamar a este metodo.
	 * Las propiedades que contengan el "string nulo" no intervienen en el
	 * insert
	 *
	 * @return booleasn
	 */
	public function Insert ()
	{
		
		$campos = '';
		$valores = '';
		$sep = '';
		
		
				
		if ( $this->id != chr ( 0 ) ) {
			$campos .= $sep . " id ";
			$valores .= $sep . "'" . ($this->id) . "'";
			$sep = ", ";
		}
				
		if ( $this->email != chr ( 0 ) ) {
			$campos .= $sep . " email ";
			$valores .= $sep . "'" . ($this->email) . "'";
			$sep = ", ";
		}
				
		if ( $this->password != chr ( 0 ) ) {
			$campos .= $sep . " password ";
			$valores .= $sep . "'" . ($this->password) . "'";
			$sep = ", ";
		}
				
		if ( $this->ip != chr ( 0 ) ) {
			$campos .= $sep . " ip ";
			$valores .= $sep . "'" . ($this->ip) . "'";
			$sep = ", ";
		}
				
		if ( $this->datetime != chr ( 0 ) ) {
			$campos .= $sep . " datetime ";
			$valores .= $sep . "'" . ($this->datetime) . "'";
			$sep = ", ";
		}
				
		if ( $this->is_active != chr ( 0 ) ) {
			$campos .= $sep . " is_active ";
			$valores .= $sep . "'" . ($this->is_active) . "'";
			$sep = ", ";
		}
				
				
		$sql = "
		INSERT INTO
		  admins		  ( " . $campos . " )
		VALUES
		  (" . $valores . ")";
		
		$res = $this->query ( $sql );
		
		if ( $res === false ) {
			$this->StatusMsg = "Error registrando datos del item " . $this->id . " . Error " . $this->dberno ();
			$this->DebugMsg ();
			return false;
		}
		
		$this->id = $this->dblast_id ();
		$this->StatusMsg = 'El registro fue creado exitosamente';
		return true;
	}

	/**
	 * Modifica un registro
	 *
	 * @param numeric $id
	 *        	Identificador del registro
	 * @return boolean
	 */
	public function Update ( $id )
	{
		$campos = '';
		$sep = '';
		
				
		if ( $this->id != chr ( 0 ) ) {
			$campos .= $sep . " id = '" . ($this->id) . "'";
			$sep = ", ";
		}
				
		if ( $this->email != chr ( 0 ) ) {
			$campos .= $sep . " email = '" . ($this->email) . "'";
			$sep = ", ";
		}
				
		if ( $this->password != chr ( 0 ) ) {
			$campos .= $sep . " password = '" . ($this->password) . "'";
			$sep = ", ";
		}
				
		if ( $this->ip != chr ( 0 ) ) {
			$campos .= $sep . " ip = '" . ($this->ip) . "'";
			$sep = ", ";
		}
				
		if ( $this->datetime != chr ( 0 ) ) {
			$campos .= $sep . " datetime = '" . ($this->datetime) . "'";
			$sep = ", ";
		}
				
		if ( $this->is_active != chr ( 0 ) ) {
			$campos .= $sep . " is_active = '" . ($this->is_active) . "'";
			$sep = ", ";
		}
				
		/*
		$campos .= $sep . " fecha_ultima_modificacion = '" . $this->esc ( date ( "Y-m-d H:i:s" ) ) . "'";
		$sep = ", ";
		*/
		$sql = "UPDATE admins SET " . $campos . " WHERE id = '" . $id . "'	";
		
		$res = $this->query ( $sql );
		
		if ( ! $res ) {
			$this->StatusMsg = 'Error de base de datos actualizando registro de items';
			$this->DebugMsg ();
			return false;
		} else {
			$this->StatusMsg = 'El registro fue actualizado exitosamente';
		}
		return true;
	}

	/**
	 * Elimina un registro
	 *
	 * @param numeric $id        	
	 * @return boolean
	 */
	public function Delete ( $id )
	{
		$sql = "
		DELETE FROM
		  admins		WHERE id = '" . $id . "'
		";
		
		$res = $this->query ( $sql );
		
		if ( ! $res ) {
			$this->StatusMsg = 'Error ' . $this->dberno () . ' de base de datos eliminando el item ID ' . $id;
			$this->DebugMsg;
			return false;
		}
		$this->StatusMsg = 'El item ' . $id . ' fue eliminado.';
		return true;
	
	}

	
	// ////////////////////////////////////////////////////////////////////////////
	// SETTERS & GETTERS
	// ////////////////////////////////////////////////////////////////////////////
	
	public function getId()
	{
	    return $this->id;
	}
	
	public function setId($id)
	{
	    $this->id = $id;
	    return $this;
	}

	public function getEmail()
	{
	    return $this->email;
	}
	
	public function setEmail($email)
	{
	    $this->email = $email;
	    return $this;
	}

	public function getPassword()
	{
	    return $this->password;
	}
	
	public function setPassword($password)
	{
	    $this->password = $password;
	    return $this;
	}

	public function getIp()
	{
	    return $this->ip;
	}
	
	public function setIp($ip)
	{
	    $this->ip = $ip;
	    return $this;
	}

	public function getDatetime()
	{
	    return $this->datetime;
	}
	
	public function setDatetime($datetime)
	{
	    $this->datetime = $datetime;
	    return $this;
	}

		public function getIs_active()
	{
	    return $this->is_active;
	}
	
	public function setIs_active($is_active)
	{
	    $this->is_active = $is_active;
	    return $this;
	}


}