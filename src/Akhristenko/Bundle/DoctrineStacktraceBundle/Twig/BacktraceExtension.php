<?php

namespace Akhristenko\Bundle\DoctrineStacktraceBundle\Twig;

class BacktraceExtension extends \Twig_Extension
{
    /**
     * @var \Twig_Environment
     */
    protected $environment;

    protected $appRoot;

    protected $excludes = [];

    /**
     * {@inheritDoc}
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function __construct($appRoot)
    {
        $this->appRoot = $appRoot;
    }

    public function setExcludes($excludes)
    {
        $this->excludes = $excludes;
    }

    public function getBacktraceView(array $backtrace)
    {
        $result = [];
        $appRoot = realpath($this->appRoot.'/../');

        foreach ($backtrace as $k => $v) {
            $item = [];
            if (isset($v['file'])) {
                $item['location'] = str_replace($appRoot, '', $v['file']).'('.$v['line'].')';
                if (strpos($item['location'], '/vendor') === 0) {
                    $item['hidden'] = true;
                    foreach ($this->excludes as $exclude) {
                        if (preg_match('#^/vendor/'.$exclude.'#', $item['location'])) {
                            $item['hidden'] = false;
                            break;
                        }
                    }
                } else {
                    $item['hidden'] = false;
                }
            } else {
                $item['location'] = '[internal function]';
                $item['hidden'] = true;
            }

            if (isset($v['type'])) {
                $item['element'] = $v['class'].$v['type'].$v['function'].'()';
            } else {
                $item['element'] = $v['function'].'()';
            }
            $result[] = $item;
        }


        return $this->environment->render('AkhristenkoDoctrineStacktraceBundle:Backtrace:view.html.twig', [
            'backtrace' => $backtrace,
            'result' => $result
        ]);
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            'doctrine_backtrace_view' => new \Twig_Function_Method($this, 'getBacktraceView', ['is_safe' => ['html']]),
        ];
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'akhristenko_doctrine_stacktrace_view';
    }

}
