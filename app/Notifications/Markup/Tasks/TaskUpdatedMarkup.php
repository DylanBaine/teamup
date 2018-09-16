<?php
namespace App\Notifications\Markup\Tasks;
use App\Notifications\Markup\MailMarkup;
use App\Models\Task;
use App\Models\Setting;

class TaskUpdatedMarkup extends MailMarkup{

    public function __construct(Task $task){
        $this->parent = $task->parent;
        $this->column = $task->column;
        $this->task = $task;
    }

    protected function progressUpdatedMarkup(){
        return $this->mailMessage()
            ->greeting('There were changes to "' . $this->parent->name . '"')
            ->line('The "' . $this->task->name . '" '.$this->task->type->name.' was updated to the column "' . $this->column->value . '".')
            ->action('See Changes', url('/app#/tasks/' . $this->parent->id . '/manage'));
    }

    protected function dataUpdatedMarkup(){
        return $this->mailMessage()
            ->greeting('There was data updated to "' . $this->task->name . '" by ' . user('name') .  '.')
            ->action('See Changes', url('/app#/tasks/' . $this->task->id . '/manage'));
    }

    protected function addColumnMarkup(){
        $line = "";
        foreach($this->task->columns() as $column){
            $line .= " $column->value ";
        }
        return $this->mailMessage()
            ->greeting('A new column was just added to "' . $this->task->name . '" ' . $this->task->type->name . ' by ' . user('name'))
            ->line('Current Columns: ')
            ->line($line)
            ->action('See Changes', url('/app#/tasks/' . $this->task->id . '/manage'));
    }

    protected function removeColumnMarkup(){
        $line = "";
        foreach($this->task->columns() as $column){
            $line .= " $column->value ";
        }
        return $this->mailMessage()
            ->greeting('A column was just removed from "' . $this->task->name . '" ' . $this->task->type->name . ' by ' . user('name') . '.')
            ->line('Current Columns: ')
            ->line($line)
            ->action('See Changes', url('/app#/tasks/' . $this->task->id . '/manage'));
    }

    protected function unsubscribedFromTaskMarkup(){
        return $this->mailMessage()
            ->greeting('You were just unsubscribed from "' . $this->task->name . '" ' . $this->task->type->name . ' by ' . user('name') . '.')
            ->action('See Task', url('/app#/tasks/' . $this->task->id . '/manage'));
    }

    protected function subscribedToTaskMarkup(){
        return $this->mailMessage()
            ->greeting('You were just subscribed to get notifications from "' . $this->task->name . '" ' . $this->task->type->name . ' by ' . user('name') . '.')
            ->action('See Task', url('/app#/tasks/' . $this->task->id . '/manage'));
    }


}