<?php
namespace App\Reports;
use App\Repositories\ProjectReportRepository;
use App\Models\Task;
class ProjectReport extends Report {
    public static $name = "Report Name";
    public function __construct($arg){
        $this->arg = $arg;
        /**
         * @param Model $model the model that the repository is responsable for
         * @param Array $arg array of arguments used in the request
         */
        $this->repository = new ProjectReportRepository(Task::class, $arg);
    }

    public function format(){
        return [
                'label' => 'Column Breakdown',
                'layouts' => [
                    [
                        'name' => 'Bar Chart',
                        'chart' => 'ColumnChart'
                    ],[
                        'name' => 'Pie Chart',
                        'chart' => 'PieChart'
                    ]
                ],
                'data' => $this->breakTaskIntoColumns()
        ];
    }

    public function breakTaskIntoColumns(){
        $children = $this->repository->recursivGetChildrenOfTaskByType($this->repository->getSpecifiedModel(),'task');
        $columns = [];
        $results = [
            ['Status', 'Task Count']
        ];
        foreach($children as $child){
            if($child->column){
                $columns[] = $child->column->value;
            }
        }
        foreach(array_unique($columns) as $column){
            $results[] = [
                $column, $children->where('column.value', $column)->count()
            ];
        }
        return $results;
    }

}        
