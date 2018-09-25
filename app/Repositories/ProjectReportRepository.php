<?php
namespace App\Repositories;
use App\Models\Task;

class ProjectReportRepository extends Repository{

    public function collectAllChildrenOfTaskByType(String $type){
        return $this->getChildTasksByType($this->getSpecifiedModel(), $type);
    }

    public function getChildTasksByType(Task $task, String $type){
            return $task->children()->whereHas('type', function($t) use ($type){
                $t->where('slug', $type);
            })->get();
    }

    public function recursivGetChildrenOfTaskByType($task, $type){
        $children = $task->children()->with('children')->get();
            foreach($children as $child){
                $children->push($this->recursivGetChildrenOfTaskByType($child, $type));
            }
            $results = $children->flatten(1);
            $final = collect([]);
            foreach($results as $result){
                if($result->type->slug == $type){
                    $final->push($result);
                }
            }
            return $final;
    }

    public function getTasksInColumn($columnName){
        return $this->getSpecifiedModel()->children()->whereHas('column', function($column) use ($columnName){
            $column->where('value', $columnName);
        })->get();
    }

}  
