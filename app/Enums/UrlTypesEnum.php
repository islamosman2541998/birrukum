<?php

namespace App\Enums;
 
class UrlTypesEnum extends Enum
{


    // public const TAG = 'tag';
    public const PAGES = 'pages';
    public const CATEGORIES = 'categories';
    public const PROJECTS = 'projects';
    // public const ARTICLES = 'articles';
    // public const SERVICES = 'services';

    // public const ALL_ARTICLES = 'all articles';
    // public const ALL_SERVICES = 'all services';
    // public const PORTFOLIO = 'portfolio';
    public const CONTACTUS = 'contact us';
    public const VOLUNTEERING = 'volunteering';


    public static function values() : array{

        return [
            // static::TAG => 'tag',
            static::PAGES => 'pages',
            static::CATEGORIES => 'categories',
            static::PROJECTS => 'projects',
            // static::ARTICLES => 'articles',
            // static::SERVICES => 'services',

            // static::ALL_ARTICLES => 'all articles',
            // static::ALL_SERVICES => 'all services',
            // static::PORTFOLIO => 'portfolio',
            static::CONTACTUS => 'contact us',
            static::VOLUNTEERING => 'volunteering',
        ];

    }


}
