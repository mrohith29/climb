<?php

namespace ClimbUI;

global $body, $pageTitle, $firstNode, $adaptContent;
require_once __DIR__ . '/support/lib/vendor/autoload.php';

require_once __DIR__ . '/layout.php';
require_once __DIR__ . '/head.php';
require_once __DIR__ . '/components/tabs/adapt.php';
require_once __DIR__ . '/tab.partial.php';

use Approach\Render\HTML;
use Approach\Render\XML;
use Approach\Render\Node;
use Approach\Render\Container;

$pageTitle->content = 'New Stuff';
$body[] = $firstNode;
$body[] = $adaptContent;

ob_flush();