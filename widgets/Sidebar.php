<?php
namespace app\widgets;

use \yii\helpers\Html;
use \yii\base\InvalidConfigException;
use \yii\helpers\ArrayHelper;
use \yii\bootstrap\BootstrapAsset;

class Sidebar extends \yii\bootstrap\Widget{

    public $title = '';
    public $items = [];
    public $encodeLabels = true;
    public $handleActive = null;


    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $style =<<<EOF
    @media screen and (max-width: 767px) {
        .row-offcanvas {
            position: relative;
            -webkit-transition: all 0.25s ease-out;
            -moz-transition: all 0.25s ease-out;
            transition: all 0.25s ease-out;
        }

        .row-offcanvas-right
        .sidebar-offcanvas {
            right: -50%; /* 6 columns */
        }

        .row-offcanvas-left
        .sidebar-offcanvas {
            left: -50%; /* 6 columns */
        }

        .row-offcanvas-right.active {
            right: 50%; /* 6 columns */
        }

        .row-offcanvas-left.active {
            left: 50%; /* 6 columns */
        }

        .sidebar-offcanvas {
            position: absolute;
            top: 0;
            width: 50%; /* 6 columns */
        }
    }
EOF;
        Html::addCssStyle($options, $style);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo $this->renderContent();
        BootstrapAsset::register($this->getView());
    }

    public function renderContent() {
        $title = $this->encodeLabels ? Html::encode($this->title) : $this->title;
        $html  = '<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">';
        $html .= '<p class="visible-xs" style="margin:-1.3em -1em 0 -5.2em;">';
        $html .= '<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">== ==</button>';
        $html .= '</p>';
        $html .= '<div class="list-group">';
        $html .= '<span class="list-group-item"><h4>'. $title .'</h4></span>';
        foreach($this->items as $item) {
            $label = $this->encodeLabels ? Html::encode($item['label']) : $item['label'];
            $handle = $this->handleActive;
            $options = ['class'=>'list-group-item'];
            if ($handle($item['categoryId'])) {
                $options['class'] .= " active";
            }
            $html .= Html::a($label, $item['url'], $options);
        }
        return $html;
    }

} 
