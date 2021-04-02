<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Mail as Mailer;
use App\Heplers;
use Illuminate\Support\Collection;

class Notification extends Model
{
    public $guarded = ['id'];

    public $casts = ['rules' => 'object'];

    public $supportOperators = ['=', '>', '<', '>=', '<='];

    # Hàm check điều kiện và gửi mail
    public function notify(FormData $data, $sender = Null) {
        $rules = $this->rules;
        $checked = true;
        // check an and group
        foreach ($rules as $key => $andGroup) {
            $and = true;
            // foreach ($orGroup as $key => $value) {
            $left = $data->getValue($key);
            $operator = $andGroup->operator;
            $right = $andGroup->value;
            eval("\$and &= (\$left {$operator} \$right);");
            // }
            if ($and == false) {
                $checked = false;
                break;
            }
        }
        # Kiểm tra điều kiện để gửi notification
        if ($checked) {
            $mail = $this->successMail()->first();
        } else {
            $mail = $this->failMail()->first();
        }

        if ($mail) {
            # Set Form Mail Setting Before Send
            $form = $this->forms->count() == 0 ? null : $this->forms[0];
            if ($form && $form->validateMailSetting()) {
                Config::set('mail.host', $form->mail->host);
                Config::set('mail.port', $form->mail->port);
                Config::set('mail.username', $form->mail->username);
                Config::set('mail.password', $form->mail->password);
                Config::set('mail.from', [
                    'address' => $form->mail->username,
                    'name' => $form->name
                ]);
            }
            # Send mail
            Mailer::raw(convertMail($mail->content, $data), function ($message) use ($mail, $data) {
                $message->to(collect($mail->to)->map(function ($email) use ($data) {    
                    return convertMail($email, $data);
                })->all());
                $message->cc(collect($mail->cc)->map(function ($email) use ($data) {
                    return convertMail($email, $data);
                })->all());
                $message->bcc(collect($mail->bcc)->map(function ($email) use ($data) {
                    return convertMail($email, $data);
                })->all());
                $message->subject(convertMail($mail->subject, $data));
            });
        }
    }

    public function check($rule, $data) {

    }

    # Relations
    public function forms() {
        return $this->belongsToMany('App\Form', 'form_notification', 'notification_id', 'form_id');
    }

    public function setSuccessMailAttribute($mail) {
        $mail['used'] = false;
        if (isset($mail['used'])) {
            $mail['used'] = true;
        }
        if ($this->correct_mail) {
            $this->successMail()->update($mail);
        } else {
            $mail = \App\Mail::create($mail);
            $this->successMail()->associate($mail);
        }
    }

    public function successMail() {
        return $this->belongsTo('App\Mail', 'correct_mail', 'id');
    }

    # Get and set wrapper about rules
    public function getRuleAttribute() {
        $rules = (array)$this->rules;
        foreach ($rules as $key => $rule) {
            $rules[$key] = (array) $rule;
            $rules[$key]['name'] = $key;
        }
        $rules = array_values($rules);
        return $rules;
    }

    public function setRuleAttribute($value) {
        $rules = [];
        foreach ($value as $item) {
            $rule = [];
            if (isset($item['operator'])) {
                $rule['operator'] = $item['operator'];
            }
            if (isset($item['value'])) {
                $rule['value'] = $item['value'];
            }
            $rules[$item['name']] = $rule;
        }
        $this->rules = $rules;
    }

    public function setFailMailAttribute($mail) {
        $mail['used'] = false;
        if (isset($mail['used'])) {
            $mail['used'] = true;
        }
        if ($this->incorrect_mail) {
            $this->failMail()->update($mail);
        } else {
            $mail = \App\Mail::create($mail);
            $this->failMail()->associate($mail);
        }
    }
    public function failMail() {
        return $this->belongsTo('App\Mail', 'incorrect_mail', 'id');
    }
}
