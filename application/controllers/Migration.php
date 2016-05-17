<?php 
defined("BASEPATH") or exit("No direct script access allowed");

class Migration extends CI_Controller {
    public function index() {
      if (ENVIRONMENT == 'development') {
        $this->load->library('migration');
        if (!$this->migration->current()) {
          show_error($this->migration->error_string());
        } else {
          echo "Migration success";
        }
      } else {
        echo "Production environment does not allow migration";
      }
    }
  }
?>
