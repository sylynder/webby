<?php

/**
 * Handle and Manipulate Arrays - Inspired by Arrayz 
 * 
 * Credit: 
 * 
 * Version - 0.1
 */

namespace Base\Helpers;


class Arrayz
{
	/**
	 * Source variable
	 *
	 * @var
	 */
	private $source;

	/**
	 * Operator variable
	 *
	 * @var
	 */
	private $operator;

	public function __construct($array = [])
	{
		$this->source = [];

		if ($this->checkArray($array)) {
			$this->source = $array;
		}
	}

	/**
	 * Convert object to callable
	 *
	 * @param array $source
	 * @return Base\Helpers\Arrayz
	 */
	public function __invoke($source = []): Arrayz
	{
		$this->source = $source;
		return $this;
	}

	/*
	* Match and return the array. supports regex
	*/
	public function pluck()
	{
		$arguments = func_get_args();
		$search = $arguments[0];

		if ($search != '') {
			array_walk_recursive($this->source, function (&$value, &$key) use (&$search) {

				if (preg_match('/^' . $search . '/', $key)) {
					$this->intersected[][$key] = $value;
				}
			});

			$this->source = $this->intersected;
		}

		return $this;
	}

	/**
	 * Like an SQL where clause
	 * Supports operators. 
	 * 
	 * @param3 return actual key of element
	 *
	 * @return Base\Helpers\Arrayz
	 * 
	 */
	public function where(): Arrayz
	{
		$arguments = func_get_args();
		$option = [];
		$operator = '=';

		if (func_num_args() == 3) {
			$searchKey = $arguments[0];
			$operator = $arguments[1];
			$searchValue = $arguments[2];
		} else {
			$searchKey = $arguments[0];
			$searchValue = $arguments[1];
		}

		$option = array_filter($this->source, function ($src) use ($searchKey, $searchValue, $operator) {
			return $this->operatorCheck($src[$searchKey], $operator, $searchValue);
		}, ARRAY_FILTER_USE_BOTH);

		if (isset($arguments[3]) && $arguments[3]) {
			$this->source = $option;
		} else {
			$this->source = array_values($option);
		}

		return $this;
	}

	/**
	 * Where like
	 *
	 * @return Base\Helpers\Arrayz
	 * 
	 */
	public function whereLike(): Arrayz
	{
		$arguments = func_get_args();
		$option = [];
		$side = 'in';

		if (func_num_args() == 3) {
			$searchKey = $arguments[0];
			$searchValue = $arguments[1];
			$side = $arguments[2];
		} else {
			$searchKey = $arguments[0];
			$searchValue = $arguments[1];
		}

		switch ($side) {
			case 'none':
				$pattern = "{$searchValue}";
				break;
			case 'end':
				$pattern = "%{$searchValue}";
				break;
			case 'begin':
				$pattern = "{$searchValue}%";
				break;
			case 'in':
			default:
				$pattern = "%{$searchValue}%";
				break;
		}

		if (empty($searchValue)) {
			$searchValue = '%%empty%%';
		}

		$option = array_filter($this->source, function ($value) use ($searchValue) {
			return $this->filterArray($searchValue, $value);
		});

		if (isset($arguments[3]) && $arguments[3]) {
			$this->source = $option;
		} else {
			$this->source = array_values($option);
		}

		return $this;
	}

	/**
	 * Filter Array
	 *
	 * @param string $needle
	 * @param array $haystack
	 * 
	 * @return boolean
	 */
	public function filterArray($needle, $haystack): bool
	{

		foreach ($haystack as $value) {
			if (stripos($value, $needle) !== false) return true;
		};

		return false;
	}

	/**
	 * Like SQL WhereIN . Supports operators.
	 *
	 * @return Base\Helpers\Arrayz
	 */
	public function whereIn(): Arrayz
	{
		$arguments = func_get_args();

		$option = [];

		if (func_num_args() == 2) {
			$searchKey = $arguments[0];
			$searchValue = $arguments[1];
		} else {
			$searchKey = $arguments[0];
			$searchValue = $arguments[1];
		}

		foreach ($this->source as $k => $v) {
			if (
				@array_key_exists($searchKey, $v)
				&& @in_array($v[$searchKey], $searchValue)
			) {
				$option[] = $v;
			}
		}

		$this->source = $option;
		return $this;
	}

	/**
	 * SQL Like operator in PHP.
	 * Returns true if match else false.
	 * @param string $pattern
	 * @param string $subject
	 * @return bool
	 */
	public function likeMatch($pattern, $subject)
	{
		$pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
		return (bool) preg_match("/^{$pattern}$/i", $subject);
	}

	/**
	 * Search and return true
	 *
	 * @return bool
	 */
	public function contains()
	{
		$arguments = func_get_args();

		$isValid = false;

		if (func_num_args() == 2) {
			$searchKey = $arguments[0];

			$searchValue = $arguments[1];
		} else {
			$searchKey = '';

			$searchValue = $arguments[1];
		}

		// If search value founds, to stop the iteration 
		// using try catch method for faster approach
		try {
			array_walk_recursive($this->source, function (&$value, &$key) use (&$searchKey, &$searchValue) {

				if ($searchValue != '') {

					if ($searchValue == $value && $key == $searchKey) {
						$isThere = true;
					}
				} else {
					if ($searchValue == $value) {
						$isThere = true;
					}
				}
				// If Value Exists
				if ($isThere) {
					throw new \Exception;
				}
			});
		} catch (\Exception $exception) {
			$isValid = true;
		}

		return $this->source = $isValid;
	}

	/**
	 * Converting Multidimensional Array into single 
	 * array with/without null or empty 
	 *
	 * @return Base\Helpers\Arrayz
	 */
	public function collapse(): Arrayz
	{
		$arguments = func_get_args();

		$empty_remove = !empty($arguments[0]) ? $arguments[0] : false;

		$option = [];

		array_walk_recursive($this->source, function (&$value, &$key) use (&$option, &$empty_remove) {

			if ($empty_remove) {

				if ($value != '' || $value != NULL) {
					$option[][$key] = $value;
				}
			} else {
				$option[][$key] = $value;
			}
		});

		$this->source = $option;
		return $this;
	}

	/**
	 * Covert Two Multidimensional Array 
	 * with limit offset
	 *
	 * @return Base\Helpers\Arrayz
	 */
	public function limit(): Arrayz
	{
		$arguments = func_get_args();

		$limit = $arguments[0];
		$offset = !empty($arguments[1]) ? $arguments[1] : 0;
		$option = [];

		$count = count($this->source);

		if ($limit > $count) {
			$limit = $count;
		}

		$i = 0;
		if ($limit <= 1) {
			$option[] = $this->source[$offset];
		} else {

			for ($i = 0; $i < $limit; $i++) {
				$option[] = $this->source[$offset];
				$offset++;
			}
		}

		$this->source = $option;
		return $this;
	}

	/**
	 * Select keys and return only them
	 * By selecting single array will return flat array
	 * @param1: 'id, name, address', must be comma seperated.
	 *
	 * @return Base\Helpers\Arrayz
	 */
	public function select(): Arrayz
	{
		$arguments = func_get_args();
		$select = $arguments[0];
		$option = [];

		if (strstr($select, ',')) {
			$select = str_replace(", ", ',', $select);
		}

		$select = explode(",", $select);

		$count = 0;
		foreach ($this->source as $key => $value) {

			foreach ($value as $item => $string) {

				if (in_array($item, $select)) {

					if (count($select) > 1) {
						$option[$count][$item] = $string;
					} else {
						$option[$count] = $string;
					}
				}
			}

			$count++;
		}

		$this->source = $option;
		return $this;
	}

	/*
	* Group by a key value 
	*/
	public function groupBy()
	{
		$arguments = func_get_args();
		$grp_by = $arguments[0];
		$option = [];
		foreach ($this->source as $data) {
			$grp_val = $data[$grp_by];
			if (isset($option[$grp_val])) {
				$option[$grp_val][] = $data;
			} else {
				$option[$grp_val] = array($data);
			}
		}
		$this->source = $option;
		return $this;
	}

	/**
	 * Check with operators
	 *
	 * @param string $retrieved
	 * @param string $operator
	 * @param string $value
	 * @return void
	 */
	private function operatorCheck($retrieved, $operator, $value)
	{
		switch ($operator) {
			default:
			case '=':
			case '==':
				return $retrieved == $value;
			case '!=':
			case '<>':
				return $retrieved != $value;
			case '<':
				return $retrieved < $value;
			case '>':
				return $retrieved > $value;
			case '<=':
				return $retrieved <= $value;
			case '>=':
				return $retrieved >= $value;
			case '===':
				return $retrieved === $value;
			case '!==':
				return $retrieved !== $value;
		}
	}

	/**
	 * Check Array
	 *
	 * @param array $array
	 * @return bool
	 */
	private function checkArray($array)
	{
		if (is_array($array) && count($array) > 0) {
			return true;
		}
	}

	/**
	 * Recursive function
	 *
	 * @param array $array
	 * @param array $where
	 * @return mixed
	 */
	private function recursive($array, $where)
	{

		global $tempData;

		if (!empty($array)) {

			foreach ($array as $key => $value) {
				//If $value is an array.
				if (is_array($value)) {
					//We need to loop through it.
					return $this->recursive($value, $where);
				} else {
					$tempData[] = $key . '_' . $value;
				}
			}
		}

		return $tempData;
	}

	/**
	 * Return output
	 *
	 * @param boolean $returnObject
	 * @return array|object
	 */
	public function get($returnObject = true)
	{
		if ($returnObject) {
			return json_decode(
				json_encode($this->source)
			);
		}

		// $source = $this->toArray();
		// $json = json_encode($source, JSON_UNESCAPED_UNICODE);
		// return json_decode($json);
	}

	/**
	 * Return output to Array
	 *
	 * @return array
	 */
	public function toArray()
	{
		return $this->source;
	}

	/**
	 * Return output to Json
	 *
	 * @return array
	 */
	public function toJson()
	{
		return json_encode($this->source);
	}

	/**
	 * Return array keys
	 *
	 * @return Base\Helpers\Arrayz
	 */
	public function keys(): Arrayz
	{
		$this->source = array_keys($this->source);
		return $this;
	}

	/**
	 * Return array values
	 *
	 * @return Base\Helpers\Arrayz
	 */
	public function values(): Arrayz
	{
		$this->source = array_values($this->source);
		return $this;
	}

	/**
	 * Like SQL WhereIN . Supports operators.
	 *
	 * @return Base\Helpers\Arrayz
	 */
	public function whereNotIn(): Arrayz
	{
		$arguments = func_get_args();
		$option = [];

		if (func_num_args() == 2) {
			$searchKey = $arguments[0];
			$searchValue = $arguments[1];
		} else {
			$searchKey = $arguments[0];
			$searchValue = $arguments[1];
		}

		foreach ($this->source as $k => $v) {
			if (@array_key_exists($searchKey, $v) && @!in_array($v[$searchKey], $searchValue)) {
				$option[] = $v;
			}
		}

		$this->source = $option;
		return $this;
	}

	/**
	 * Search the key exists and return true if found.
	 *
	 * @return boolean
	 */
	public function has()
	{
		$arguments = func_get_args();

		$array = $arguments[0];
		$searchKey = $arguments[1];

		$isValid = false;

		// If search value found, to stop the iteration 
		// using try catch method for faster approach
		try {
			array_walk_recursive($array, function (&$value, &$key) use (&$searchKey) {

				if ($searchKey == $key) {
					$isThere = true;
				}

				// If Value Exists
				if ($isThere) {
					throw new \Exception;
				}
			});
		} catch (\Exception $exception) {
			$isValid = true;
		}

		return $isValid;
	}

	/**
	 * Select a key and sum its values. 
	 * 
	 * @param1: single key of array to sum
	 *
	 * @return array|int
	 */
	public function sum()
	{
		$arguments = func_get_args();
		$option = [];

		if (empty($arguments)) {
			return [];
		}

		$key = $arguments[0];

		$this->select($key);
		$this->source = array_sum($this->source);

		return $this->source;
	}

	/**
	 * Count items in an array collection
	 *
	 * @return void
	 */
	public function count()
	{
		return count($this->source);
	}
}
/* End of the file Arrayz.php */
