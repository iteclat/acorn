<?php

namespace Roots\Clover\Concerns;

use Roots\Clover\Meta;

trait Lifecycle
{
    public function lifecycle(Meta $meta)
    {
        if (method_exists($this, 'activate')) {
            add_action("activate_{$meta->basename}", [$this, 'activate']);
        }

        if (method_exists($this, 'upgrade')) {
            add_action("activate_{$meta->basename}", [$this, 'upgrade']);
        }

        if (method_exists($this, 'deactivate')) {
            add_action("deactivate_{$meta->basename}", [$this, 'deactivate']);
        }

        if (method_exists($this, 'uninstall')) {
            add_action("uninstall_{$meta->basename}", [$this, 'uninstall']);
        }

        if (method_exists($this, 'beforeUninstall')) {
            add_action('pre_uninstall_plugin', function ($plugin, $uninstallable_plugins) use ($meta) {
                if ($meta->basename === $plugin) {
                    $this->beforeUninstall($plugin, $uninstallable_plugins);
                }
            }, 10, 2);
        }
    }
}
