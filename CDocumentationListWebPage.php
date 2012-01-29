<?php

/* 
CDocumentationListWebPage - A webpage for code documentation files list
Copyright (C) 2012 Aleksi Räsänen <aleksi.rasanen@runosydan.net>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
 
	// ************************************************** 
	//  CDocumentationListWebPage
	/*!
		@brief Creates a webpage of documentation files
		@author Aleksi Räsänen
		@email aleksi.rasanen@runosydan.net
		@copyright Aleksi Räsänen, 2012
		@license GNU AGPL
	*/
	// ************************************************** 
	class CDocumentationListWebPage
	{
		private $cFilesystem;
		private $get;
		private $filesToShowInList;
		private $documentsPath;
		private $documentExtension;
		private $CSSFile;

		// ************************************************** 
		//  __construct
		/*!
			@brief Initialize class variables
			@param $get $_GET variables
			@return Nothing
		*/
		// ************************************************** 
		public function __construct( $get )
		{
			$this->filesToShowInList = array();
			$this->documentsPath = '.';
			$this->documentExtension = 'html';
			$this->get = $get;

			$this->cFilesystem = new CFilesystem;
		}

		// ************************************************** 
		//  setCSSFile
		/*!
			@brief Sets a CSS file what we use when we generate
			  a web page. CSS file is linked to HTML, not embedded.
			@param $CSSFile Path and filename of CSS file
			@return Nothing
		*/
		// ************************************************** 
		public function setCSSFile( $CSSFile )
		{
			$this->CSSFile = $CSSFile;
		}

		// ************************************************** 
		//  setDocumentationFilesPath
		/*!
			@brief Sets a path where we search documentation files.
			  By default we use same folder where this class is.
			@param $path Path of documentation files
			@return Nothing
		*/
		// ************************************************** 
		public function setDocumentationFilesPath( $path )
		{
			$this->documentsPath = $path;
		}

		// ************************************************** 
		//  setDocumentationFilesExtension
		/*!
			@brief Sets a documentation files extension.
			  By default we use 'html'.
			@param $extension Extension without a leading dot
			@return Nothing
		*/
		// ************************************************** 
		public function setDocumentationFilesExtension( $extension )
		{
			$this->documentExtension = $extension;
		}

		// ************************************************** 
		//  generateWebpage
		/*!
			@brief Generates a webpage
			@return HTML String
		*/
		// ************************************************** 
		public function generateWebpage()
		{
			$this->getFilesToShowInList();

			$html = '<!DOCTYPE html><html>'
				. '<head>'
				. '<title>Documenation list</title>'
				. '<link rel="stylesheet" href="' 
					. $this->CSSFile . '" />'
				. '</head>'
				. '<body>';
			
			$html .= '<div id="main">';
			$html .= '<h2>Documentation files</h2>';
			$html .= $this->generateHTMLListOfFiles();
			$html .= '</div>';
			$html .= '</body></html>';

			return $html;
		}

		// ************************************************** 
		//  generateHTMLListOfFiles
		/*!
			@brief Generates a HTML <ul> list of files
			@return HTML String
		*/
		// ************************************************** 
		private function generateHTMLListOfFiles()
		{
			$cf = $this->cFilesystem;

			$html = '<div id="files">';
			$html .= '<ul>';

			foreach( $this->filesToShowInList as $filename )
			{
				$stat = $cf->getFileInfo( $filename );
				$mtime = date( 'Y-m-d, H:i:s', $stat['mtime'] );

				$link_title = $cf->getFilenameWithoutExtension(
					$filename );

				$html .= '<li>';
				$html .= '<a href="' . $filename . '">' 
						. $link_title . '</a>';
				$html .= '<span class="modified_time">'
					. 'Updated: ' . $mtime;
				$html .= '</li>';
			}
			
			$html .= '</ul>';
			$html .= '</div>';

			return $html;
		}

		// ************************************************** 
		//  getFilesToShowInList
		/*!
			@brief Get all code files what we want to
			  show in a web page as a link
			@return Nothing - updates class variable
		*/
		// ************************************************** 
		private function getFilesToShowInList()
		{
			$files = $this->cFilesystem->getAllFilesFromPathWithExtension(
				$this->documentsPath, $this->documentExtension );

			$this->filesToShowInList = $files;
		}
	}
	
?>
