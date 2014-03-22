<?php
namespace app\widgets;

use \Yii;

class Nav extends \yii\bootstrap\Nav {

    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }


            $current_routes = explode("/", $this->route);
            $routes = explode("/", ltrim($route, '/'));

            if (count($current_routes) != count($routes)) {
                return false;
            }
            else if (count($current_routes)==3) {
                if ($routes[0] != $current_routes[0]) return false;
                if ($routes[1] != $current_routes[1]) return false;
            }
            else if (ltrim($route, '/') !== $this->route) {
                return false;
            }

            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                foreach (array_splice($item['url'], 1) as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }

            return true;
        }

        return false;
    }
} 
