<?php

function getStatusWork(int $value)
{
    return array_search ($value, WORK_STATUS);
}