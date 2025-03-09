<?php

function snakeCaseToText($text)
{
    return implode(' ', explode('_', $text));
}

