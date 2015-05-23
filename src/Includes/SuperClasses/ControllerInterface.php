<?php
namespace Src\Includes\SuperClasses;

/*
 * Interface for module controllers
 */
interface ControllerInterface
{
	public function request();
	public function setGuid( $guid );
}