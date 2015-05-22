<?php
namespace Src\Lib\Data;

/*
 * The purpose of this trait is to determine if a value already exists in a database table.
 */

class DatabaseValue
{
	/*
	 * Store a reference to the database
	 */
	protected $pdo;
	
	/*
	 * Set the database
	 */
	public function setDatabase( PDO $pdo )
	{
		$this->pdo = $pdo;
	}
	
	/*
	 * Lookup the table, column, and value
	 */
	public function isUnique( $table, $column, $value )
	{
		$q = "SELECT id FROM $table WHERE $column = :column";
		$stmt = $this->pdo->prepare($q);
		$stmt->bindValue(':column', $value);
		$stmt->execute();
		
		if ( $stmt->fetch ) {
			return false; // There is a result. Value is not unique.
		}
		
		return true; // No result. This is a unique value.
	}
}
