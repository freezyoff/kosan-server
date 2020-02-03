<?php

namespace App\Kosan\Models\Relations;

use Illuminate\Database\Eloquent\Relations\Pivot;

use App\Kosan\Models\Contracts\RoomAccessibilityTrait;

class RoomAccessibility extends Pivot
{
	public $incrementing = true;
	
	use RoomAccessibilityTrait;
}
