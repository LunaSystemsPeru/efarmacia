<?php

$mask = "files/*.xml";
array_map("unlink", glob($mask));