<?php

namespace EventManagementSystem\App\Hooks\Handlers;

use EventManagementSystem\App\App;

use EventManagementSystem\App\Hooks\Handlers\EmsCustomPost;

class CPTHandler
{
	/*
	* Add all Custom Post Type classes here to
	* register all of your Custom Post Types.
	*/

	protected $customPostTypes = [
		// ExampleCPT::class
		EmsCustomPost::class
	];

	public function registerPostTypes()
	{
		foreach ($this->customPostTypes as $cpt) {
			App::make($cpt)->registerPostType();
		}
	}
}
