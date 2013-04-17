<?php

namespace Service;

use Doctrine\DBAL\Connection;
use Exceptions\ValidationException;

class TestService
{

	private $db;

	public function __construct(Connection $db)
	{
		$this->db = $db;
	}

}
