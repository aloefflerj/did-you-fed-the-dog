<?php

namespace Aloefflerj\FedTheDog\Controller;

trait UrlHelper
{
    /**
     * Get current url path
     *
     * @return string|null
     */
    public function getUrlPath(): ?string
    {
        return $_SERVER['REQUEST_URI'] ?? null;
    }
}