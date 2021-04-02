<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    use MultiLanguage;

    protected $fillable = ['title', 'from', 'to', 'content', 'active', 'form_id'];

    protected $multilingual = ['content'];


    public function forms() {
        return $this->belongsTo('App\Form')->orderBy('forms.id', 'desc');
    }
}
