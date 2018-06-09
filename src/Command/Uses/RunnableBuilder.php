<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Console\Command\Uses\RunnableBuilder
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

namespace Kit\Console\Command\Uses;

use StdClass;
use RuntimeException;

trait RunnableBuilder
{

	/**
	* Creates a new runnable object.
	*
	* @param 	$runnable <StdClass>
	* @access 	protected
	* @return 	<void>
	*/
	protected function buildRunnable(StdClass $runnable)
	{
		$template = __DIR__ . '/template' . '/RunnableTemplate.phx';
		if (!file_exists($template)) {
			$this->env->sendOutput(sprinf('Template file [%s] does not exist', $template), 'red');
			exit;
		}

		$content = file_get_contents($template);
		$hasLang = $this->hasLang($content);
		$hasName = $this->hasName($content);
		$hasId = $this->hasId($content);
		$hasRunnableCommands = $this->hasRunnableCommands($content);

		if (!$hasLang || !$hasName || !$hasId || !$hasRunnableCommands) {
			$this->env->sendOutput('Cannot build runnable from invalid template.', 'red');
			exit;
		}

		$runnableCommands = '[]';
		$location = $this->cmd->getConfigOpt('runnables_path');

		$replaces = [
			'[phx:lang]' => '<?php',
			'[phx:name]' => $runnable->name,
			'[phx:id]' => $runnable->id,
			'[phx:commands]' => $runnableCommands,
		];

		$runnableContent = str_replace(
			array_keys($replaces),
			array_values($replaces),
			$content
		);

		if ($runnable->location !== '') {
			$location = $runnable->location;
		}

		$fileLocation = $location . '/' . $runnable->name . '.php';
		file_put_contents($fileLocation, $runnableContent);

		return true;
	}

	/**
	* Checks if template has [phx:lang] tag.
	*
	* @param 	$content <String>
	* @access 	protected
	* @return 	<Boolean>
	*/
	protected function hasLang(String $content) : Bool
	{
		if (preg_match("/\[phx\:lang\]/", $content)) {
			return true;
		}

		return false;
	}

	/**
	* Checks if template has [phx:name] tag.
	*
	* @param 	$content <String>
	* @access 	protected
	* @return 	<Boolean>
	*/
	protected function hasName(String $content) : Bool
	{
		if (preg_match("/\[phx\:name\]/", $content)) {
			return true;
		}

		return false;
	}

	/**
	* Checks if template has [phx:id] tag.
	*
	* @param 	$content <String>
	* @access 	protected
	* @return 	<Boolean>
	*/
	protected function hasId(String $content) : Bool
	{
		if (preg_match("/\[phx\:id\]/", $content)) {
			return true;
		}

		return false;
	}

	/**
	* Checks if template has [phx:commands] tag.
	*
	* @param 	$content <String>
	* @access 	protected
	* @return 	<Boolean>
	*/
	protected function hasRunnableCommands(String $content) : Bool
	{
		if (preg_match("/\[phx\:commands\]/", $content)) {
			return true;
		}

		return false;
	}

}