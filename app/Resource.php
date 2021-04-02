<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    const NO_SRC        = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

    public $timestamps  = false;

    protected $fillable = ['type', 'name'];

    protected $root     = 'uploads';

    protected $sizes    = ['square', 'thumbnail', 'large'];

    public function getPathAttribute() {
        if (empty($this->type)) return $this->name;
        else return $this->type . '/' . $this->name;
    }

    public function getFullAttribute() {
        return url($this->root . '/' . $this->path);
    }

    public function getAttribute($key) {
        if (in_array($key, $this->sizes)) return route('imagecache', [$key, $this->path]);
        return parent::getAttribute($key);
    }
}