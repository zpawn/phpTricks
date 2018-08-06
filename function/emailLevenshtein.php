<?php

function emailLevenshtein () {

    $db = $emails = [];

    $emailDomains = [
        'mail.ru',
        'gmail.com',
        'yandex.ru',
        'yandex.ua',
        'yandex.com',
        'ukr.net',
        'rambler.ru',
        'hotmail.com',
        'yahoo.com',
        'i.ua',
        'bigmir.net',
        'meta.ua',
        'mail.ua',
        'mail.com',
        'icloud.com',
        'me.com',
        'gmail.ru',
        'email.ua',
    ];

    $db = db_get_array('SELECT user_id, email FROM cscart_users LIMIT 1000');

    $emails = array_reduce($db, function ($result, $email) use ($emailDomains) {
        list($name, $domain) = explode('@', $email['email']);

        $shortest = -1;
        $closest = '';

        foreach ($emailDomains as $baseDomain) {
            $lev = levenshtein($domain, $baseDomain);

            if ($lev == 0) {
                $closest = $baseDomain;
                $shortest = 0;
                break;
            }

            if ($lev <= $shortest || $shortest < 0) {
                $closest = $baseDomain;
                $shortest = $lev;
            }
        }

        if (($shortest > 0) && ($shortest < 3)) {
            $result[] = $stat = array_merge($email, [
                'domain' => $domain,
                'closest' => $closest,
                'shortest' => $shortest
            ]);;
        }

        return $result;
    });

    return $emails;
}
