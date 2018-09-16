<?php
namespace App\Notifications\Markup;
use Illuminate\Notifications\Messages\MailMessage;

class MailMarkup {

    public function markup($type){
        return call_user_func([$this, $type.'Markup']);
    }

    protected function mailMessage(){
        return new MailMessage;
    }

}