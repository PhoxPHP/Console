<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Console\ErrorHandler
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

use Kit\Console\Environment;

class ErrorHandler
{

	/**
	* @var 		$env
	* @access 	protected
	*/
	protected	$env;

	/**
	* @var 		$cmd
	* @access 	protected
	*/
	protected	$cmd;

	/**
	* ErrorHandler construct.
	*
	* @param 	$env <Kit\Console\Environment>
	* @param 	$cmd <Kit\Console\Command>
	* @access 	public
	* @return 	<void>
	*/
	public function __construct(Environment $env, Command $cmd)
	{
		$this->env = $env;
		$this->cmd = $cmd;
	}

	/**
	* Handles generated errors.
	*
	* @param 	$errNumber <Integer>
	* @param 	$errString <String>
	* @param 	$errFile <String>
	* @param 	$errLine <Integer>
	* @access 	public
	* @return 	<void>
	*/
	public function handleError($errNumber, $errString, $errFile ='', $errLine = 0)
	{
		$interfaceSettings = $this->cmd->getConfigOpt('interface');
		$textColor = $interfaceSettings['error']['text_color'];
		$textBgColor = $interfaceSettings['error']['text_background'];

		$this->env->sendOutput('Error: ' . $errString, $textColor, $textBgColor);
		exit;
	}

}