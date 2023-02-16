<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Reinbier\LaravelHoliday\Tests\TestCase;

uses(TestCase::class, LazilyRefreshDatabase::class)->in(__DIR__);
