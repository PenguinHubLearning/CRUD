<?php

namespace Backpack\CRUD\app\Library\CrudPanel\Traits;

trait HasViewNamespaces
{
    private $viewNamespaces = [];

    /**
     * Return the namespaces stored for the given domain.
     *
     * @param  string  $domain  (eg. fields, filters, buttons)
     * @return array
     */
    private function getViewNamespacesFor(string $domain)
    {
        return $this->viewNamespaces[$domain] ?? [];
    }

    /**
     * Return the resulting array after merging the base namespaces
     * with the ones stored for the given domain.
     *
     * @param  string  $domain  (eg. fields, filters, buttons)
     * @param  null|string  $viewNamespacesFromConfigKey
     * @return array
     */
    public function getAllViewNamespacesFor(string $domain, string $viewNamespacesFromConfigKey = null)
    {
        $viewNamespacesFromConfig = $this->getViewNamespacesFromConfigFor($domain, $viewNamespacesFromConfigKey);

        return array_unique(array_merge($viewNamespacesFromConfig, $this->getViewNamespacesFor($domain)));
    }

    /**
     * Adds multiple namespaces to a given domain.
     *
     * @param  string  $domain  (eg. fields, filters, buttons)
     * @param  array  $viewNamespaces
     * @return void
     */
    public function addViewNamespacesFor(string $domain, array $viewNamespaces)
    {
        foreach ((array) $viewNamespaces as $viewNamespace) {
            $this->addViewNamespace($domain, $viewNamespace);
        }
    }

    /**
     * Add a new view namespace for a given domain.
     *
     * @param  string  $domain  (eg. fields, filters, buttons)
     * @param  string  $viewNamespace
     * @return void
     */
    public function addViewNamespaceFor(string $domain, string $viewNamespace)
    {
        $domainNamespaces = $this->viewNamespaces[$domain] ?? [];
        if (! in_array($viewNamespace, $domainNamespaces)) {
            $this->viewNamespaces[$domain][] = $viewNamespace;
        }
    }

    /**
     * Return the config view_namespace key for the given domain.
     *
     * @param  string  $domain
     * @param  null|string  $customConfigKey
     * @return array
     */
    private function getViewNamespacesFromConfigFor(string $domain, null|string $customConfigKey)
    {
        return config($customConfigKey ?? 'backpack.crud.view_namespaces.'.$domain) ?? [];
    }
}
