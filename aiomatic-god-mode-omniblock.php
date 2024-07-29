<?php
defined('ABSPATH') or die();
function aiomatic_get_god_mode_object_omniblock()
{
    return new Aiomatic_Query_Function(
        'aiomatic_wp_god_mode',
        'Call any WordPress function using this wrapper function. Add the WP function name which needs to be called in the first parameter, and the parameters which needs to be sent to the function, in an array, sent as the second parameter for the wrapper function. Parameters will be processed using call_user_func_array, use parameters accordingly.',
        [
            new Aiomatic_Query_Parameter('called_function_name', 'The name of the WP function which needs to be called.', 'string', true),
            new Aiomatic_Query_Parameter('parameter_array', 'An array of parameters which should be sent to the function. Return parameters which can be parsed by call_user_func_array, as this is how the function will be called.', 'string', true)
        ]
        );
}
function aiomatic_return_god_function_omniblock()
{
    $return_arr = array();
    $return_arr[] = array('type' => 'function', 'function' => aiomatic_get_god_mode_object_omniblock());
    return $return_arr;
}
add_filter('aiomatic_ai_functions', 'aiomatic_add_god_mode_omniblock', 999, 1);
function aiomatic_add_god_mode_omniblock($query) 
{
    if(is_array($query))
    {
        $functions = $query;
    }
    else
    {
        $functions = array();
    }
    if ( current_user_can( 'access_aiomatic_menu' ) ) 
    {
        $functions['functions'] = aiomatic_return_god_function_omniblock();
        $functions['message'] = '';
    }
    return $functions;
}
?>