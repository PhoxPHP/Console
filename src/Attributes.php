<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Console\Attributes
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

abstract class Attributes
{
	const INFO = 'attribute_type_info';
	const ERROR = 'attribute_type_error';

	/* colors */
	const COLOR_GREEN = "\033[32m";
	const COLOR_RED = "\033[31m";
	const COLOR_YELLOW = "\033[33m";
	const COLOR_BLUE = "\033[34m";
	const COLOR_MAGENTA = "\033[35m";
	const COLOR_CYAN = "\033[36m";
	const COLOR_WHITE = "\033[37m";

	/* background colors */
	const BG_BLACK = "\033[40m";
	const BG_RED = "\033[41m";
	const BG_GREEN = "\033[42m";
	const BG_YELLOW = "\033[43m";
	const BG_BLUE = "\033[44m";
	const BG_MAGENTA = "\033[45m";
	const BG_CYAN = "\033[46m";
}