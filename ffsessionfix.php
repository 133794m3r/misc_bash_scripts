<?php

class Log {
  public static function doLog($s = '') {
    print $s . "\n";
  }
}


class SessionstoreLib {
    const VERSION = '0.3';
    const DATE = '2012-11-18';
    const AUTHORS = 'thePanz <thepanz@gmail.com>';
    
    public static function doReopenWindow($config) {
      // var_dump($config);
      $windowid = @(int)$config['closed-window-id'];
      if (is_numeric($windowid)) {
        $data = SessionstoreLib::json_getData($config['sessionfile'], TRUE);
        if (isset($data['_closedWindows'][$windowid])) {
          // print_r(SessionstoreLib::print_r($data, 2));
          // Log::doLog('ok');
          $data['windows'][] = $data['_closedWindows'][$windowid];
          unset($data['_closedWindows'][$windowid]);
          // print_r(SessionstoreLib::print_r($data, 2));
          return $data;
        }
      }
      else {
        Log::doLog('Error: no window-id provided, use parameter "--closed-window-id=XX"');
      }  
    }
  
  
    public static function print_r($data, $rec_limit, $rec_level = 1) {
      if (is_array($data)) {
        $ret = array();
        if ($rec_level >= $rec_limit) {
          return '**recursion-stop** items=' . count($data);
        }
        else {
          foreach($data as $k => $c) {
            $ret[$k] = SessionstoreLib::print_r($c, $rec_limit, $rec_level+1);
          }
          return $ret;
        }
      }
      else {
        return $data;
      }
    }
    
    private static function _removeWindow(&$data, $type, $id) {
      if (is_array($data[$type]) && is_array($data[$type][$id])) {
        unset($data[$type][$id]);
      }
    }
    
    public static function doRemoveWindow($config) {
      $data = SessionstoreLib::json_getData($config['sessionfile'], TRUE);
      if(is_numeric($config['closed-window-id'])) {
        $windowid = (int) $config['closed-window-id'];
        SessionstoreLib::_removeWindow($data, '_closedWindows', $windowid);
        return $data;
      }
      elseif(is_numeric($config['open-window-id'])) {
        $windowid = (int) $config['open-window-id'];
        SessionstoreLib::_removeWindow($data, 'windows', $windowid);
        return $data;
      }
      else {
        Log::doLog('Error: no window-id provided, use: --open-window-id=N, --closed-window-id=N');
      }
      
      return NULL;
    }
    
    public static function doRemoveClosedTabs($config) {
      $data = SessionstoreLib::json_getData($config['sessionfile'], TRUE);
      
      if ($config['all-windows'] == TRUE) {
        SessionstoreLib::parseRemove($data, '_closedTabs');
      }
      elseif ($config['closed-windows'] == TRUE) {
        SessionstoreLib::parseRemove($data['_closedWindows'], '_closedTabs');
      }
      elseif($config['open-windows'] == TRUE) {
        SessionstoreLib::parseRemove($data['windows'], '_closedTabs');
      }
      else {
        Log::doLog('Error: no param given, use: --all-windows, --closed-windws, --open-windos');
        return NULL;
      }
      
      return $data;
    }
    
    private static function parseRemove(&$data, $itemName) {
      if (is_array($data)) {
        foreach($data as $k => &$c) {
          if ($k === $itemName) {
            unset($data[$k]);
          }
          elseif(is_array($c)) {
            SessionstoreLib::parseRemove($c, $itemName);
          }
        }
      }
    }
   
    public static function doDump($config) {
      $data = SessionstoreLib::json_getData($config['sessionfile'], TRUE);
      $recursion = isset($config['recursion']) ? $config['recursion'] : 4;
      $stats = SessionstoreLib::print_r($data, $recursion);
      print_r($stats);
    }
    
    
    /**
     * Helper function to get the JSON contents
     */
    public static function json_getData($file, $asArray = FALSE, $depth = 512) {
      return json_decode(file_get_contents($file), $asArray, $depth);
    }
    
    /**
     * Helper function to get the JSON contents
     */
    public static function json_putData(Array $data, $file = NULL) {
      if ($file == NULL) {
        return json_encode($data);
      }
      else {
        file_put_contents($file, json_encode($data));
      }
    }
  
  
  
}

show_header();

$config = array(
  'action' => '',
  'verbose' => TRUE,
  'dump' => '',
  'sessionfile' => '',
);

handle_params($argv, $config);

if (empty($config['action']) || $config['action'] == 'help') {
  // Log::doLog('Error: missing action');
  show_usage();
  die();
} elseif (empty($config['sessionfile'])) {
  Log::doLog('Error: missing sessionfile');
  die();
} else {
  execute_action($config);
  // Log::doLog();
}

function show_header() {
  Log::doLog('Mozilla SessionStore.js file-fixer');
  Log::doLog('  by ' . SessionstoreLib::AUTHORS. ', version: ' . SessionstoreLib::VERSION . ' ['.SessionstoreLib::DATE.']');
  Log::doLog();
}

function show_usage() {
  Log::doLog('usage:');
  Log::doLog('  ffsessionfix.php ACTION [params] sessionstore.js');
  Log::doLog();
  Log::doLog('actions:');
  Log::doLog('  dump                 : Prints the sessionstore.js contents');
  Log::doLog('  removeClosedTabs     : Remove a set of closed tabs');
  Log::doLog('  removeWindow         : Remove a window');
  Log::doLog('  reopenWindow         : Reopen a closed window');
  Log::doLog('  help                 : Prints this help');
  Log::doLog();
  Log::doLog('params:');
  Log::doLog('  --recursion=N        : Max recursion level in printing sessionstore.js contents (use in dump action)');
  Log::doLog('  --closed-window-id=N : Specify a closed window-id (used in removeWindow action)');
  Log::doLog('  --open-window-id=N   : Specify the window-id (used in removeWindow action)');
  Log::doLog('  --all-windows        : remove all closed tabs from all windows (used in removeClosedTabs action)');
  Log::doLog('  --open-windows       : remove all closed tabs from opened windows (used in removeClosedTabs action)');
  Log::doLog('  --closed-windows     : remove all closed tabs from closed windows (used in removeClosedTabs action)');
  Log::doLog('  --output=FILENAME    : Specify the outptut file to write the new data to (instead of screen)');
  Log::doLog();
}


function handle_params($argv, &$config) {
  // Remove scriptname
  array_shift($argv);
  
  if (count($argv) >= 2) {
    $config['action'] = array_shift($argv);
    $config['sessionfile'] = array_pop($argv);
    
    foreach($argv as $arg) {
      if (strpos($arg, '--') === 0) {
        $arg = substr($arg, 2);
        $i = explode('=', $arg);
        if (count($i) == 1)
          $i[] = TRUE;
         
        $config[$i[0]] = $i[1];
      }
    }
    // Log::doLog(__function__);
    // $session_file = array_shift($argv);
  }
}

function execute_action($config) {
  // Log::doLog(__function__);
  if (method_exists('SessionstoreLib', 'do'.$config['action'])) {
    // Log::doLog('ACTION: '. $config['action']);
    $data = call_user_func_array(array('SessionstoreLib', 'do'.$config['action']), array($config));
    
    if (is_array($data)) {
      if ($config['output'] !== TRUE) {
        SessionstoreLib::json_putData($data, $config['output']);
      }
      else {
        SessionstoreLib::json_putData($data);
      }      
    }
    
  }
  else {
    Log::doLog('Wrong action provided!');
    Log::doLog(); 
  }
}
