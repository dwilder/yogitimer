<?php
namespace Src\Lib\Template\Views;

/*
 * Header class returns the HTML header
 */

class Header
{
	/*
	 * Return the header template
	 */
	public function getTemplate()
	{	
		$html = <<<EOT
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	
	<title>{title}</title>
	
	<meta type="description" content="{meta}">
	
	<!-- Icons -->
	<link rel="icon" type="image/png" href="/favicon.png">
	<!-- Apple Touch icons-->
	<link rel="apple-touch-icon" sizes="57x57" href="/assets/touch-icons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/assets/touch-icons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/assets/touch-icons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/assets/touch-icons/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/assets/touch-icons/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/assets/touch-icons/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/assets/touch-icons/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/assets/touch-icons/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/assets/touch-icons/apple-touch-icon-180x180.png">
	<!-- Window 8 icons-->
	<meta name="msapplication-TileColor" content="#e8e8e8">
	<meta name="msapplication-TileImage" content="/assets/touch-icons/mstile-144x144.png">

	<link rel="stylesheet" href="/assets/css/style.css">
	
</head>

<body{bodyclass}>

	<main role="container" id="top" class="container">
	
		<header class="site-header">
		
			{headermenu}
	
		</header><!-- .site-header -->
EOT;

		return $html;
	}
}
