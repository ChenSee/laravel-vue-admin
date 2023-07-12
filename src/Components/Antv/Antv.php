<?php

namespace SmallRuralDog\Admin\Components\Antv;

class Antv extends Line
{
    protected $componentName = "Antv";
    protected $canvasId;
    protected $data;
    protected $config;
    protected $funName = "Area";


    public static function make()
    {
        return new Antv();
    }

    /**
     * 方法名
     * @param mixed $name
     * @return $this
     */
    public function funName($name)
    {
        $this->funName = $name;
        return $this;
    }
}
