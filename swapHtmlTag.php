/**
 * This function will grab html dom element(s) from the passed in html file
 * and will look for a specific classname in the element for targeting. Once elements are
 * targeted they are replaced by the new element created with the new element tag
 *
 * author: sebastian manunta
 *
 * @param $htmlFile
 * @param $className
 * @param $elementTag
 * @param $newElementTag
 * @return string
 */
function swapHtmlTag($htmlFile, $className, $elementTag, $newElementTag){
	$dom = new DOMDocument;
	$dom->preserveWhiteSpace = false;
	$dom->loadHTML($htmlFile);

	$els = $dom->getElementsByTagName($elementTag);
	for ($i = $els->length; --$i >= 0; ) {
		$el = $els->item($i);
		if(strpos($el->getAttribute('class'),trim($className)) !== false){

			//var_dump($el->getAttribute('class'));
			$new_element = $dom->createElement($newElementTag,$el->textContent);
			foreach ($el->attributes as $key => $attr){
				if($attr->name != 'class')
				{
					$attr_name = $attr->name;
					$attr_value = $attr->value;
				}else{
					$attr_name = $attr->name;
					$attr_value = str_replace(trim($className),'',$attr->value);
				}

				$new_element->setAttribute($attr_name,$attr_value);
			}
			$el->parentNode->replaceChild($new_element,$el);

		}

	}
	$html = $dom->saveHTML();
	return $html;
}
