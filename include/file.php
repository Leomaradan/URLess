<?php

class FileDriver implements AccessDriver {
	function openId($id, $create = false) {
		$dir = strtolower(substr($id,0,2));
		$file = strtolower(substr($id,0,4));

		if(file_exists('./data/' . $dir . '/' . $file . '.php')) {

			include './data/' . $dir . '/' . $file . '.php';

			
			if(isset($links[$id])) {
				return $links[$id];
			}
		} elseif($create) {
			if(!file_exists('./data/' . $dir . '/')) {
				mkdir('./data/' . $dir . '/');
			}
			
			file_put_contents('./data/' . $dir . '/' . $file . '.php', '<?php ' . PHP_EOL . PHP_EOL);
		}	
		
		return false;
	}

	function appendToId($id,$url) {
		$dir = strtolower(substr($id,0,2));
		$file = strtolower(substr($id,0,4));
		
		$url = urlencode(utf8_encode($url));
		
		return file_put_contents('./data/' . $dir . '/' . $file . '.php', '$links[\''.$id.'\'] = \''.$url.'\';' . PHP_EOL, FILE_APPEND);
	}
	
	function getId($url) {
		// Unimplemented in File driver, need to generate an index
		return false;
	}
}

?>