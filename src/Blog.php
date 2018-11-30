<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/12/21
 * Time: 17:55
 */

class Blog
{
    const version = '0.0.1';

    private $mdParse = null;

    private $noteList = [];
    private $noteIndex = [];

    protected $basePath;
    protected $tplPath;
    protected $distPath;
    protected $sourcePath;

    public $comment = '[^_^]:';

    public function __construct($mdParse)
    {
        $this->mdParse = $mdParse;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function getAllNote()
    {
        $this->noteList = glob($this->sourcePath . '*.md');
    }

    public function readFileAll($file)
    {
        return file_get_contents($file);
    }

    public function readFileHead($file)
    {
        $line = [];
        try {
            $fh = fopen($file, "r");
            while (!feof($fh)) {
                $head = fgets($fh);
                if (strpos($head, $this->comment) !== 0) {
                    break;
                }
                $line[] = $head;
            }
            fclose($fh);
        } catch (Exception $e) {
            return $file."读取失败";
        }

        return $line;
    }

    public function writeFile($fileName, $content)
    {
        file_put_contents($fileName, $content);
    }

    public function parse($content)
    {
        return $this->mdParse->text($content);
    }

    public function splitHeads(array $head = [])
    {
        $heads = [];
        foreach ($head as $value){
            $param = explode($this->comment, $value);
            $param = explode('=', $param[1]);
            $key = trim($param[0]);
            $heads[$key] = trim($param[1]);
        }
        return $heads;
    }

    public function render($head, $content)
    {
        extract($head);
        ob_start();
        ob_implicit_flush(0);
        include $this->tplPath . 'tpl.html';
        $cxt = ob_get_contents();
        ob_end_clean();
        return $cxt;
    }

    public function IndexPage()
    {
        ob_start();
        ob_implicit_flush(0);
        include $this->tplPath . 'index.html';
        $cxt = ob_get_contents();
        ob_end_clean();

        $head['title'] = 'blog';

        $content = $this->render($head, $cxt);

        $this->writeFile($this->basePath.'index.html', $content);
    }

    public function about()
    {
        ob_start();
        ob_implicit_flush(0);
        include $this->tplPath . 'about.html';
        $cxt = ob_get_contents();
        ob_end_clean();

        $head['title'] = 'blog';

        $content = $this->render($head, $cxt);

        $this->writeFile($this->basePath.'about.html', $content);
    }

    public function clear()
    {
        $noteList = glob($this->distPath . '*.html');
        foreach ($noteList as $note) {
            unlink($note);
        }
        unlink($this->basePath . 'index.html');
        unlink($this->basePath . 'about.html');
    }

    public function generator()
    {
        // 清理目录
        $this->clear();
        $this->getAllNote();

        foreach ($this->noteList as $note) {
            // read file
            $content = $this->readFileAll($note);
            $head = $this->readFileHead($note);
            // parse
            $result = $this->parse($content);
            $heads = $this->splitHeads($head);
            // output
            $html = $this->render($heads, $result);
            $this->writeFile($this->distPath . $heads['name'].'.html', $html);
            $year = substr($heads['date'], 0, 4);
            $mouth = substr($heads['date'], -5);
            $this->noteIndex[$year][$mouth] = [
                'mouth' => $mouth,
                'url' => '/dist/'.$heads['name'].'.html',
                'title' => $heads['title'],
            ];
        }

        // generate index page
        $this->IndexPage();
        $this->about();
    }
}
