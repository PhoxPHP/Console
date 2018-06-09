<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Console\Command\Help
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

namespace Kit\Console\Command;

use Kit\Console\Command;
use Kit\Console\Environment;
use Kit\Console\Contract\Runnable;

class Help implements Runnable
{

	/**
	* @var 		$env
	* @access 	protected
	*/
	protected	$env;

	/**
	* {@inheritDoc}
	*/
	public function __construct(Environment $env)
	{
		$this->env = $env;
	}

	/**
	* {@inheritDoc}
	*/
	public function getId() : String
	{
		return 'help';
	}

	/**
	* {@inheritDoc}
	*/
	public function run(Array $argumentsList, int $argumentsCount)
	{
		$mask = "|%5.5s |%-30.30s | x |\n";
		$commands = array_values(Command::getRegisteredCommands());

		$this->env->sendOutput('PhoxPHP Command Line Interface help.', 'green');
		$this->env->sendOutput('Usage:'. $this->env->addTab() . 'php console [command id] [...arguments]');
		$this->env->sendOutput($this->env->addTab() . 'E.g: ' . 'php console help list-commands');
	}

	/**
	* {@inheritDoc}
	*/
	public function runnableCommands() : Array
	{
		return [
			'list-commands' => ':nil',
			'create-runnable' => null
		];
	}

	/**
	* Lists all registered commands.
	*
	* @access 	protected
	* @return 	<void>
	*/
	protected function listCommands()
	{

	}
}