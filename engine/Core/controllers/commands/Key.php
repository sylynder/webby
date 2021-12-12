<?php

use Base\Helpers\DotEnvWriter;
use Base\Console\ConsoleColor;
use Base\Controllers\ConsoleController;

class Key extends ConsoleController
{

    /**
     * Console keyword
     *
     * @var string
     */
    private $keyword = 'app.encryptionKey';

    public function __construct()
    {
        parent::__construct();
        
        $this->onlydev();
    }

    public function index()
    {
        $this->generatekey();
    }

    /**
     * Prepare key for generationg
     *
     * @return void
     */
    public function prepare()
    {
        $this->prepareKey();
    }

    /**
     * Check if key exists
     *
     * @return bool
     */
    private function check() {

        $exists = false;

        if ((new DotEnvWriter)->exists($this->keyword)) {
            $exists = true;
        }

        return $exists;

    }

    /**
     * Prepare key
     *
     * @return bool
     */
    private function prepareKey() {

        $dotenv = new DotEnvWriter();

        $content = $dotenv->getContent();

        if (strstr($content, '# ' . $this->keyword)) {
            $dotenv->setContent(str_replace('# '. $this->keyword, $this->keyword, $content));
        }

        $dotenv->write();

        return $this->check();
    }

    /**
     * Create key
     *
     * @param string $key
     * @param boolean $use_bytes
     * @return string
     */
    private function createkey($key = '', $use_bytes = false)
    {
        $this->load->helper('string');

        if (empty($key)) {
            return random_string('alnum', 42);
        }

        if ($use_bytes) {
            $key = sha1($key . random_bytes(42));
        }

        return $key;
    }

    /**
     * Generate key
     *
     * @return void
     */
    private function generatekey()
    {
        $dotenv = new DotEnvWriter();

        $keyValue = $dotenv->getValue($this->keyword);
        
        $key = $this->createkey();
        
        if (!empty($keyValue)) {
            echo ConsoleColor::yellow("Key exists already") . "\n";
            exit();
        }

        $dotenv->setValue($this->keyword, $key);

        if ($dotenv->isSaved()) {
            echo ConsoleColor::green("Key generated successfully") . "\n";
            exit();
        }

        echo ConsoleColor::red("Key could not generate you have to do it manually in .env file") . "\n";
        exit();
    }

    /**
     * Regenerate key
     *
     * @return void
     */
    public function regenerate()
    {
        $dotenv = new DotEnvWriter();

        $key = $this->createkey();

        $dotenv->setValue($this->keyword, $key);
        
        if ($dotenv->wasChanged()) {
            echo ConsoleColor::green("Key regenerated successfully") . "\n";
            exit();
        }

        echo ConsoleColor::red("Key could not generate you have to do it manually in .env file") . "\n";
        exit();

    }

}
