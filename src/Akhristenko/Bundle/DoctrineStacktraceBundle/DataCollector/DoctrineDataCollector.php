<?php

namespace Akhristenko\Bundle\DoctrineStacktraceBundle\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DoctrineDataCollector extends \Doctrine\Bundle\DoctrineBundle\DataCollector\DoctrineDataCollector
{

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        parent::collect($request, $response, $exception);
    }
}