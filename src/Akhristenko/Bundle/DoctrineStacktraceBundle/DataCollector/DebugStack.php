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
            $tracebackString = $e->getTraceAsString();
            $this->queries[++$this->currentQuery] = array('sql' => $sql, 'params' => $params, 'types' => $types, 'executionMS' => 0, 'stacktrace' => $tracebackString);
        }
    }
}