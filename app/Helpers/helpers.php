<?php

function getRandomString($n)
{
    do {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        $alreadyExiste = \App\Models\Paste::where('not_listed_id', $randomString)->first();

    } while ($alreadyExiste != null);


    return $randomString;
}
