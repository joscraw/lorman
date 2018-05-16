<?php

namespace App\TwigExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Simple Twig helper to find the error for a given field and render the error message
 *
 * Class ErrorExtension
 * @package App\TwigExtension
 *
 * @author Josh Crawmer <jcrawmer@lorman.com> - wishful thinking ;)
 */
class ErrorExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('error', array($this, 'errorFilter')),
        );
    }

    public function errorFilter($errors, $field)
    {
        $messages = [];
        foreach ($errors as $error) {
            if ($field === $error->getPropertyPath()) {
                $messages[] = $error->getMessage();
            }
        }

        return implode(',', $messages);
    }

}