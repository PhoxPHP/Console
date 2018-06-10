<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Console\Command
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

namespace Kit\Console\Contract;

use Kit\Console\Command;
use Kit\Console\Environment;

interface Runnable
{

	/**
	* Runnable construct.
	*
	* @param 	$environment <Kit\Console\Environment>
	* @param 	$environment <Kit\Console\Command>
	* @access 	public
	* @return 	<void>
	*/
	public function __construct(Environment $environment, Command $command);

	/**
	* Returns the runnable's id.
	*
	* @access 	public
	* @return 	<String>
	*/
	public function getId() : String;

	/**
	* Runs the called command.
	*
	* @param 	$argumentsList <Array>
	* @param 	$argumentsCount <Integer>
	* @access 	public
	* @return 	<void>
	*/
	public function run(Array $argumentsList, int $argumentsCount);

	/**
	* Returns an array of commands that a command object can run.
	* The array keys will be the name of the command and the value will be the number of
	* arguments.
	*
	* With a command that requires no arguments, you need set it's value to [:none].
	* With a command that requires infinite arguments, you need to set it's value to [:i[]
	*
	* @access 	public
	* @return 	<Array>
	*/
	public function runnableCommands() : Array;

}