<?php
defined('COREPATH') or exit('No direct script access allowed');

use Base\Debug\Debug;
use Base\Debug\AtEase;

if ( ! function_exists( __NAMESPACE__ . '\\suppressWarnings' ) ) 
{

    if ( ! function_exists( 'shut_up' )) 
    {
        /**
         * Reference-counted warning suppression
         *
         * @param bool $end Whether to restore warnings
         */
        function shut_up( $end = false ) {
            AtEase::suppressWarnings( $end );
        }
    }

    if ( ! function_exists( 'shush' )) 
    {
        /**
         * Alias of shut_up function
         * @param bool $end Whether to restore warnings
         */
        function shush( $end = false ) {
            shut_up( $end );
        }

    }

    
    if ( ! function_exists( 'speak_up' )) 
    {
        /**
         * Restore error level to previous value
         */
        function speak_up() {
            AtEase::restoreWarnings();
        }
    }

    if ( ! function_exists( 'keep_quiet' )) 
    {
        /**
         * Call the callback given by the first parameter, suppressing any warnings.
         *
         * @param callable $callback Function to call
         * @param mixed ...$args Optional arguments for the function call
         * @return mixed
         */
        function keep_quiet( callable $callback, ...$args ) {
            return AtEase::quietCall( $callback, ...$args );
        }
    }

}

if ( ! function_exists( 'strict_dev' )) 
{
    /**
	 * Check if development 
     * environment is active
	 *
	 * @return void
	 */
    function strict_dev()
    { 
        if (ENVIRONMENT !== 'development') {
            show_error('Sorry you must be in development mode');
        }
    }
}

if ( ! function_exists( 'console' )) 
{
    /**
	 * Show output in Browser Console
	 *
	 * @param mixed $var converted to json
	 * @param string $type - browser console log types [log]
	 * @return void
	 */
    function console(/* mixed */ $var, string $type = 'log')
    { 
        strict_dev();
        echo '<script type="text/javascript">console.';
        echo ''.$type.'';
        echo '('.json_encode($var).')</script>';
    }
}

if ( ! function_exists( 'dump' )) 
{
    /**
     * Simple debug output with 
     * var_dump() function
     *
     * @param mixed $dump
     * @return void
     */
    function dump($dump)
    { 
        strict_dev();
        echo '<pre>';
        var_dump($dump);
        echo '</pre>';
    }
}

if ( ! function_exists( 'dd' )) {
    function dd()
    {
        strict_dev();
        array_map(function($x) { Debug::var_dump($x); }, func_get_args()); die;
    }
}

if ( ! function_exists( 'pp' )) 
{
    /**
     * Pretty Print debug output
     *
     * @param mixed $dump
     * @return void
     */
    function pp($dump)
    { 
        strict_dev();
        echo highlight_string("<?php\n\$data =\n" . var_export($dump, true) . ";\n//>");
        echo '<script>document.getElementsByTagName("code")[0].getElementsByTagName("span")[1].remove() ;document.getElementsByTagName("code")[0].getElementsByTagName("span")[document.getElementsByTagName("code")[0].getElementsByTagName("span").length - 1].remove() ; </script>';
        die();
    }
}



if ( ! function_exists( 'dump_json' )) 
{
    /**
     * Debug json output 
     * Useful when using ajax requests
     * 
     * @param mixed $dump
     * @return mixed
     */
    function dump_json($dump)
    { 
        strict_dev();
        return json_encode($dump);
    }
}

if ( ! function_exists( 'start_profiler' ))
{
    /**
	 * Enable Profiler
	 *
	 * @return CI_Output
	 */
    function start_profiler()
    {
        ci()->output->enable_profiler(true);
    }
}

if ( ! function_exists( 'stop_profiler' )) 
{
    /**
	 * Disable Profiler
	 *
	 * @return CI_Output
	 */
    function stop_profiler()
    {
        ci()->output->enable_profiler(false);
    }
}

if ( ! function_exists( 'section_profiler' )) 
{
    /**
	 * Set Profiler Sections
	 *
	 * Allows override of default/config settings for
	 * Profiler section display.
	 *
	 * @param	array	$sections	Profiler sections
	 * @return	CI_Output
	 */
    function section_profiler($config = null)
    {
        $sections =[ 
            'config'  => true, 
            'queries' => true 
        ]; 

        if ($config !== null && is_array($config)) {
            $sections = $config;
        }

        ci()->output->set_profiler_sections($sections);
    }
}

if ( ! function_exists( 'start_benchmark' )) 
{
    /**
     * Set and start a benchmark marker
     *
     * @param string $start_key Marker name
     * @return void
     */
    function start_benchmark($start_key = 'start')
    {
        ci()->benchmark->mark($start_key);
    }
}

if ( ! function_exists( 'end_benchmark' )) 
{
    /**
     * Set and end a benchmark marker
     *
     * @param string $end_key Marker name
     * @return void
     */
    function end_benchmark($end_key = 'end')
    {
        ci()->benchmark->mark($end_key);
    }
}

if ( ! function_exists( 'show_time_elasped' )) 
{
    /**
     * Calculates the time difference 
     * between two marked points.
     *
     * @param string $start_key
     * @param string $end_key
     * @return void
     */
    function show_time_elasped($start_key = 'start', $end_key = 'end')
    {
        echo ci()->benchmark->elapsed_time($start_key, $end_key) . ' '; 
    }
}

if ( ! function_exists( 'time_used' )) 
{
    /**
     * Show time elasped
     *
     * @return void
     */
    function time_used()
    {
        echo "{elapsed_time}"; 
    }
}

if ( ! function_exists( 'memory_used' )) 
{
    /**
     * Show memory used
     *
     * @return void
     */
    function memory_used()
    {
        echo "{memory_usage}"; 
    }
}
