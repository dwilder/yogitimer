<?php
namespace Src\Includes\Data;

use Src\Includes\Database\DB;

/*
 * The purpose of this class is to determine if a value already exists in a database table.
 */

trait DatabaseValueTrait
{
	/*
	 * Lookup the table, column, and value
	 */
	public function isUnique( $table, $column, $value )
	{
        $pdo = DB::getInstance();
        
		$q = "SELECT id FROM $table WHERE $column = :column";
		$stmt = $pdo->prepare($q);
		$stmt->bindValue(':column', $value);
		$stmt->execute();
		
		if ( $stmt->fetch() ) {
			return false; // There is a result. Value is not unique.
		}
		
		return true; // No result. This is a unique value.
	}
}
