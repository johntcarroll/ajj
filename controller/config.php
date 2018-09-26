<?php

ActiveRecord\Config::initialize(function($cfg)
{
   $cfg->set_model_directory('/var/www/ajj/model');
   $cfg->set_connections([
       'ajj_master' => 'mysql://username:password@localhost/development_database_name'
   ]);
   $cfg->set_default_connection(ajj_master);
});
