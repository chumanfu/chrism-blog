<?php

namespace Core\Model;

class Model
{
	private $dbconnection;

	function __construct($dbconnection)
	{
		$this->dbconnection = $dbconnection;
	}

	protected function execute($sql, $datatypes=null, $values=null)
	{
		$returnArray = array('error'=>'');

		$stmt = $this->dbconnection->prepare($sql);

		if ($stmt)
		{

			$bindOK = true;

			if ($datatypes)
			{
				$bindOK = $this->bindParams($stmt, $datatypes, $values);
			}

			if ($bindOK)
			{
				$results = array();

				$this->stmt_bind_assoc($stmt, $results);

				if (!$stmt->execute())
				{
					$returnArray['error'] = 'Error deleting';
				}
			}

		}

		return $returnArray;
	}

	protected function insert($sql, $values, $types)
	{
		$id = -1;
		$bindParamAttr = array();
		$bindParamAttr[] = $types;

		foreach ($values as $value)
		{
			$bindParamAttr[] = $value;
		}

		$stmt = $this->dbconnection->prepare($sql);

		if ($stmt)
		{
			$bindOK = call_user_func_array(array(&$stmt, 'bind_param'), $this->makeValuesReferenced($bindParamAttr));

            if ($bindOK)
            {
                if ($stmt->execute())
                {
                    $id = $this->dbconnection->insert_id;
                }
            }
		}

		return $id;

	}

	private function makeValuesReferenced($arr)
    {
        $refs = array();
        foreach ($arr as $key => $value)
        {
            $refs[$key] = &$arr[$key];
        }
        return $refs;
    }

	protected function select($sql, $datatypes=null, $values=null)
	{
		$returnArray = array();

		$stmt = $this->dbconnection->prepare($sql);

		if ($stmt)
		{

			$bindOK = true;

			if ($datatypes)
			{
				$bindOK = $this->bindParams($stmt, $datatypes, $values);
			}

			if ($bindOK)
			{
				$results = array();

				$this->stmt_bind_assoc($stmt, $results);

				if ($stmt->execute())
				{
					while ($stmt->fetch())
					{
						$itemRecord = array();

						foreach($results as $key => $value)
						{
							$itemRecord[$key] = $value;
						}
						
						array_push($returnArray, $itemRecord);
					}
				}
			}

		}

		return $returnArray;
	}

    private function bindParams(&$stmt, $dataTypes, $valuesArray)
    {
        if (is_array($dataTypes))
        {
            $dataTypes = join('', $dataTypes);
        }

        if (count($valuesArray) > 0)
        {
            $params = array_merge(Array($dataTypes), $valuesArray);
            $tmp = array();
            foreach ($params as $key => $value)
            {
                $tmp[$key] = &$params[$key];
            }
            $bindOK = call_user_func_array(Array($stmt, 'bind_param'), $tmp);
        }
        else
        {
            $bindOK = true;
        }

        return $bindOK;
    }

    private function stmt_bind_assoc(&$stmt, &$out)
    {
        // bind the results to an associative array
        $data = mysqli_stmt_result_metadata($stmt);

        $fields = Array();
        $out = Array();

        $fields[0] = $stmt;
        $count = 1;

        while ($field = mysqli_fetch_field($data))
        {
            $fields[$count] = &$out[$field->name];
            $count++;
        }

        call_user_func_array('mysqli_stmt_bind_result', $fields);
    }

}

?>