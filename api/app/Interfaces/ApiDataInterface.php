<?php

namespace App\Interfaces;

interface ApiDataInterface
{
    public function get($url): array;
}