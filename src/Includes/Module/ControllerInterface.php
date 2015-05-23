<?php
namespace Src\Includes\Module;

/*
 * Interface for module controllers
 */
interface ControllerInterface
{
	public function request();
	public function setGuid( $guid );
}