<?php
namespace App\Notifications\Markup\Tasks;
use App\Notifications\Markup\MailMarkup;
use App\Models\Task;
use App\Models\Setting;

class TaskUpdatedMarkup extends MailMarkup{

    public function __construct(Task $task, $by){
        $this->parent = $task->parent;
        $this->column = $task->column;
        $this->task = $task;
        $this->by = $by;
        $this->redirectSlug = '/app-redirect?ref=automatedEmail:TaskUpdated&to=';
    }

    public function from(){
        return 'task-watcher@timatik.com';
    }

    protected function progressUpdatedMarkup(){
        return $this->mailMessage()
            ->greeting('There were changes to "' . $this->parent->name . '"')
            ->line('The "' . $this->task->name . '" '.$this->task->type->name.' was updated to the column "' . $this->column->value . '".')
            ->action('See Changes', url($this->redirectSlug.'tasks/' . $this->parent->id . '/manage'));
    }

    protected function dataUpdatedMarkup(){
        return $this->mailMessage()
            ->greeting('There was data updated to "' . $this->task->name . '" by ' . $this->by->name .  '.')
            ->action('See Changes', url($this->redirectSlug.'tasks/' . $this->task->id . '/manage'));
    }

    protected function addColumnMarkup(){
        $line = "";
        foreach($this->task->columns as $key => $column){
            $pipe = $key != (count($this->task->columns) - 1) ? " | " : "";
            $line .= " $column->value " . $pipe;
        }
        return $this->mailMessage()
            ->greeting($this->by->name . ' just added a column to "' . $this->task->name . '" ' . $this->task->type->name . '.')
            ->line('Current Columns: ')
            ->line($line)
            ->action('See Changes', url($this->redirectSlug.'tasks/' . $this->task->id . '/manage'));
            return $this->mailMessage()
                ->line('Updated column');
    }

    protected function removeColumnMarkup(){
        $line = "";
        foreach($this->task->columns as $key => $column){
            $pipe = $key != (count($this->task->columns) - 1) ? " | " : "";
            $line .= " $column->value " . $pipe;
        }
        return $this->mailMessage()
            ->greeting($this->by->name . ' just removed a column from "' . $this->task->name . '" ' . $this->task->type->name . '.')
            ->line('Current Columns: ')
            ->line($line)
            ->action('See Changes', url($this->redirectSlug.'tasks/' . $this->task->id . '/manage'));
    }

    protected function unsubscribedFromTaskMarkup(){
        return $this->mailMessage()
            ->greeting('You were just unsubscribed from "' . $this->task->name . '" ' . $this->task->type->name . ' by ' . $this->by->name . '.')
            ->action('See Task', url($this->redirectSlug.'tasks/' . $this->task->id . '/manage'));
    }

    protected function subscribedToTaskMarkup(){
        return $this->mailMessage()
            ->greeting('You were just subscribed to get notifications from "' . $this->task->name . '" ' . $this->task->type->name . ' by ' . $this->by->name . '.')
            ->action('See Task', url($this->redirectSlug.'tasks/' . $this->task->id . '/manage'));
    }


}