<?php
defined('ABSPATH') or die();
add_filter('aiomatic_ai_functions', function ($query) 
{
    if(is_array($query))
    {
        $functions = $query;
    }
    else
    {
        $functions = array();
    }
    $functions['functions'][] = array('type' => 'function', 'function' => new Aiomatic_Query_Function(
            'send_email',
            'Send an email to the administrator of this website',
            [
                new Aiomatic_Query_Parameter('subject', 'The subject of the email', 'string', true),
                new Aiomatic_Query_Parameter('message', 'The message of the email', 'string', true)
            ]
        )
    );
    $functions['message'] = 'Sure, I just sent an email to admin, he will respond soon!';
    return $functions;
}, 999, 1);

add_filter('aiomatic_ai_reply_raw', function ($reply, $query) 
{
    if (isset($reply->tool_calls) && !empty($reply->tool_calls)) 
    {
        foreach($reply->tool_calls as $tool_call)
        {
            if (isset($tool_call->type) && $tool_call->type == 'function')
            {
                if (isset($tool_call->function->arguments) && is_string($tool_call->function->arguments)) 
                {
                    $tool_call->function->arguments = json_decode($tool_call->function->arguments);
                }
                if ($tool_call->function->name === 'send_email') 
                {
                    $subject = $tool_call->function->arguments->subject;
                    $message = $tool_call->function->arguments->message;
                    mail("admin@yoursite.com", $subject, $message);
                    if(!isset($reply->choices))
                    {
                        $reply->choices = array();
                        $reply->choices[0] = new stdClass();
                    }
                    //this is optional, here you can set the text which will be displayed as the AI response (only in the response streaming mode). You can output a simple text, directly the result of your function call or parse the function call result through the AI writer, for a sintetized response.
                    $reply->choices[0]->text = 'Email Sent!';
                    $reply->choices[0]->message->content = 'Email Sent!';
                }
            }
        }
    }
    return $reply;
}, 10, 2);

?>