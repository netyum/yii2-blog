<?php
use app\widgets\Sidebar;

$this->beginContent('@app/views/layouts/main.php');
include("_nav.php");
?>


<div class="container panel" style="margin-top:5em; padding-bottom:1em;">
    <?php echo $content;?>
</div>

<?php
$this->endContent();
