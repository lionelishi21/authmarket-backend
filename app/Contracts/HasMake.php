<?php 

namespace App\Contracts;

interface HasMake
{
	/**
	 * Belongs to one make.
	 *
	 * @return mixeds
	 */
	public function make();
}