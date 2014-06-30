<?php
use app\widgets\Sidebar;
use app\models\ar\Category;

$this->beginContent('@app/views/layouts/main.php');
include("_nav.php");
?>

    <div class="container" style="margin-top:5em; padding-bottom:1em;">
        <div class="row row-offcanvas row-offcanvas-right">
            <?php echo $content;?>
            <?php
            $categories_array = [
                ['categoryId'=>0, 'label' => '所有分类', 'url' => ['/site/index']],
            ];
            $categories = Category::getCategories();
            foreach ($categories as $category) {
                $categories_array[] = [
                    'categoryId'=>$category['id'],
                    'label'=>$category['name'],
                    'url'=>['site/index', 'category_id'=>$category['id']]
                ];
            }
            echo Sidebar::widget([
                'title'=>'文章分类',
                'items'=>$categories_array,
                'handleActive'=> function ($id) {
                    $currentId = 0;
                    if (isset($_GET['category_id'])) {
                        $currentId = intval($_GET['category_id']);
                    }
                    return $currentId == $id;
                }
            ]);
            ?>
        </div>
    </div>
<?php
$this->endContent();
