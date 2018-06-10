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

use StdClass;
use RuntimeException;
use Kit\Console\Command;
use Kit\Console\Environment;
use Kit\Console\Contract\Runnable;
use Kit\Console\Command\Uses\RunnableBuilder;

class Help implements Runnable
{

	use RunnableBuilder;

	/**
	* @var 		$env
	* @access 	protected
	*/
	protected	$env;

	/**
	* @var 		$cmd
	* @access 	protected
	*/
	protected 	$cmd;

	/**
	* {@inheritDoc}
	*/
	public function __construct(Environment $env, Command $cmd)
	{
		$this->env = $env;
		$this->cmd = $cmd;
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
		$arguments = [];

		if (!empty($argumentsList)) {
			$arguments = $argumentsList;
		}

		if (!empty($arguments)) {
			switch ($arguments[0]) {
				case 'list-runnables':
					return $this->listRunnables();
					break;
				case 'create-runnable':
					return $this->createRunnable();
					break;
				case 'list-runnable-commands':
					return $this->listRunnableCommands($arguments[1]);
					break;
				case 'help':
					return $this->displayHelpInformation();
					break;
			}
		}
	}

	/**
	* {@inheritDoc}
	*/
	public function runnableCommands() : Array
	{
		return [
			'list-runnables' => ':none',
			'create-runnable' => ':none',
			'list-runnable-commands' => 1
		];
	}

	/**
	* Lists all registered runnables id.
	*
	* @access 	protected
	* @return 	<void>
	*/
	protected function listRunnables()
	{
		$commands = array_values(Command::getRegisteredCommands());
		$format = "| %8.60s | %-50.30s\n";
		
		printf($format, "id", "class");
		$this->env->sendOutput('-----------------------------------');
		foreach($commands as $runnable) {
			printf($format, $runnable->getId(), get_class($runnable));
			$this->env->sendOutput('-----------------------------------');
		}
	}

	/**
	* Creates a new runnable class.
	*
	* @param 	$arguments <Array>
	* @access 	protected
	* @return 	<void>
	*/
	protected function createRunnable()
	{
		$runnable = new StdClass();
		$response = $this->cmd->question('1. Runnable class name? [required]');
		if (strlen($response) < 3) {
			return $this->env->sendOutput('runnable class name is required.', 'red');
		}
		$runnable->name = rtrim($response);

		$response = $this->cmd->question('2. Runnable class location? [optional]');
		if (strlen($response) < 3) {
			$response = null;
		}

		$response = trim($response);
		if ($response !== '' && !is_dir($response)) {
			return $this->cmd->error(sprintf('[%s] is not a directory', $response));
		}
		$runnable->location = $response;

		$response = $this->cmd->question('3. Runnable class namespace? [optional]');
		$runnable->namespace = rtrim($response);

		$response = $this->cmd->question('4. Runnable command id? [required]');
		if (strlen($response) < 3) {
			return $this->cmd->error('runnable command id is required.');
		}
		$runnable->id = rtrim($response);

		$response = $this->cmd->question('5. List of runnable commands? [optional] [e:g create-route:4(number of arguments)]');
		$runnable->runnableCommands = rtrim($response);

		$this->env->sendOutput('Creating runnable...' . $this->env->addNewLine(), 'green');
		if($this->buildRunnable($runnable)) {
			return $this->env->sendOutput('Runnable class has been created.', 'green');
		}

		return $this->cmd->error('Failed to create runnable class.');
	}

	/**
	* Lists commands available in a runnable object.
	*
	* @param 	$runnableId <String>
	* @access 	protected
	* @return 	<void>
	*/
	protected function listRunnableCommands(String $runnableId)
	{
		if (!Command::hasCommand($runnableId)) {
			$this->cmd->error(sprintf('[%s] is not a valid runnable id', $runnableId));
		}

		$runnable = Command::getCommandById($runnableId);
		$commands = $runnable->runnableCommands();

		$format = "| %8.60s | %-50.30s\n";
		
		foreach($commands as $command => $argument) {
			printf($format, $command, $argument);
			$this->env->sendOutput('-----------------------------------');
		}
	}

	/**
	* Displays cli help information.
	*
	* @access 	protected
	* @return 	<void>
	*/
	protected function displayHelpInformation()
	{
		$this->env->sendOutput('PhoxPHP Command Line Interface help.', 'green');
		$this->env->sendOutput('Usage:'. $this->env->addTab() . 'php console [command id] [...arguments]');
		$this->env->sendOutput($this->env->addTab() . 'E.g: ' . 'php console help list-commands' . $this->env->addNewLine());
		$this->env->sendOutput($this->env->addTab() . 'list-runnables: ' . $this->env->addTab() . 'Lists all available runnables id');
		$this->env->sendOutput($this->env->addTab() . 'create-runnable: ' . $this->env->addTab() . 'Creates a new runnable class');
		$this->env->sendOutput($this->env->addTab() . 'list-runnable-commands: ' . 'Lists all commands available in a runnable object');
	}
}