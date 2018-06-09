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

namespace Kit\Console;

use Kit\Console\Environment;
use Kit\Console\Command\Help;
use Kit\Console\Command\Route;
use Kit\Console\Contract\Runnable;

class Command
{
	
	/**
	* @var 		$commands
	* @access 	protected
	* @static
	*/
	protected static $commands = [];

	/**
	* @var 		$env
	* @access 	protected
	*/
	protected 	$env;

	/**
	* Command construct.
	*
	* @access 	public
	* @return 	<void>
	*/
	public function __construct(Environment $env)
	{
		$this->env = $env;
	}

	/**
	* Checks if a command is registered.
	*
	* @param 	$command <String>
	* @access 	public
	* @static
	* @return 	<Boolean>
	*/
	public static function hasCommand(String $label) : Boolean
	{
		return (isset(Command::$commands[$label])) ? true : false;
	}

	/**
	* Registers a command.
	*
	* @param 	$runnable <Kit\Console\Contract\Runnable>
	* @access 	public
	* @static
	* @return 	<void>
	*/
	public static function registerCommand(Runnable $runnable)
	{
		Command::$commands[$runnable->getId()] = $runnable;
	}

	/**
	* Returns all registered commands.
	*
	* @access 	public
	* @return 	<Array>
	* @static
	*/
	public static function getRegisteredCommands() : Array
	{
		return Command::$commands;
	}

	/**
	* Returns a command given it's id.
	*
	* @param 	$id <String>
	* @access 	public
	* @static
	* @return 	<Object> <Kit\Console\Contract\Runnable>
	*/
	public static function getCommandById(String $id) : Runnable
	{
		return Command::$commands[$id];
	}

	/**
	* Registers default console commands.
	*
	* @access 	public
	* @return 	<void>
	*/
	public function registerDefaults()
	{
		Command::registerCommand(new Route($this->env));
		Command::registerCommand(new Help($this->env));
	}

	/**
	* Processes called command and returns it's output.
	*
	* @access 	public
	* @return 	<void>
	*/
	public function watchOutput()
	{
		$arguments = $_SERVER['argv'];
		unset($arguments[0]);
		$argumentsCount = $_SERVER['argc'] - 1;
		$arguments = array_values($arguments);

		if ($argumentsCount < 1 || $arguments[0] == 'help') {
			// If no argument is passed, show help information. 
			$help = Command::getCommandById('help');
			return $help->run($arguments, $argumentsCount);
		}

		$this->env->sendOutput($argumentsCount);
	}

}