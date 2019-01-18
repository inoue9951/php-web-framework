<?php

class FileGenerator
{
    private $cliArgs;
    protected $filenames = array();
    protected $fileType;
    protected $path;

    public function __construct($cliArgs)
    {
        $this->cliArgs = $cliArgs;
        $this->fileType = $cliArgs->command->args['file_type'];
        $this->filenames = $cliArgs->command->args['file_name'];
        $this->path = dirname(__FILE__, 3) . '/app/';
    }

    public function create()
    {
        echo 'create running' . PHP_EOL;
        if ($this->fileType == 'controller') {
            $this->createController();
            return true;
        } else if ($this->fileType == 'model') {
            $this->createModel();
            return true;
        }

        echo 'controllerかmodelを入力してください' . PHP_EOL;
        return false;
    }

    private function createController()
    {
        foreach ($this->filenames as $name) {
            $controllerName = ucfirst($name);
            $filePath = $this->path . 'Controllers/' . $controllerName . 'Controller.php';

            if (file_exists($filePath)) {
                echo $filePath . 'はすでにあります' . PHP_EOL;
                continue;
            } else {
                $input = <<<EOC
<?php

use Core\Controller;

class {$name}Controller extends Controller
{

}
EOC;
                file_put_contents($filePath, $input);
                echo 'create : ' . $filePath . PHP_EOL;

                $viewsPath = $this->path . 'Views/' .$name;

                if (!file_exists($viewsPath)) {
                    if (mkdir($viewsPath, 0755)) {
                        echo "create : $viewsPath" . PHP_EOL;
                    } else {
                        echo $viewsPath . ' の作成に失敗しました' . PHP_EOL;
                    }
                } else {
                    echo $viewsPath . ' はすでにあります' . PHP_EOL;
                }
            }
        }
    }

    private function createModel()
    {
        foreach ($this->filenames as $name) {
            $filePath = $this->path . 'Models/' . ucfirst($name) . '.php';

            if (file_exists($filePath)) {
                echo $filePath . 'はすでにあります' . PHP_EOL;
                continue;
            } else {
                $className = ucfirst($name);
                $input = <<<EOM
<?php
class $className extends Model
{
}
EOM;
                file_put_contents($filePath, $input);
                echo 'create : ' . $filePath . PHP_EOL;
            }
        }
    }
}
