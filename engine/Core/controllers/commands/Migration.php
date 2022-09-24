<?php

use Base\Helpers\TraverseClassFile;
use Base\Controllers\ConsoleController;
use Base\Migrations\Migration as Migrate;

class Migration extends ConsoleController
{

	/**
	 * Migrations Enabled Constant
	 *
	 * @var string
	 */
	private const ENABLED = MIGRATION_ENABLED;

	/**
	 * Table Constant
	 *
	 * @var string
	 */
	private const TABLE = MIGRATION_TABLE;
	
	/**
	 * Path Constant
	 *
	 * @var string
	 */
	private	const PATH = MIGRATION_PATH;

	/**
	 * Descending Constant
	 *
	 * @var string
	 */
	private const DESC = 'DESC';

	/**
	 * Ascending Constant
	 *
	 * @var string
	 */
	private const ASC = 'ASC';

	/**
	 * Migration files
	 *
	 * @var array
	 */
	private $migrationFiles = [];

	/**
	 * Previous Migrations
	 *
	 * @var string
	 */
	private $previousMigration = null;

	/**
	 * Default Database
	 *
	 * @var string
	 */
	private $useDb = 'default';

	/**
	 * Migration instance
	 *
	 * @var object
	 */
	private $migration;

	public function __construct()
	{
		parent::__construct();

		$this->onlydev();

		$this->use->database();
		$this->use->dbforge();

		$this->migration = (new Migrate);

		$this->migrationRequirements();
	}

    /**
     * Migration Requirements
     *
     * @return void
     */
	private function migrationRequirements() 
	{
		if (!self::ENABLED) {
			echo $this->error("Migrations is currently disabled, please enable it to continue...");
			exit;
		}

		try {

			$table = self::TABLE;

			if (!$this->db->table_exists($table)) {

				$this->dbforge->add_field([
					'id' => [
						'type' => 'INT',
						'unsigned' => true,
						'auto_increment' => true,
						'constraint' => 11,
					],
					'migration' => [
						'type' => 'VARCHAR(256)'
					],
					'batch' => [
						'type' => 'INT',
						'constraint' => 11,
					],
					'run_at' => [
						'type' => 'timestamp'
					]
				])
				->add_key('id', true)
				->add_key('migration')
				->create_table($table);

			} else {

				$previousMigration = $this->db->order_by('migration', self::DESC)->get($table, 1)->result();

				$this->previousMigration = ($previousMigration) 
					? $previousMigration[0]->migration
					: null;
			}

			if ( ! file_exists($path = self::PATH)) {
				
				mkdir($path, 0777);
				
				file_put_contents($path . DS ."index.html", '');
				
				echo $this->success($path . "directory created");
			}

			$this->migrationFiles = array_values(
				array_diff(
					scandir($path), ['.', '..', 'index.html']
				)
			);

		} catch (\Exception $e) {
			echo $this->error("Error: ". $e->getMessage());
		}
	}

    /**
     * Executed Migrations
     *
     * @param boolean $latest
     * @return mixed
     */
	private function executedMigrations($latest = true, $single = false) {
		
        if ($single) {
            return $this->db
                ->order_by('migration', $latest ? self::DESC : self::ASC)
                ->get(self::TABLE)->first_row();
        }
        
        return $this->db
			->order_by('migration', $latest ? self::DESC : self::ASC)
			->get(self::TABLE)->result();
	}

    /**
     * Prepare Up Migration
     *
     * @param  string $file
     * @return void
     */
	protected function prepareUpMigration($file)
	{
		require(self::PATH . DS . $file); // require class file

		$migrationFile = self::PATH . $file;
		$migrationClass = (new TraverseClassFile)->getClassFullNameFromFile($migrationFile);
		$class = null;

		if (is_object(new $migrationClass())) {
			$class = new $migrationClass();
		}

		if (!method_exists($class, 'up') || !is_callable([$class, 'up'])) {
			throw new \Exception("($file) Invalid migration file", 1);
		}

		call_user_func([$class, 'up'], $this->dbforge, $this->db);

	}

    /**
     * Prepare Down Migration
     *
     * @param string $file
     * @return void
     */
	protected function prepareDownMigration($file)
	{
		require(self::PATH . DS . $file); // require class file

		$migrationFile = self::PATH . $file;
		$migrationClass = (new TraverseClassFile)->getClassFullNameFromFile($migrationFile);
		$class = null;

		if (is_object(new $migrationClass())) {
			$class = new $migrationClass();
		}

		if (!method_exists($class, 'down') || !is_callable([$class, 'down'])) {
			throw new \Exception("($file) Invalid migration file", 1);
		}

		call_user_func([$class, 'down'], $this->dbforge, $this->db);

	}

    /**
     * Find Migrations
     *
     * @param string $path
     * @return mixed
     */
	protected function findMigrations($path = null)
	{
		if ($path != null) {
			return $this->migrationFiles = array_values(
				array_diff(
					scandir($path), ['.', '..', 'index.html']
				)
			);
		}

		return $this->migrationFiles = array_values(
			array_diff(
				scandir(self::PATH), ['.', '..', 'index.html']
			)
		);
	}

    /**
     * Set Database to run migration on
     *
     * @param string $database
     * @return void
     */
	public function useDB($database = 'default') 
	{
		$this->useDb = $database;
	}

    /**
     * Migration command entry point
     *
     * @return void
     */
	public function index() {
		$this->run();
	}

    /**
     * Run Migrations
     *
     * @param integer $step
     * @return void
     */
	public function run($step = 0) {

		$lastMigrationFile = array_search($this->previousMigration, $this->migrationFiles);

		if ($this->previousMigration) {

			if ($lastMigrationFile !== false) {
				array_splice($this->migrationFiles, 0, $lastMigrationFile + 1);
			}

		}

		if (!$this->migrationFiles) {
			echo $this->error("No Migration File Available To Run");
			exit;
		}

		try {

			$startTime = microtime(true);

			$batch = $this->executedMigrations(true, true);

			if (!empty($batch)) {
				$batch = $batch->batch + 1;
			} else {
				$batch = 1;
			}

			foreach ($this->migrationFiles as $count => $file) {

				echo $this->info("Processing $file");

				$this->prepareUpMigration($file);

				$this->db->insert(self::TABLE, ['migration' => $file, 'batch' => $batch]);

				echo $this->success("$file done".PHP_EOL);

				if ($step && ($count + 1) >= $step) {
					break;
				}

			}

			$elapsedTime = round(microtime(true) - $startTime, 3) * 1000;

			echo $this->warning("Took $elapsedTime ms to run migrations", 1);

		} catch (\Exception $e) {
			exit("Error: ".$e->getMessage().PHP_EOL);
		}
	}

	/**
     * Truncate Migrations Table
     *
     * @return void
     */
    public function truncate($database = '')
    {
		$this->db->truncate(self::TABLE);
        echo $this->success("Migration table truncated successfully");
    }

    /**
     * Reset Migrations
     *
     * @return void
     */
    public function reset()
    {
        if ($this->previousMigration == null) {
            echo $this->warning('No Migrations To Reset');
            exit;
        }

        if ($this->previousMigration) {
            $this->rollback(INF); // infinity
        }

        echo $this->warning("Migration has been reset to initial state successfully");
    }

    /**
     * Rollback Migrations
     *
     * @param integer $step
     * @return void
     */
	public function rollback($step = 0) 
	{
		$previousMigrations = $this->executedMigrations();

		if (!$previousMigrations) {
			echo $this->warning("No Migrations To Rollback");
			exit;
		}

		try {

			$startTime = microtime(true);

			foreach ($previousMigrations as $count => $migration) {

				$file = $migration->migration;
				$path = self::PATH . $file;
				$exists = file_exists($path);

				if ($exists) {

					echo $this->info("Rolling back $file");

					$this->prepareDownMigration($file);
				
					$this->db->delete(self::TABLE, ['migration' => $migration->migration]);
					
					echo $this->success("$file done".PHP_EOL);
				}

				if ($step && ($count + 1) >= $step) {
					break;
                }
			}

			$elapsedTime = round(microtime(true) - $startTime, 3) * 1000;
            
			echo $this->warning("Took $elapsedTime ms to rollback migrations");

		} catch (\Exception $e) {
			exit("Error: ".$e->getMessage().PHP_EOL);
		}
	}

    /**
     * Check Migrations Status
     *
     * @return void
     */
	public function status() {

		$list = implode(PHP_EOL, array_map(
			function($migration) { return $migration->run_at.' '.$migration->migration; },
			$this->executedMigrations(false)
		));

		$this->output->set_header('Content-type: text/plain');

        $output = '';

        if ($list) {
            
            $output = $this->info("\nMigrations Used", 2);
            $output .= $this->warning($list, 2);
        } else {
            $output .= $this->warning('No Migrations Staged Yet');
        }

		echo $output;
	}

    /**
     * Check Latest or Current Migration
     *
     * @return void
     */
	public function latest() 
	{
        $migration = $this->executedMigrations(true, true);

        $output = '';

		$this->output->set_header('Content-type: text/plain');
        
        if (!$migration) {
           echo $output = $this->warning('No Current Migration Available');
           exit; 
        }

		$list = $migration->run_at.' '.$migration->migration;

        if ($list) {
            $output = $this->info("\nLatest Migration", 2);
            $output .= $this->warning($list, 2);
        } else {
            $output .= $this->warning('No Migrations Staged Yet');
        }

		echo $output;
	}

    /**
     * Check Migrations To Be Used Later
     *
     * @return void
     */
	public function future() 
	{
		if ($this->previousMigration) {

            $lastMigrationFile = array_search($this->previousMigration, $this->migrationFiles);

			if (($lastMigrationFile) !== false) {
				array_splice($this->migrationFiles, 0, $lastMigrationFile + 1);
			}
		}

		$this->output->set_header('Content-type: text/plain');
        
        $output = '';

        if ($this->migrationFiles) {
            $output = $this->info("\nAvailable Migrations To Run", 2);
            $output .= $this->warning(implode(PHP_EOL, $this->migrationFiles), 2);
        } else {
            $output = $this->warning("All Migrations Executed Already");
        }
      
        echo $output;
	}

}
