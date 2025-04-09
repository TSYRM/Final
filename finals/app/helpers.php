<?php

if (!function_exists('inertia')) {
    /**
     * Inertia helper function
     *
     * @param string $component
     * @param array $props
     * @return \Inertia\Response
     */
    function inertia($component, $props = [])
    {
        return app(\Inertia\Inertia::class)->render($component, $props);
    }
} 