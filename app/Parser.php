<?php

namespace App;

use Exception;

final class Parser
{
    public function parse(string $inputPath, string $outputPath): void
    {
        $csv = new \SplFileObject($inputPath, 'r');
        $csv->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY | \SplFileObject::DROP_NEW_LINE | \SplFileObject::READ_AHEAD);

        $data = [];
        foreach ($csv as [$url, $date]) {
            $url  = \substr($url, 19);
            $date = \substr($date, 0, 10);
            $data[$url][$date] = ($data[$url][$date] ?? 0) + 1;
        }

        foreach ($data as &$items) {
            \ksort($items);
        }

        \file_put_contents($outputPath, \json_encode($data, flags: \JSON_PRETTY_PRINT));
    }
}
