<?php
namespace Src\Lib\Module;

/*
 * Interface for module controllers
 */
interface ControllerInterface
{
	public function request();
	public function setGuid( $guid );
}