<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_User extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 9,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_email' => array(
                'type' => 'VARCHAR',
                'constraint' => '255'
            ),
            'user_password' => array(
                'type' => 'VARCHAR',
                'constraint' => '65',
            ),
            'remember_token' => array(
                'type' => 'VARCHAR',
                'constraint' => '10'
            ),
            'twitter_id' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'facebook_id' => array(
                'type' => 'TEXT',
                'null' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');
    }

    public function down() {
        $this->dbforge->drop_table('users');
    }
}