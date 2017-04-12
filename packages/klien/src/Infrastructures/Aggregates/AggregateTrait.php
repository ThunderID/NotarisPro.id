<?php

namespace TKlien\Infrastructures\Aggregates;

use TKlien\Infrastructures\Exceptions\IndirectModificationException;

/**
 * Trait Link list
 *
 * Digunakan untuk initizialize link list mode
 *
 * @package    TKlien
 * @author     C Mooy <chelsymooy1108@gmail.com>
 */
trait AggregateTrait 
{
	public function __set ($name, $value)
	{
		if(!str_is('*_at', strtolower($name)))
		{
			throw new IndirectModificationException($name, 1);
		}
	}
}