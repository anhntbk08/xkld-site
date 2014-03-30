<?php

require_once 'Zend/Controller/Action.php';

class BaseController extends Zend_Controller_Action {

	protected $result;
	protected $callback;

	public function preDispatch() {
		$this->getResponse()
		->setHeader('Content-Type', 'application/json; charset=UTF-8');
	}

	public function postDispatch() {
		$this->result['time'] = time();
		$this->_helper->getHelper('viewRenderer')->setNoRender(true);
		$return = json_encode($this->result);
		
		if ($this->_getParam('pretty') == "true") {
			$return = $this->prettyPrintJson($return);
		}
		echo $return;
	}

	/**
	 * Indents a flat JSON string to make it more human-readable.
	 *
	 * @param string $json The original JSON string to process.
	 *
	 * @return string Indented version of the original JSON string.
	 */
	public function prettyPrintJson($json) {
		$result      = '';
		$pos         = 0;
		$strLen      = strlen($json);
		$indentStr   = '    ';
		$newLine     = "\n";
		$prevChar    = '';
		$outOfQuotes = true;

		for ($i=0; $i<=$strLen; $i++) {

			// Grab the next character in the string.
			$char = substr($json, $i, 1);

			// Are we inside a quoted string?
			if ($char == '"' && $prevChar != '\\') {
				$outOfQuotes = !$outOfQuotes;

				// If this character is the end of an element,
				// output a new line and indent the next line.
			} else if(($char == '}' || $char == ']') && $outOfQuotes) {
				$result .= $newLine;
				$pos --;
				for ($j=0; $j<$pos; $j++) {
					$result .= $indentStr;
				}
			}

			// Add the character to the result string.
			$result .= $char;

			// If the last character was the beginning of an element,
			// output a new line and indent the next line.
			if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
				$result .= $newLine;
				if ($char == '{' || $char == '[') {
					$pos ++;
				}

				for ($j = 0; $j < $pos; $j++) {
					$result .= $indentStr;
				}
			}

			$prevChar = $char;
		}

		return $result;
	}
}
?>