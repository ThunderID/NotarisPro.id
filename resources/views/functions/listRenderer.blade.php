<?php
	function listRenderer($txt){
		$data = [];

		if (strpos($txt, '<ol>') !== false) {
			$data['open'] 	= '<ol>';
			$data['close'] 	= null;
			$data['text'] 	= substr_replace($txt, '', strpos($txt, '<ol>'), strlen('<ol>'));
		}else if (strpos($txt, '</ol>') !== false) {
			$data['open'] 	= null;
			$data['close'] 	= '</ol>';
			$data['text'] 	= substr_replace($txt, '', strpos($txt, '</ol>'), strlen('</ol>'));
		}else if (strpos($txt, '<ul>') !== false) {
			$data['open'] 	= '<ul>';
			$data['close'] 	= null;
			$data['text'] 	= substr_replace($txt, '', strpos($txt, '<ul>'), strlen('<ul>'));
		}else if (strpos($txt, '</ul>') !== false) {
			$data['open'] 	= null;
			$data['close'] 	= '</ul>';
			$data['text'] 	= substr_replace($txt, '', strpos($txt, '</ul>'), strlen('</ul>'));
		}else{
			$data['open'] 	= null;
			$data['close'] 	= null;
			$data['text'] 	= $txt;
		}

		// dd($data);
		return $data;
	}
?>
