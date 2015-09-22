<?php

/*
 * This file is part of the WPFoundation library.
 *
 * Copyright (c) 2015 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPFoundation\Configuration\Translations;

/**
 * Class of translations that implements the interface with
 * "trans" method. This class is strongly coupled to the WPML.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class Translations implements TranslationsInterface
{
    /**
     * Domain translation name.
     *
     * This variable avoids the use of global
     * constants and it's extensible in an easy way.
     *
     * @var string
     */
    protected static $domain = 'WP Foundation default domain';

    /**
     * {@inheritdoc}
     */
    public static function trans($key)
    {
        self::isWpmlDefined();

        if (false === icl_t(false === self::domain(), $key)) {
            icl_register_string(self::domain(), $key, $key);
        }

        return __($key, self::domain());
    }

    /**
     * Returns the domain defined into TRANSLATION_DOMAIN global
     * const or otherwise the value of domain static variable.
     *
     * @return string
     */
    private static function domain()
    {
        return defined('TRANSLATION_DOMAIN') ? TRANSLATION_DOMAIN : self::$domain;
    }

    /**
     * Checks if the WMPL is available.
     *
     * @throws \Exception when the WPML is not installed.
     */
    private static function isWpmlDefined()
    {
        if (false === function_exists('icl_t') || false === function_exists('icl_register_string')) {
            throw new \Exception('This class needs WPML, please install it before using Translations class');
        }
    }
}
