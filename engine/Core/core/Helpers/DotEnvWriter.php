<?php

/**
 * Handle and Manipulate Dot Env Files 
 * 
 * Credit: https://github.com/msztorc/laravel-env
 * 
 * Version - 0.1
 */

namespace Base\Helpers;

class DotEnvWriter
{
    private $content = null;
    private $variables = null;
    private $path;
    private $saved = false;
    private $changed = false;

    public function __construct()
    {

        $this->path = ROOTPATH . '.env';

        $this->content = file_get_contents($this->path);

        $this->parse();
    }

    /**
     * Get current env entire content from memory
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     *  Parse env content into array
     */
    private function parse(): void
    {
        $lines = preg_split('/\r\n|\r|\n/', $this->content);

        foreach ($lines as $line) {
            
            if (strlen(trim($line)) && !(strpos(trim($line), '#') === 0)) {
                [$key, $val] = array_map("trim", explode('=', (string)$line));
                $this->variables[$key] = $this->stripValue($val);
            }

        }
    }

    /**
     * Check if the variable exists
     * @param string $key Environment variable key
     * @return bool
     */
    public function exists(string $key): bool
    {
        if (is_null($this->variables)) {
            $this->parse();
        }
        return isset($this->variables[$key]);
    }

    /**
     * Get the current env variable value
     *
     * @param string $key Environment variable key
     * @return string
     */
    public function getValue(string $key): string
    {
        if (is_null($this->variables)) {
            $this->parse();
        }

        return $this->variables[$key] ?? '';
    }


    /**
     * Get env key-value
     *
     * @param string $key Environment variable key
     * @return array
     */
    public function getKeyValue(string $key): array
    {
        if (is_null($this->variables)) {
            $this->parse();
        }

        return [$key => $this->variables[$key]] ?? [];
    }

    /**
     * Set env variable value
     * @param string $key Environment variable key
     * @param string $value Variable value
     * @param bool $write Write changes to .env file
     * @return string
     */
    public function setValue(string $key, string $value, $write = true): string
    {
        $value = $this->prepareValue($value);

        if ($this->exists($key)) {
            $this->content = preg_replace("/^{$key} =.*$/m", "{$key} = {$value}", $this->content);
        } else {
            $this->content .= PHP_EOL . "{$key} = {$value}" . PHP_EOL;
        }

        $this->changed = true;
        $this->saved = false;

        $this->parse();

        if ($write) {
            $this->write();
        }

        return $this->getValue($key);
    }

    public function setContent(string $content)
    {
        if (empty($content)) {
            return;
        }

        return $this->content = $content;
    }

    /**
     * Delete environment variable
     * @param string $key Environment variable key
     * @param bool $write Write changes to .env file
     * @return bool
     */
    public function deleteVariable(string $key, bool $write = true): bool
    {
        if ($this->exists($key)) {
            $this->content = preg_replace("/^{$key} =.*\s{0,1}/m", '', $this->content);

            $this->changed = true;
            $this->saved = false;

            if ($write) {
                $this->write();
            }
        }

        return true;
    }

    private function pregQuoteExcept(string $str, string $exclude, ?string $delimiter = null): string
    {
        $str = preg_quote($str, $delimiter);
        $from = [];
        $to = [];

        for ($i = 0; $i < strlen($exclude); $i++) {
            $from[] = '\\' . $exclude[$i];
            $to[] = $exclude[$i];
        }

        return (count($from) && count($to)) ? str_replace($from, $to, $str) : $str;
    }

    /**
     * Check and prepare value to be safe
     * @param string $value
     * @return string
     */
    private function prepareValue(string $value): string
    {
        if (false !== strpos($value, ' ') || (strlen($value) && in_array($value[0], ['=', '$', ' = ']))) {
            $value = '"' . $value . '"';
        }

        return $this->pregQuoteExcept($value, ':.');
    }

    /**
     * String quoutes
     *
     * @param string $value
     * @return string
     */
    private function stripQuotes(string $value): string
    {
        return preg_replace('/^(\'(.*)\'|"(.*)")$/', '$2$3', $value);
    }

    /**
     * Strip output value from quotes and inline comments
     * @param string $value
     * @return string
     */
    private function stripValue(string $value): string
    {
        $val = trim(explode('#', trim($value))[0]);

        return stripslashes($this->stripQuotes($val));
    }

    /**
     * Get all uncommented env variables
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * Write env config to file
     * @return bool
     */
    public function write(): bool
    {
        $this->saved = (false !== file_put_contents($this->path, $this->content) ?? true);

        return $this->saved;
    }

    /**
     * Check if the changes has been saved
     * @return bool
     */
    public function isSaved(): bool
    {
        return $this->saved;
    }

    /**
     * Check if there were any env content changes
     * @return bool
     */
    public function wasChanged(): bool
    {
        return $this->changed;
    }

}
