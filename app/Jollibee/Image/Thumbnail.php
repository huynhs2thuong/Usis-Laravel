<?php

namespace Jollibee\Image\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Thumbnail implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(500, 300, function ($constraint) {
		    $constraint->upsize();
		})->encode('jpg');
    }
}
