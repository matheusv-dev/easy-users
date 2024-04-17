<?php

namespace App\Model;

class dbConnect
{

	/**
	 * 	mysqli_prepare 		   - Prepare an SQL statement for execution
	 *  mysqli_stmt_bind_param - Anexa os parametros na query
	 *  mysqli_stmt_execute    - execute query
	 *  mysqli_stmt_get_result - Gets a result set from a prepared statement
	 *  mysqli_stmt_free_result - Libera o resultado da memoria
	 */

	private $error;
	public $db;

	function __construct($host = "", $usuario = "", $senha = "", $banco = "")
	{
		if (
			$host != ""
		) {
			$this->db = new \mysqli($host, $usuario, $senha, $banco);
		} else {
			$this->db = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		}

		$this->db->set_charset("utf8");
	}

	function retornarArray($res, $retorna_varios = true)
	{
		$array = array();

		if (!is_array($res)) {
			return $array;
		}


		while ($linha = array_shift($res)) {
			$array[] = $linha;
		}

		if ($retorna_varios == true && count($array) == 1) {
			$arrayFinal[0] = $this->tratarRetornoSpecialChars($array);
			return $arrayFinal;
		}

		return $this->tratarRetornoSpecialChars($array);
	}

	function tratarRetornoSpecialChars($arrayLinha)
	{
		if (empty($arrayLinha)) {
			return array();
		}

		if (count($arrayLinha) == 1) {
			return array_map("htmlspecialchars", $arrayLinha[0]);
		} else {
			foreach ($arrayLinha as $key => $value) {
				$trataArray[0] = $value;
				$novoArray[] = $this->tratarRetornoSpecialChars($trataArray);
			}
			return $novoArray;
		}
	}

	function checkArray($arrayPost)
	{
		if (!is_array($arrayPost) || empty($arrayPost)) {
			$this->setLastError("Parâmetros Inválidos");
			return false;
		} else {
			foreach ($arrayPost as $key => $value) {
				if (is_array($value) || !empty($value)) {
					return true;
				}
			}
			$this->setLastError("Parâmetros Inválidos");
			return false;
		}
		return true;
	}


	function prepareParams($arrayPost)
	{
		foreach ($arrayPost as $key => $value) {
			$params[]["s"] = $value;
		}
		return $params;
	}

	/**
	 * USE APENAS PARA COMANDO INSERT, UPDATE, DELETE
	 * @param $query - string
	 * @param $params - array
	 * @return boolean
	 */
	function execute($query, $params = array())
	{
		if (empty($params)) {
			// QUERY SIMPLES
			return $this->db->query($query);
		} else {
			#echo "<br>QUERY COMPOSTA<br>";

			#die();
			$arrayPost = $this->prepareParams($params);
			$params    = $arrayPost;

			#echo "<br>QUERY COMPOSTA<br>";

			$parametros = array();
			$tipos 		= '';

			foreach ($params as $key => $value) {
				// os tipos serão as chaves
				$tipos .= key($value);
			}


			$parametros[] = &$tipos;

			foreach ($params as $key => $arrayParams) {
				//echo "$key <br>";
				foreach ($arrayParams as $key2 => $valor) {
					//echo "$valor <br>";
					$parametros2[] = $valor;
				}
			}

			for ($a = 0; $a < count($parametros2); $a++) {
				$parametros[] = &$parametros2[$a];
			}


			# PREPARANDO QUERY
			$stmt = $this->db->prepare($query);

			if (!$stmt) {
				$this->setLastError("QUERY_NAO_EXECUTADA");
				return false;
			}


			/*  use call_user_func_array, as $stmt->bind_param('s', $param);
				 *  does not accept params array
				 * */
			call_user_func_array(array($stmt, 'bind_param'), $parametros);


			$res = $stmt->execute();


			# liberando memoria
			$stmt->store_result();
			$stmt->free_result();
			$stmt->close();

			return $res;
		}
	}

	/**
	 * FUNCAO CRIADA COMO WORKAROUND PORQUE A EXTENSÃO MYSQLND NÃO ESTAVA INSTALADA NO SERVIDOR
	 *
	 * COM O MYSQLND INSTALADO FUNCIONA COM - $result->get_result()
	 *
	 */
	function get_result($Statement)
	{
		# COM O MYSQLND INSTALADO FUNCIONA COM 	- $result->fetch_assoc()
		# SEM O MYSQLND TEM QUE USAR  		 	- array_shift($result)


		$RESULT = array();
		$Statement->store_result();
		for ($i = 0; $i < $Statement->num_rows; $i++) {
			$Metadata = $Statement->result_metadata();
			$PARAMS = array();
			while ($Field = $Metadata->fetch_field()) {
				$PARAMS[] = &$RESULT[$i][$Field->name];
			}
			call_user_func_array(array($Statement, 'bind_result'), $PARAMS);
			$Statement->fetch();
		}
		return $RESULT;
	}

	function fetch_assoc($result)
	{
		# COM O MYSQLND INSTALADO FUNCIONA COM 	- $result->fetch_assoc()
		# SEM O MYSQLND TEM QUE USAR  		 	- array_shift($result)
		//return array_shift($result);
	}


	function select($query, $params = array())
	{
		if (empty($params)) {
			// QUERY SIMPLES
			$stmt = $this->db->prepare($query);

			$stmt->execute();

			# pegando resultado
			//$res = $stmt->get_result(); funciona apenas se tiver a extensao do mysqlnd instalada no php

			$res = $this->get_result($stmt);

			# liberando memoria
			$stmt->store_result();
			$stmt->free_result();
			$stmt->close();

			return $res;
		} else {
			$arrayPost = $this->prepareParams($params);
			$params    = $arrayPost;

			$parametros = array();
			$tipos 		= '';

			foreach ($params as $key => $value) {
				// os tipos serão as chaves
				$tipos .= key($value);
			}


			$parametros[] = &$tipos;

			foreach ($params as $key => $arrayParams) {
				//echo "$key <br>";
				foreach ($arrayParams as $key2 => $valor) {
					//echo "$valor <br>";
					$parametros2[] = $valor;
				}
			}

			for ($a = 0; $a < count($parametros2); $a++) {
				$parametros[] = &$parametros2[$a];
			}



			# PREPARANDO QUERY
			$stmt = $this->db->prepare($query);

			/*  use call_user_func_array, as $stmt->bind_param('s', $param);
				 *  does not accept params array
				 * */
			if (!$stmt) {
				$this->setLastError("QUERY_NAO_EXECUTADA");
				return false;
			}


			call_user_func_array(array($stmt, 'bind_param'), $parametros);


			$stmt->execute();

			# pegando resultado
			//$res = $stmt->get_result(); funciona apenas se tiver a extensao do mysqlnd instalada no php

			$res = $this->get_result($stmt);

			# liberando memoria
			$stmt->store_result();
			$stmt->free_result();
			$stmt->close();

			return $res;
		}
	}


	public function getLastError()
	{
		return $this->error;
	}
	public function setLastError($error)
	{
		$this->error = $error;
	}
}
