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

    private $Parsedown = null;

    private $noteList = [];
    private $noteIndex = [];

    private $header = '';
    private $footer = '';

    public function __construct(Parsedown $Parsedown)
    {
        $this->Parsedown = $Parsedown;
    }

    public function getAllNote()
    {
        $this->noteList = array_slice(scandir(NOTEPATH), 2);
    }

    public function readFile($file)
    {
        return file_get_contents($file);
    }

    public function writeFile($fileName, $content)
    {
        $this->header = $this->readFile(TPLPATH.'header.html');
        $this->footer = $this->readFile(TPLPATH.'footer.html');
        $str = $this->header.$content.$this->footer;
        file_put_contents($fileName, $str);
    }

    public function parse($file)
    {
        $cxt = $this->readFile($file);
        preg_match('/---([\s\S]*?)---/i', $cxt, $matches);

        $text = str_replace($matches[0], '', $cxt);
        $content = $this->Parsedown->text($text);
        $heads = $this->getHeads($matches[1]);

        return [$heads, $content];
    }

    public function getHeads($head)
    {
        $heads = explode("\n", $head);
        $heads = array_slice($heads, 1, -1);
        $page = [];
        foreach ($heads as $key => $value) {
            list($k, $v) = preg_split('/:[ ]{0,}/', $value);
            $page[$k] = str_replace(array("\r\n", "\r", "\n"), '', $v);
        }

        return $page;
    }

    public function render($content)
    {
        $tpl = $this->readFile(TPLPATH.'tpl.html');
        return str_replace('{$content}', $content[1], $tpl);
    }

    public function IndexPage()
    {
        ob_start();
        ob_implicit_flush(0);
            include TPLPATH . 'index.php';
            $cxt = ob_get_contents();
        ob_end_clean();

        $this->writeFile(ROOTPATH.'/index.html', $cxt);
    }

    public function clear()
    {
        $noteList = glob(BLOGPATH.'*.html');
        foreach ($noteList as $key => $note) {
            unlink($note);
        }
        unlink(ROOTPATH.'/index.html');
    }

    public function generator()
    {
        // 清理目录
        $this->clear();
        $this->getAllNote();

        if (empty($this->noteList)) {
            echo 'empty note';
            return 1;
        }

        foreach ($this->noteList as $key => $note) {
            $file = NOTEPATH . $note;
            $result = $this->parse($file);
            $html = $this->render($result);
            $this->writeFile(BLOGPATH.$result[0]['name'].'.html', $html);
            $year = substr($result[0]['date'], 0, 4);
            $mouth = substr($result[0]['date'], -5);
            $this->noteIndex[$year][$mouth] = [
                'mouth' => $mouth,
                'url' => '/blog/'.$result[0]['name'].'.html',
                'title' => $result[0]['title'],
            ];
        }

        // generate index page
        $this->IndexPage();
    }
}