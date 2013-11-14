<?php

namespace Service;

use Doctrine\DBAL\Connection;
use Exceptions\ValidationException;
use Model\Example;

class ExampleService
{

	private $db;

	public function __construct(Connection $db)
	{
		$this->db = $db;
	}

	public function insert(Example $example)
	{
		$dbData = $example->toColumn();

		$this->db->insert('TABLENAME', $dbData);

		return $this->db->lastInsertId();
	}

	public function validate($data)
	{
		$fields = array('variable');
		$errors = array();

		foreach ($fields as $field) {

			if (!array_key_exists($field, $data) || $data[$field] == ''){
				$errors[$field] = 'fill_in_all_fields';
			}

			if ($field == 'email' && !isset($errors[$field])) {
				if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
					$errors[$field] = 'invalid_email';
				}
			}

		}

		if (!empty($errors)) {
			throw new ValidationException($errors);
		}

		return true;
	}

}
