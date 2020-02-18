<?php


/**
 * Questionnaire
 * Project Name: App
 * @package class
 * @author $Author: David $
 * @version $Revision: 0 $
 *
 */

class QuestionsModel extends Model
{
	
	// ////////////////////////////////////////////////////////////////////////////
	// TABLE PROPERTIES
	// ////////////////////////////////////////////////////////////////////////////
	
	/**
	 * $id 
	 * @var int
	 */
	private $id;	
	
	/**
	 * $question 
	 * @var int
	 */
	private $question;	
	
	/**
	 * $id_admin 
	 * @var int
	 */
	private $id_admin;	
	
	/**
	 * $id_questionnaires 
	 * @var int
	 */
	private $id_questionnaires;

	/**
	 * $datetime 
	 * @var int
	 */
	private $datetime;	
	
	// ////////////////////////////////////////////////////////////////////////////
	// ////////////////////////////////////////////////////////////////////////////
	// SPECIFIC METHODS
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
	 * Define Filters [$ID = 'xx' AND ]
	 * Parameters defined as "" are not filtered
	 */
	public function setFilterAND ($filtros)	
	{
		//If integer then we filter ID
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
			$this->Filtro .= " questions.".$filtro." = '" . $val . "'";
		}

		if ( $this->Filtro != '' ) $this->Filtro = " WHERE " . $this->Filtro;
	}

	/**
	 * Clean object
	 */
	public function resetData ()
	{
				$this->id = chr ( 0 );
				$this->question = chr ( 0 );
				$this->id_admin = chr ( 0 );
				$this->id_questionnaires = chr ( 0 );
				$this->datetime = chr ( 0 );
			
	}
	
	// ////////////////////////////////////////////////////////////////////////////
	// QUERYS
	// ////////////////////////////////////////////////////////////////////////////
	
	/**
	 * Query one record
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
	 * Must define filter, Sort, group y Limit before calling
	 *
	 * @return boolean
	 */
	public function QueryRecordset ()
	{
		
		$sql = "
		SELECT *
			FROM
		questions " . $this->Filtro . $this->Group . $this->Sort . $this->Limit;
	
		
		$res = $this->query ( $sql );
		if ( ! $res ) {
			$this->StatusMsg = 'Error reading database';
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
			  questions 
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
				$this->question = $this->Record [ 'question' ];
				$this->id_admin = $this->Record [ 'id_admin' ];
				$this->id_questionnaires = $this->Record [ 'id_questionnaires' ];
				$this->datetime = $this->Record [ 'datetime' ];
				
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
				
		if ( $this->question != chr ( 0 ) ) {
			$campos .= $sep . " question ";
			$valores .= $sep . "'" . ($this->question) . "'";
			$sep = ", ";
		}
				
		if ( $this->id_admin != chr ( 0 ) ) {
			$campos .= $sep . " id_admin ";
			$valores .= $sep . "'" . ($this->id_admin) . "'";
			$sep = ", ";
		}
				
		if ( $this->id_questionnaires != chr ( 0 ) ) {
			$campos .= $sep . " id_questionnaires ";
			$valores .= $sep . "'" . ($this->id_questionnaires) . "'";
			$sep = ", ";
		}

		if ( $this->datetime != chr ( 0 ) ) {
			$campos .= $sep . " datetime ";
			$valores .= $sep . "'" . ($this->datetime) . "'";
			$sep = ", ";
		}
				
				
		$sql = "
		INSERT INTO
		  questions		  ( " . $campos . " )
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
				
		if ( $this->question != chr ( 0 ) ) {
			$campos .= $sep . " question = '" . ($this->question) . "'";
			$sep = ", ";
		}
				
		if ( $this->id_admin != chr ( 0 ) ) {
			$campos .= $sep . " id_admin = '" . ($this->id_admin) . "'";
			$sep = ", ";
		}
				
		if ( $this->id_questionnaires != chr ( 0 ) ) {
			$campos .= $sep . " id_questionnaires = '" . ($this->id_questionnaires) . "'";
			$sep = ", ";
		}
				
		if ( $this->datetime != chr ( 0 ) ) {
			$campos .= $sep . " datetime = '" . ($this->datetime) . "'";
			$sep = ", ";
		}
				
		$sql = "UPDATE questions SET " . $campos . " WHERE id = '" . $id . "'	";
		
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
		  questions	WHERE id = '" . $id . "'
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

	public function getQuestion()
	{
	    return $this->question;
	}
	
	public function setQuestion($question)
	{
	    $this->question = $question;
	    return $this;
	}

	public function getId_admin()
	{
	    return $this->id_admin;
	}
	
	public function setId_admin($id_admin)
	{
	    $this->id_admin = $id_admin;
	    return $this;
	}

	public function getId_questionnaires()
	{
	    return $this->id_questionnaires;
	}
	
	public function setId_questionnaires($id_questionnaires)
	{
	    $this->id_questionnaires = $id_questionnaires;
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

}