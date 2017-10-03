<?php

namespace Thunderlabid\Akta\Listeners;

///////////////
// Exception //
///////////////
use Thunderlabid\Akta\Exceptions\AppException;


class ParseTextParagraf
{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle event
	 * @param  UserCreating $event [description]
	 * @return [type]             [description]
	 */
	public function handle($event)
	{
		$model 	= $event->data;
		$model->paragraf 	= $this->parse_text($model->paragraf);
	}

	private function parse_text($paragraf)
	{
		if(!is_array($paragraf)){
			$pattern_c		= "/\/t.*?<h.*?>(.*?)<\/h.*?>|\/t.*?<p.*?>(.*?)<\/p>|\/t.*?(<(ol|ul).*?><li>(.*?)<\/li>)|\/t.*?(<li>(.*?)<\/li><\/(ol|ul)>)|<h.*?>(.*?)<\/h.*?>|<p.*?>(.*?)<\/p>|(<(ol|ul).*?><li>(.*?)<\/li>)|(<li>(.*?)<\/li><\/(ol|ul)>)|<br\/>|<\/br>/i";

			preg_match_all($pattern_c, $paragraf, $out, PREG_PATTERN_ORDER);

			foreach ($out[0] as $key => $value) 
			{
				$new_paragraph[]	= ['konten' => $value];
			}

			return $new_paragraph;
		}
		
		return $paragraf;
	}
}