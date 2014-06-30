<?php
return [
    'admin' => 'admin/default/index',
    'account' => 'account/index',
    'category/<category_id:\d+>' => 'site/index',
    '' => 'site/index',
    '<slug:[\w\d-]+>' => 'site/view',
    //'<controller:[\w_]+' => '<controller>/index',
    '<controller:[\w-]+/<action:[\w-]+>'=>'<controller>/<action>'
];
