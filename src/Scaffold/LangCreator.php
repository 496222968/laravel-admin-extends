<?php

namespace Encore\Admin\Scaffold;

use Illuminate\Support\Facades\App;

class LangCreator
{
    protected $fields = [];

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * 生成语言包.
     *
     * @param string $controller
     *
     * @return string
     */
    public function create(string $controller)
    {
        $controller = str_replace('Controller', '', class_basename($controller));
        $path = $this->getLangPath($controller);

        if (is_file($path)) {
            throw new \Exception("Lang [$this->name] already exists!");
        }

        $content = [
            'labels' => [
                $controller => $controller,
            ],
            'fields'  => [],
            'options' => [],
        ];
        foreach ($this->fields as $field) {
            if (empty($field['name'])) {
                continue;
            }

            $content['fields'][$field['name']] = $field['translation'] ?: $field['name'];
        }

        if (app('files')->put($path, $this->exportArrayPhp($content))) {
            return $path;
        }
    }

    /**
     * 获取语言包路径.
     *
     * @param string $controller
     *
     * @return string
     */
    protected function getLangPath(string $controller)
    {
        $path = resource_path('lang/'.App::getLocale());

        return $path.'/'.$this->slug($controller).'.php';
    }

    /**
     * @param array $array
     *
     * @return string
     */
    public function exportArrayPhp(array $array)
    {
        return "<?php \nreturn ".$this->exportArray($array).";\n";
    }

    /**
     * @param string $name
     * @param string $symbol
     *
     * @return mixed
     */
    public function slug(string $name, string $symbol = '-')
    {
        $text = preg_replace_callback('/([A-Z])/', function (&$text) use ($symbol) {
            return $symbol.strtolower($text[1]);
        }, $name);

        return str_replace('_', $symbol, ltrim($text, $symbol));
    }
    

    /**
     * @param array $array
     * @param int   $level
     *
     * @return string
     */
    public function exportArray(array &$array, $level = 1)
    {
        $start = '[';
        $end = ']';

        $txt = "$start\n";

        foreach ($array as $k => &$v) {
            if (is_array($v)) {
                $pre = is_string($k) ? "'$k' => " : "$k => ";

                $txt .= str_repeat(' ', $level * 4).$pre.$this->exportArray($v, $level + 1).",\n";

                continue;
            }
            $t = $v;

            if ($v === true) {
                $t = 'true';
            } elseif ($v === false) {
                $t = 'false';
            } elseif ($v === null) {
                $t = 'null';
            } elseif (is_string($v)) {
                $v = str_replace("'", "\\'", $v);
                $t = "'$v'";
            }

            $pre = is_string($k) ? "'$k' => " : "$k => ";

            $txt .= str_repeat(' ', $level * 4)."{$pre}{$t},\n";
        }

        return $txt.str_repeat(' ', ($level - 1) * 4).$end;
    }

}