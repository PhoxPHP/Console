<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Console\Environment
* @license 		MIT License
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

namespace Kit\Console;

use StdClass;
use Kit\Console\Attributes;
use Kit\Console\Exceptions\InvalidServerEnvironmentException;

class Environment
{

	/**
	* @var 		$arguments
	* @access 	protected
	*/
	protected	$arguments = [];

	/**
	* Make sure enviroment is cli.
	*
	* @access 	public
	* @return 	<void>
	*/
	public function validate()
	{
		$sapi = php_sapi_name();
		if ($sapi !== 'cli') {
			throw new InvalidServerEnvironmentException($this->getText(sprintf('Server API %s is not supported.', $sapi), 'red'));
		}
	}

	/**
	* Returns text with option to set the text colour.
	*
	* @param 	$text <String>
	* @param 	$colour <String>
	* @param 	$backgroundColor <String>
	* @access 	public
	* @return 	<Mixed>
	*/
	public function getText(String $text=null, String $colour='green', String $backgroundColor='black')
	{
		$colours = [
			'green' => Attributes::COLOR_GREEN,
			'red' => Attributes::COLOR_RED,
			'yellow' => Attributes::COLOR_YELLOW,
			'blue' => Attributes::COLOR_BLUE,
			'cyan' => Attributes::COLOR_CYAN,
			'magenta' => Attributes::COLOR_MAGENTA,
			'white' => Attributes::COLOR_WHITE,
		];

		$backgroundColors = [
			'green' => Attributes::BG_GREEN,
			'red' => Attributes::BG_RED,
			'yellow' => Attributes::BG_YELLOW,
			'blue' => Attributes::BG_BLUE,
			'cyan' => Attributes::BG_CYAN,
			'magenta' => Attributes::BG_MAGENTA,
			'black' => Attributes::BG_BLACK,
		];

		if (isset($colours[$colour])) {
			$text = $colours[$colour] . $text;
		}

		$text = $backgroundColors[$backgroundColor] . $text; 

		return $text . "\n";
	}

	/**
	* @todo 	document.
	*
	* @access 	public
	* @return 	<String>
	*/
	public function addTab()
	{
		return "\t";
	}

	/**
	* @todo 	document.
	*
	* @access 	public
	* @return 	<String>
	*/
	public function addNewLine()
	{
		return "\n";
	}

	/**
	* @todo 	document.
	*
	* @access 	public
	* @return 	<String>
	*/
	public function addSpace()
	{
		return '  ';
	}

	/**
	* Sends output to the environment.
	*
	* @param 	$output <String>
	* @param 	$colour <String>
	* @param 	$backgroundColor <String>
	* @access 	public
	* @return 	<void>
	*/
	public function sendOutput(String $output, String $colour='white', String $backgroundColor='black')
	{
		fwrite(STDOUT, $this->getText($output, $colour, $backgroundColor));
	}

	/**
	* Returns user input from the cli.
	*
	* @access 	public
	* @return 	<String>
	*/
	public function getOutputOption()
	{
		$handle = fopen ("php://stdin","r");
		return fgets($handle);
	}

}