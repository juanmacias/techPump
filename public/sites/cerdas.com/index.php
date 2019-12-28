<?php

//cerdas.com site
use techPump\Pages\SitePage;

require "../../../app/framework/Pages/Page.php";
require "../../../app/framework/Pages/SitePage.php";

$page = new SitePage( __DIR__ );
$page->show();