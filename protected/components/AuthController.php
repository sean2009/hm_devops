<?php


class AuthController extends BaseController {
    
    public function init() {
        parent::init();
        date_default_timezone_set('Asia/Shanghai');
    }

    public function render($view = null, $data = null, $return = false) {
        $view = $view ? $view : $this->getAction()->getId();
        
        parent::render($view, $data, $return);
    }
    
}
