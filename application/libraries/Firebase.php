<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'views/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


class Firebase {

    protected $config	= array();
    protected $serviceAccount;

    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();

        //$this->serviceAccount = ServiceAccount::fromJsonFile($this->CI->config->item('firebase_app_key'));
        $this->serviceAccount = ServiceAccount::fromJsonFile(APPPATH . 'config/test-pv-13797-firebase-adminsdk-25j7p-fb95f5134c.json');
    }

    
    public function init()
    {
        return $firebase = (new Factory)->withServiceAccount($this->serviceAccount)->withDatabaseUri('https://test-pv-13797-default-rtdb.firebaseio.com')->create();
    }
} 