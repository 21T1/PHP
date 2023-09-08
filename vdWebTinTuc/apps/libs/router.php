<?php
    class apps_libs_router{
        const PARAM_NAME = 'r';
        const HOME_PAGE = 'home';
        const INDEX_PAGE = 'index';

        public static $sourcePath;

        public function __construct($sourcePath = "") {
            if($sourcePath)
                self::$sourcePath = $sourcePath;    
        }

        public function getGET($name = null){
            if($name !== null)
                return isset($_GET[$name]) ? $_GET[$name] : null;
            return $_GET;
        }
        
        public function getPOST($name = null){
            if($name !== null)
                return isset($_POST[$name]) ? $_POST[$name] : null;
            return $_POST;
        }

        public function router() {
            $url = $this->getGET(self::PARAM_NAME);
            if(!is_string($url) || !$url || $url == self::INDEX_PAGE)
                $url = self::HOME_PAGE;

            $path = self::$sourcePath."/".$url.".php";
            if(file_exists($path))
                return require_once $path;
            else
                return $this->pageNotFound();
        }

        public function pageNotFound() {
            $this->pageError('Page Not Found');
        }

        public function createUrl($url, $param = []) {
            if($url)
                $param[self::PARAM_NAME] = $url;
            // PHP_SELF -> Folder link
            return $_SERVER['PHP_SELF'].'?'. http_build_query($param);
        }

        /**
         * Redirecting to a new page after login
         */
        public function redirect($url) {
            $u = $this->createUrl($url);
            header("Location:$u");
        }

        public function homePage(){
            $this->redirect(self::HOME_PAGE);
        }

        public function loginPage() {
            $this->redirect("login");
        }
        
        public function pageError($error) {
            echo $error;
            die();
        }
    }
?>