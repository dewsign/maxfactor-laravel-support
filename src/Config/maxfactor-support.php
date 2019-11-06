<?php

return [
    'allowedDomains' => explode(',', env('ALLOWED_DOMAINS', '')),
    'enforceDomainsStatusCodes' => [
        \Symfony\Component\HttpFoundation\Response::HTTP_OK,
        \Symfony\Component\HttpFoundation\Response::HTTP_MOVED_PERMANENTLY,
        \Symfony\Component\HttpFoundation\Response::HTTP_TEMPORARY_REDIRECT,
        \Symfony\Component\HttpFoundation\Response::HTTP_PERMANENTLY_REDIRECT,
    ],
    'homeBreadcrumb' => 'Home',
    'canViewInactive' => true,
];
