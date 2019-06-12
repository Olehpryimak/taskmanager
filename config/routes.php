<?php

return array(
// Адмін
    'admin/edit' => 'admin/edit', // actionLogout в AdminController
    'admin/login' => 'admin/login', // actionLogin в AdminController
    'admin/logout' => 'admin/logout', // actionLogout в AdminController
// Задачі
    'add' => 'site/add', // actionAdd в SiteController
    'page-([0-9]+)' => 'site/index/$1', // actionIndex в SiteController 
    '' => 'site/index', // actionIndex в SiteController
);
