<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Check if the uri is the same as the current uri
* @param  [string]  $uri
* @return boolean
*/
if (!function_exists('isActive'))
{
  function isActive($uri)
  {
    if(uri_string() == $uri) {
      echo 'class="active"';
    }
  }
}

/**
* Check to see if the request method matches $method
* @param  [type]  $method - A request method (e.g. Post, Get, etc)
* @return boolean
*/
if(!function_exists('isMethod'))
{
  function isMethod($method) {
    return (strtolower($_SERVER['REQUEST_METHOD']) === $method ? true: false);
  }
}
