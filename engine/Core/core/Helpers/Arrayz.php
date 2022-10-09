<?php

/**
 * Handle and Manipulate Arrays - Inspired by Arrayz 
 * 
 * Credit: https://github.com/nobitadore/Arrayz
 * 
 * Version - 1.0.0
 */

namespace Base\Helpers;

use Base\Cache\Cache;

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

	/**
	 * Intersected variable
	 *
	 * @var
	 */
	private $intersected;

	/**
	 * Cache variable
	 * 
	 * @var
	 */
	private $cache;

	/**
	 * Cache as (json|serialize|igbinary)
	 * 
	 * @var
	 */
	private $cacheAs = 'serialize';

	/**
	 * Arrayz cache path variable
	 *
	 * @var string
	 */
	private $cachePath = 'arrayz';

	/**
	 * Arrayz cache item name
	 *
	 * @var string
	 */
	private $cacheItem;

	/**
	 * A non-associative array of keys 
	 * that should be censored in the source
	 *
	 * @var array
	 */
	public $keys = [];

	/**
	 * What should replace the censored data
	 *
	 * @var mixed
	 */
	public $ink;


	public function __construct($array = [])
	{
		$this->source = [];

		if ($this->checkArray($array)) {
			$this->source = $array;
		}

		$this->cache = new Cache;
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

	/**
	 * Use Serialize Type
	 *
	 * @param string $type
	 * @return Base\Helpers\Arrayz
	 */
	public function use($type = 'serialize'): Arrayz
	{
		$this->cacheAs = $type;

		return $this;
	}

	/**
	 * Serialize With Json
	 *
	 * @param string $type
	 * @return Base\Helpers\Arrayz
	 */
	public function json(): Arrayz
	{
		$this->use('json');

		return $this;
	}

	/**
	 * Serialize With Igbinary
	 *
	 * @param string $type
	 * @return Base\Helpers\Arrayz
	 */
	public function igbinary(): Arrayz
	{
		$this->use('igbinary');

		return $this;
	}

	/**
	 * Get cache data with item name
	 *
	 * @param string $item
	 * @return Base\Helpers\Arrayz
	 */
	public function cache($item): Arrayz
	{

		if (!is_string($item)) {
			throw new \Exception("cache() only expects a string to be used");
		}

		$this->cache->serializeWith = $this->cacheAs;
		$this->cache->setCachePath($this->cachePath);

		$this->cacheItem = $item;

		if ($this->cache->isCached($item)) {

			$data = $this->cache->getCacheItem($item);

			$data = is_object($data) ? arrayfy($data) : $data;

			$this->source = $data;
		}

		return $this;
	}

	/**
	 * Set arrayz cache data with ttl
	 *
	 * @param string|object|array $data
	 * @param integer $ttl
	 * @return Base\Helpers\Arrayz
	 */
	public function set($data, $ttl = 1800): Arrayz
	{
		if (!empty($ttl)) {
			$this->cache->expireAfter = $ttl;
		}

		$this->cache->serializeWith = $this->cacheAs;
		$this->cache->setCacheItem($this->cacheItem, $data);

		return $this;
	}

	/**
	 * Delete an arrayz cache item
	 *
	 * @return Base\Helpers\Arrayz
	 */
	public function delete(): Arrayz
	{
		if ($this->cache->isCached($this->cacheItem)) {
			$this->cache->deleteCacheItem($this->cacheItem);
		}
		return $this;
	}

	/**
	 * Check if cache item is available
	 *
	 * @param string $item
	 * @return bool
	 */
	public function available($item = ''): bool
	{
		$this->cache->setCachePath($this->cachePath);

		return $this->cache->isCached($item);
	}

	/**
	 * Pick values from available key
	 *
	 * @param string $key
	 * @return Base\Helpers\Arrayz
	 */
	public function pick($key): Arrayz
	{
		$values = [];

		$this->source = arrayfy($this->source);

		foreach ($this->source as $source) {
			if (is_array($source) && isset($source[$key])) {
				$values[] = $source[$key];
			}
		}

		$this->source = $values;

		return $this;
	}

	/**
	 * Match and return the array. supports regex
	 * 
	 * @return Base\Helpers\Arrayz
	 */
	public function pluck(): Arrayz
	{
		$arguments = func_get_args();
		$search = $arguments[0];

		$this->source = arrayfy($this->source);

		if ($search != '') {
			array_walk_recursive($this->source, function ($value, $key) use (&$search) {

				if (preg_match('/^' . $search . '/', $key)) {
					$this->intersected[][$key] = $value;
				}
			});

			$this->source = $this->intersected;
		}

		return $this;
	}

	/**
	 * Merge more index arrays into 
	 * a multidimensional array
	 *
	 * Takes multiple array params
	 * 
	 * @return array
	 */
	public function zip(): array
	{
		$arguments = func_get_args(); //get passed arguments

		return array_map(null, ...$arguments);
	}

	// ------ Wrapper array_* methods ----------------

	/**
     * Wrapper method for array_map
     *
     * @param \Closure $closure
     * @return array
     */
    public function map(\Closure $closure): array
    {
        return array_map($closure, $this->source);
    }

    /**
     * Wrapper method for array_filter
     *
     * @param \Closure $closure
     * @return array
     */
    public function filter(\Closure $closure): array
    {
        return array_filter($this->source, $closure);
    }

    /**
     * Wrapper method for in_array
     *
     * @param mixed $item
     * @return bool
     */
    public function exists(mixed $item): bool
    {
        return in_array($item, $this->source);
    }

    /**
     * Wrapper method for array_values
     *
     * @return array
     */
    public function getValues(): array
    {
        return array_values($this->source);
    }

    /**
     * Wrapper method for array_keys
     *
     * @return array
     */
    public function getKeys(): array
    {
        return array_keys($this->source);
    }

    /**
     * Wrapper method for array_search
     *
     * @param mixed $searchParam
     * @return false|int|string
     */
    public function search(mixed $searchParam, bool $strict = false): int|string|false
    {
        return array_search($searchParam, $this->source, $strict = false);
    }

    /**
     * Wrapper method for array_reduce
     *
     * @param \Closure $callback
     * @param mixed $initial
     * 
     * @return mixed
     */
    public function reduce(\Closure $callback, mixed $initial = null): mixed
    {
        return array_reduce($this->source, $callback, $initial);
    }

    /**
     * Wrapper method for array_chunk
     *
     * @param int $length
     * @param bool $preserve_keys
     * 
     * @return array
     */
    public function chunk(int $length, bool $preserve_keys = false): array
    {
        return array_chunk($this->source, $length, $preserve_keys);
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

		$this->source = arrayfy($this->source);

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

		$this->source = arrayfy($this->source);

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
	 * @return bool
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

		$this->source = arrayfy($this->source);

		foreach ($this->source as $key => $value) {
			if (
				@array_key_exists($searchKey, $value)
				&& @in_array($value[$searchKey], $searchValue)
			) {
				$option[] = $value;
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

			$searchValue = $arguments[0];
		}

		$this->source = arrayfy($this->source);

		$isThere = null;

		// If search value is found, stop the iteration 
		// using try catch method for faster approach
		try {
			array_walk_recursive($this->source, function ($value, $key) use (&$searchKey, &$searchValue, $isThere) {

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

		$this->source = arrayfy($this->source);

		array_walk_recursive($this->source, function ($value, $key) use (&$option, &$empty_remove) {

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
	 * Set the limit of array 
	 * content to access
	 *
	 * @return Base\Helpers\Arrayz
	 */
	public function limit(): Arrayz
	{
		$arguments = func_get_args();

		$limit = $arguments[0];
		$offset = !empty($arguments[1]) ? $arguments[1] : 0;
		$option = [];

		$this->source = arrayfy($this->source);

		$count = count($this->source);

		if ($limit > $count) {
			$limit = $count;
		}

		if (empty($this->source)) {
			return $this;
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
	 * Paginate array content
	 *
	 * @param  array $array
	 * @param int $page
	 * @param int $perPage
	 * @return Base\Helpers\Arrayz
	 */
	public function paginate($array, $page = 1, $perPage = 100): Arrayz
	{
		$pagination = [
			'length' => $perPage,
			'total' => sizeof($array),
			'currentPage' => $page 
		];

		$pagination['pages'] = ceil($pagination['total'] / $pagination['length']);
		$pagination['offset'] = ($pagination['currentPage'] * $pagination['length']) - $pagination['length'];

		$results = array_slice($array, $pagination['offset'], $pagination['length'], true);
		
		$this->source = $results;
		$this->results = $results;
		$this->pager = (object) $pagination;
		
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

		$this->source = arrayfy($this->source);

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
	public function groupBy(): Arrayz
	{
		$arguments = func_get_args();
		$groupBy = $arguments[0];
		$option = [];

		$this->source = arrayfy($this->source);

		foreach ($this->source as $data) {
			$groupValue = $data[$groupBy];
			if (isset($option[$groupValue])) {
				$option[$groupValue][] = $data;
			} else {
				$option[$groupValue] = [$data];
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
	 * @return mixed
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
	private function checkArray($array): bool
	{
		if (is_array($array) && count($array) > 0) {
			return true;
		}

		return false;
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
	 * @param bool $returnObject
	 * @return array|object
	 */
	public function get($returnObject = true)
	{
		if ($returnObject) {
			return json_decode(
				json_encode($this->source)
			);
		}
	}

	/**
	 * Return output to Array
	 *
	 * @return array
	 */
	public function toArray()
	{
		return arrayfy($this->source);
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
	 * Set the keys to censor
	 *
	 * @param  array $keys Keys to censor
	 * @return Base\Helpers\Arrayz
	 */
	public function censorKeys($keys): Arrayz
	{
		if (is_string($keys)) {
			$keys = [$keys];
		}

		$this->keys = $keys;

		return $this;
	}

	/**
	 * Set the value to replace censored key values with
	 *
	 * @param  mixed $ink What should replace the censored data
	 * @return Base\Helpers\Arrayz
	 */
	public function ink($ink = '**********'): Arrayz
	{
		$this->ink = is_callable($ink) ? $ink() : $ink;
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

		$this->source = arrayfy($this->source);

		foreach ($this->source as $key => $value) {
			if (@array_key_exists($searchKey, $value) && @!in_array($value[$searchKey], $searchValue)) {
				$option[] = $value;
			}
		}

		$this->source = $option;
		return $this;
	}

	/**
	 * Search the key exists and return true if found.
	 *
	 * @return bool
	 */
	public function has()
	{
		$arguments = func_get_args();

		$this->source = arrayfy($this->source);

		$array = $this->source;
		$searchKey = $arguments[0];

		$isValid = false;
		$isThere = null;
		// If search value found, to stop the iteration 
		// using try catch method for faster approach
		try {
			array_walk_recursive($array, function ($value, $key) use (&$searchKey, $isThere) {

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

		$this->source = arrayfy($this->source);

		$this->select($key);
		$this->source = array_sum($this->source);

		return $this->source;
	}

	/**
	 * Count items in an array collection
	 *
	 * @return int
	 */
	public function count()
	{
		return count($this->source);
	}

	/**
	 * Apply recursive array censorship to the source
	 *
	 * @return array
	 */
	public function censor()
	{
		$this->source = arrayfy($this->source);

		if (is_string($this->source) && $this->isValidJson($this->source)) {
			$this->source = json_decode($this->source, true);
		}

		if (!is_array($this->source) /*|| !$this->isAssocArray($this->source)*/) {
			throw new \Exception("arrayz received invalid array or json source `{$this->source}` ");
		}

		// Recursively traverse the array and censor the specified keys
		array_walk_recursive($this->source, function (&$value, $key) {
			if (in_array($key, $this->keys, true)) {
				$value = $this->ink;
			}
		});

		return $this;
	}

	/**
	 * Merge array
	 *
	 * @param array ...$array
	 * @return Base\Helpers\Arrayz
	 */
	public function merge(...$array)
	{

		$this->source = arrayfy($this->source);

		$source = $this->source;

		if (is_array($array) && $this->isMultiArray($array)) {
			$source = array_merge($array, $source);
		}

		$this->source = $source;

		return $this;
	}

	/**
	 * Add more arrays by key-value
	 * Or by two multidimensional array
	 * 
	 * @param string|array $key
	 * @param string $value
	 * @return Base\Helpers\Arrayz
	 */
	public function push($key, $value = '', $asArray = false)
	{

		$this->source = arrayfy($this->source);

		$array = $this->source;

		if (is_array($key) && $this->isMultiArray($key)) {
			$array = array_merge($key, $array);
		}

		if (is_string($key)) {
			$array[$key] = $value;
		}

		$this->source = $array;

		if (!$asArray) {
			return $this->get();
		}

		return $this->toArray();
	}

	/**
	 * Make array unique
	 *
	 * @return Base\Helpers\Arrayz
	 */
	public function unique()
	{
		if ($this->isMultiArray($this->source)) {
			$this->source = array_unique($this->source, SORT_REGULAR);		
		}

		return $this;
	}

	/**
	 *  Flatten a multi-dimensional array 
	 *  into a single level
	 *
	 *  @param     array    $array
	 *  @return    array
	 */
	public function flatten($toArray = false)
	{
		$result = [];

		array_walk_recursive($this->source, function($array) use (&$result)
		{
			$result[] = $array;
		});

		$this->source = $result;

		if ($toArray) {
			$this->source = arrayfy($result);
		}
		
		return $this;
	}

	/**
	 * Determine if the given array is associative or non-associative
	 *
	 * @param  array  $array
	 * @return bool
	 */
	public function isAssocArray(array $array)
	{
		// An empty array is in theory a valid associative array
		// so we return 'true' for empty.
		if ([] === $array) {
			return true;
		}

		$count = count($array);
		
		for ($i = 0; $i < $count; $i++) {
			if(!array_key_exists($i, $array)) {
				return true;
			}
		}

		// Dealing with a Sequential array
		return false;
	}

	/**
	 * Determine if given array is multidimensional
	 *
	 * @param array $array
	 * @return bool
	 */
	public function isMultiArray(array $array)
	{
		foreach ($array as $value) {
			if (is_array($value)) return true;
		}

		return false;
	}

	/**
	 * Check if the string received is valid json
	 *
	 * @param  string $string Assumed json string
	 * @return bool
	 */
	protected function isValidJson($string)
	{
		return is_json($string);
	}
	
}
/* End of the file Arrayz.php */
