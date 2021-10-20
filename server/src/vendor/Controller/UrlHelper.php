<?php

namespace Aloefflerj\FedTheDog\Controller;

trait UrlHelper
{
    /**
     * Get current url path
     *
     * @return string|null
     */
    public function getUriPath(): ?string
    {
        return $_SERVER['REQUEST_URI'] ?? null;
    }
}