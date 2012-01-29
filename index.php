<?php

	require 'CFilesystem/CFilesystem.php';
	require 'CDocumentationListWebPage.php';

	$cDocumentationListWebPage = new CDocumentationListWebPage( $_GET );
	$cDocumentationListWebPage->setCSSFile( 'main.css' );
	$cDocumentationListWebPage->setDocumentationFilesPath( '../docs/' );
	echo $cDocumentationListWebPage->generateWebpage();

?>
