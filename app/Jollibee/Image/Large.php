<?php

namespace Jollibee\Image\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Large implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->resize(1280, null, function ($constraint) {
		    $constraint->aspectRatio();
		    $constraint->upsize();
		})->encode('jpg');
    }
}
