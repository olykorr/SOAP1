<?php

spl_autoload_register(function($class) {
    include "libs/{$class}.php";
});
