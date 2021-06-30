<?php

function kode($value, $threshold = null)
{
  return sprintf("%0" . $threshold . "s", $value);
}
