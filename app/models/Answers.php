<?php


/**
 * Questionnaire
 * Project Name: App
 * @package class
 * @author $Author: David $
 * @version $Revision: 0 $
 *
 */

class AnswersModel extends Model
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
	 * $id_user 
	 * @var int
	 */
	private $id_user;	
	
	/**
	 * $id_question 
	 * @var int
	 */
	private $id_question;	
	
	/**
	 * $id_questionnaire 
	 * @var int
	 */
	private $id_questionnaire;	
	
	/**
	 * $answer 
	 * @var int
	 */
	private $answer;	
	
	/**
	 * $datetime 
	 * @var int
	 */
	private $datetime;	
	
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
			$this->Filtro .= " answers.".$filtro." = '" . $val . "'";
		}

		if ( $this->Filtro != '' ) $this->Filtro = " WHERE " . $this->Filtro;
	}

	/**
	 * Limpia todas las propiedades del objeto
	 */
	public function resetData ()
	{
				$this->id = chr ( 0 );
				$this->id_user = chr ( 0 );
				$this->id_question = chr ( 0 );
				$this->id_questionnaire = chr ( 0 );
				$this->answer = chr ( 0 );
				$this->datetime = chr ( 0 );
			
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
		answers		" . $this->Filtro . $this->Group . $this->Sort . $this->Limit;
		
		// swo_print_r($sql);
		// die();
		
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
			  answers 
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
				$this->id_user = $this->Record [ 'id_user' ];
				$this->id_question = $this->Record [ 'id_question' ];
				$this->id_questionnaire = $this->Record [ 'id_questionnaire' ];
				$this->answer = $this->Record [ 'answer' ];
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
				
		if ( $this->id_user != chr ( 0 ) ) {
			$campos .= $sep . " id_user ";
			$valores .= $sep . "'" . ($this->id_user) . "'";
			$sep = ", ";
		}
				
		if ( $this->id_question != chr ( 0 ) ) {
			$campos .= $sep . " id_question ";
			$valores .= $sep . "'" . ($this->id_question) . "'";
			$sep = ", ";
		}
				
		if ( $this->id_questionnaire != chr ( 0 ) ) {
			$campos .= $sep . " id_questionnaire ";
			$valores .= $sep . "'" . ($this->id_questionnaire) . "'";
			$sep = ", ";
		}
				
		if ( $this->answer != chr ( 0 ) ) {
			$campos .= $sep . " answer ";
			$valores .= $sep . "'" . ($this->answer) . "'";
			$sep = ", ";
		}
				
		if ( $this->datetime != chr ( 0 ) ) {
			$campos .= $sep . " datetime ";
			$valores .= $sep . "'" . ($this->datetime) . "'";
			$sep = ", ";
		}
				
				
		$sql = "
		INSERT INTO
		  answers		  ( " . $campos . " )
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
				
		if ( $this->id_user != chr ( 0 ) ) {
			$campos .= $sep . " id_user = '" . ($this->id_user) . "'";
			$sep = ", ";
		}
				
		if ( $this->id_question != chr ( 0 ) ) {
			$campos .= $sep . " id_question = '" . ($this->id_question) . "'";
			$sep = ", ";
		}
				
		if ( $this->id_questionnaire != chr ( 0 ) ) {
			$campos .= $sep . " id_questionnaire = '" . ($this->id_questionnaire) . "'";
			$sep = ", ";
		}
				
		if ( $this->answer != chr ( 0 ) ) {
			$campos .= $sep . " answer = '" . ($this->answer) . "'";
			$sep = ", ";
		}
				
		if ( $this->datetime != chr ( 0 ) ) {
			$campos .= $sep . " datetime = '" . ($this->datetime) . "'";
			$sep = ", ";
		}
				
		/*
		$campos .= $sep . " fecha_ultima_modificacion = '" . $this->esc ( date ( "Y-m-d H:i:s" ) ) . "'";
		$sep = ", ";
		*/
		$sql = "UPDATE answers SET " . $campos . " WHERE id = '" . $id . "'	";
		
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
		  answers		WHERE id = '" . $id . "'
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

	public function getId_user()
	{
	    return $this->id_user;
	}
	
	public function setId_user($id_user)
	{
	    $this->id_user = $id_user;
	    return $this;
	}

	public function getId_question()
	{
	    return $this->id_question;
	}
	
	public function setId_question($id_question)
	{
	    $this->id_question = $id_question;
	    return $this;
	}

	public function getId_questionnaire()
	{
	    return $this->id_questionnaire;
	}
	
	public function setId_questionnaire($id_questionnaire)
	{
	    $this->id_questionnaire = $id_questionnaire;
	    return $this;
	}

	public function getAnswer()
	{
	    return $this->answer;
	}
	
	public function setAnswer($answer)
	{
	    $this->answer = $answer;
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