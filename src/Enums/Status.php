<?php

namespace Foxws\Algos\Enums;

enum Status: string
{
    case Success = 'success';
    case Failed = 'failed';
    case Skipped = 'skipped';
}
