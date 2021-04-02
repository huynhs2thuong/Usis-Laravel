<?php

namespace Jollibee\Image\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ThumbnailSquare implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(400, 400, function ($constraint) {
		    $constraint->upsize();
		})->encode('jpg');
    }
}
