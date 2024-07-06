<?php
spl_autoload_register(function ($class) {
    // Prefix for Stripe classes
    $prefix = 'Stripe\\';

    // Base directory for the Stripe namespace
    $base_dir = __DIR__ . '/stripe-php/lib/';

    // Does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // No, move to the next registered autoloader
        return;
    }

    // Get the relative class name
    $relative_class = substr($class, $len);

    // Replace the namespace prefix with the base directory, replace namespace separators with directory separators, and append with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});
