<?php

namespace Foxws\Algos\Enums;

enum Status: string
{
    case Success = 'success';
    case Warning = 'warning';
    case Failed = 'failed';
    case Skipped = 'skipped';
}
