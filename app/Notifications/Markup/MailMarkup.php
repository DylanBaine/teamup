<?php
namespace App\Notifications\Markup;
use Illuminate\Notifications\Messages\MailMessage;

abstract class MailMarkup {

    public abstract function from();
    
    public function markup($type){
        return call_user_func([$this, $type.'Markup']);
    }

    protected function mailMessage(){
        return (new MailMessage)->from($this->from());
    }

}