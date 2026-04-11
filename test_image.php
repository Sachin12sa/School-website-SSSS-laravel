<?php
require __DIR__ . '/vendor/autoload.php';
$m = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
$i = $m->createImage(10, 10);
$encoded = $i->encode(new \Intervention\Image\Encoders\WebpEncoder(80));
echo get_class($encoded);
