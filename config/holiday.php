<?php

// config for Reinbier/LaravelHoliday
return [

    /**
     * The name of the table to use. You can adjust this to suit your needs.
     */
    'table_name' => 'holidays',

    /**
     * If you want to use a different locale to generate holidays for,
     * you can set it here. For now, a sensible default is set.
     */
    'locale' => config('app.locale', 'nl'),

    /**
     * When true, sets the holidays for Carbon in the service container.
     */
    'enable_carbon' => false,

];
