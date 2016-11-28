<?php

namespace App\Console\Commands;

use App\Elegant;
use Illuminate\Console\Command;
use DB;

class MakeCrudCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'make:crud {modelName : the name of the Model} {--field=*} {--fillable=*}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Makes a UI based on a table.';

	/**
	 * short cut to the table name
	 *
	 * @var string
	 */
	protected $tableName;

	/**
	 * short cut to the model name
	 *
	 * @var string
	 */
	protected $modelName;

	/**
	 * short cut to the full model path
	 *
	 * @var string
	 */
	protected $fullModelPath;

	protected $fields;

	protected $fillable;

	/**
	 * Create a new command instance.
	 *
	 * @internal param String $name
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$this->fullModelPath = $this->argument('modelName');
		$modelPathArray = explode('\\', $this->fullModelPath);
		$this->modelName = array_pop($modelPathArray);
		/** @var Elegant $model */
		$model = new $this->fullModelPath;
		$this->fillable = $this->option('fillable');
		if (empty($this->fillable)){
			$this->fillable = $model->getFillable();
		}
		$this->tableName = $model->getTable();
		$this->fields = $this->transformToFields($this->option('field'));
		if (empty($this->fields)){
			$this->fields = (Array) DB::select('DESCRIBE ' . $this->get_table_name());
		}
		$this->addRoute();
		$this->addController();
		$this->addBlade();
		$this->addJS();
	}

	function transformToFields($array){
		$ret = [];
		foreach ($array as $field){
			$fieldObject['Field'] = $field;
			$fieldObject['Type'] = 1;
			$ret [] = (Object) $fieldObject;
		}
		return $ret;
	}
	/**
	 * add the Controller file
	 *
	 * @return mixed
	 */
	public function addJS()
	{
		$fillable = $this->fillable;
		$jsFillable= '';
		foreach ($this->fields as $field){
			$jsFillable .= "'{$field->Field}':'',";
			$fields [] =  $field->Field;
		}

		$ClassName = $this->getClassName();
		$table_name = $this->get_table_name();
		ob_start();
		include(__DIR__ . '/stubs/' . 'crud.stub.js.php');
		$out1 = ob_get_contents();
		ob_end_clean();

		$jsPath = base_path('public/js/');
		if (!is_dir($jsPath)){
			mkdir($jsPath);
		}
		file_put_contents(
			$jsPath . $this->getClassName() . '.js',
			$out1/*,
			FILE_APPEND*/
		);
	}

	/**
	 * add the Controller file
	 *
	 * @return mixed
	 */
	public function addBlade()
	{
		file_put_contents(
			base_path('resources/views/manage-' . $this->get_table_name() . '.blade.php'),
			$this->getStub('crud.stub.blade.php')/*,
			FILE_APPEND*/
		);
	}

	/**
	 * add the Controller file
	 *
	 * @return mixed
	 */
	public function addController()
	{
		$controllerPath = app_path('Http/Controllers/Crud/');
		if (!is_dir($controllerPath)){
			mkdir($controllerPath);
		}
		file_put_contents(
			$controllerPath . $this->getClassName() . 'Controller.php',
			$this->getStub('crudController.stub.php')/*,
			FILE_APPEND*/
		);
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function addRoute()
	{
		try
		{
			file_put_contents(
				base_path('routes/web.php'),
				$this->getStub('route.stub'),
				FILE_APPEND
			);
		} catch (\Exception $ex)
		{
			dd($ex);
		}
	}

	/**
	 * Get the stub file for the generator.
	 *
	 * @param $stubName
	 * @return string
	 */
	protected function getStub($stubName)
	{
		$a = str_replace(
			'{{ClassName}}',
			$this->getClassName(),
			file_get_contents(__DIR__ . '/stubs/' . $stubName )
		);
		$b = str_replace(
			'{{fullModelPath}}',
			$this->fullModelPath,
			$a
		);
		$c = str_replace(
			'{{modelMap}}',
			json_encode($this->fields),
			$b
		);
		$d = str_replace(
			'{{fillableMap}}',
			json_encode($this->fillable),
			$c
		);
		return str_replace(
			'{{table_name}}',
			$this->get_table_name(),
			$d
		);
	}

	private function getClassName()
	{
		return $this->modelName;
	}

	private function get_table_name()
	{
		return $this->tableName;
	}
}
