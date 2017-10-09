<?php

namespace Thunderlabid\Akta\Listeners;

///////////////
// Exception //
///////////////
use Thunderlabid\Akta\Exceptions\AppException;


class ParseDataAkta
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
		$model->data 	= $this->parse_text($model->paragraf, $model->data);
	}

	private function parse_text($paragraf, $data)
	{
		if(!is_array($paragraf)){
			$pattern_span	= '/<span class="text-mention.*?" data-mention="@(.*?)@">(.*?)<\/span>/i';
			if (preg_match_all($pattern_span, $paragraf, $span) && count($span[1])) 
			{
				$new_data 	= [];
				foreach ($span[1] as $key => $value) {
					$value 	= str_replace('.', '[dot]', $value);
					$new_data[$value] 	= $span[2][$key];
				}

				return $new_data;
			}
			
			return $data;
		}
		
		return $data;
	}
}