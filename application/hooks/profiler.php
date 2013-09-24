<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profiler
{
  function EnableProfiler()
  {
    $CI = &get_instance();
    $CI->output->enable_profiler( config_item('enable_profiling') );
  }
}
