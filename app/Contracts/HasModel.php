<?php 

namespace App\Contracts;

interface HasModel
{
	/**
	 * Belongs to one model.
	 *
	 * @return mixed
	 */
	public function model();
}