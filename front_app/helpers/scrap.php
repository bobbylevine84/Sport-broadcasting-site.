<?php 
$main = 'http://www.fodors.com';

$tagName = "div";
$attrName = "id";
$attrValue = "yui_3_10_1_1_1386219202259_137";
$attrName_class = "class";
$attrValue_class = "dests-by-region clearfix";

$xml = file_get_contents("http://www.fodors.com/world/");

$dom = new DOMDocument;
$doc = new DOMDocument;
@$dom->loadHTML($xml);

$title = array();

$xp = new DOMXPath($dom);

$div_find = $xp->query("//$tagName" .'[@' .$attrName_class. "='$attrValue_class']");

//print_r($div_find); exit;

foreach($div_find as $div)
{
	foreach($div->getElementsByTagName('ul') as $ul)
	{
		foreach($ul->getElementsByTagName('li') as $li)
		{
			foreach($li->getElementsByTagName('a') as $a)
			{
				$single['name'] = $a->nodeValue;
				$single['link'] = $a->getAttribute('href');
				$title[] = $single;
			}
		}
	}
}

echo "<pre>";
print_r($title);