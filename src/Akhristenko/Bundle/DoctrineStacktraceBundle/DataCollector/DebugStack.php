<?php

namespace Akhristenko\Bundle\DoctrineStacktraceBundle\DataCollector;

class DebugStack extends \Doctrine\DBAL\Logging\DebugStack
{

    /**
     * {@inheritdoc}
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        if ($this->enabled) {
            $e = new \Exception();
            $this->start = microtime(true);
            $tracebackArray = $this->prepareBacktraceData();
            $this->queries[++$this->currentQuery] = ['sql' => $sql, 'params' => $params, 'types' => $types, 'executionMS' => 0, 'stacktraceArray' => $tracebackArray];
        }
    }

    protected function prepareBacktraceData()
    {
        $backtraceData = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        return $backtraceData;
    }
}