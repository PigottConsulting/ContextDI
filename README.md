# ContextDI
Allows for context dependency injection.

# Concept
The concept is that there is often the need to know the context of the request.  A context can be made up of one or more different facets such as User, Customer, Domain, GeoLocation, User IP, The presence of an outstanding quote, etc

The bundle builds on the existing Symfony DI system by allowing custom providers and consumers to be defined and then tagghed with what the need or what they can provide.

The system does not load the context until it is needed.

There is cache so that the context is not recomputed everytime a service wants to use it.

# Consumer
A consumer service must implement the ```TechData\ContextDiBundle\Interfaces\ContextConsumerInterface``` interface and then be tagged with one or more tags of name "context_consumer" which it wants to consume.  The tag needs to have an attribute of "context_name" which is a string that specifies which type of context it is looking for.

# Provider
A provider service must implement the ```TechData\ContextDiBundle\Interfaces\ContextProviderInterface``` interface and then be tagged with a single tag of name "context_provider" which it wants to provide.  The tag needs to have an attribute of "context_name" which is a string that specifies which type of context being provided.

# Cache
There is a cache which is checked prior to attempting to resolve the context.  if the context is already available in the cache, it will be used.  The default cache service caches the contexts per request.

# Configuiration
The available types of context need to be specified (or "registered") in the main config file ("config.yml").  This is done by specifying the name of an interface or class which will be provided by the provider when the context is resolved. This ensures only certain contexts are available, and the context types are known to the consumer which will need to use them.  Example.  
```
tech_data_context_di:
    available_contexts:
        user: Vendor\Bundle\Interfaces\UserInterface
        customer: Vendor\Bundle\Entity\CustomerInterface
```
Optionally, the cache type can be switched to a different cache service which implements the ```TechData\ContextDiBundle\Interfaces\ContextCacheInterface```.  This can be done by specifying the cache service name in the config as shown below.  This defaults to "tech_data_context_di.cache.single_request" which is a per request cache.
```
tech_data_context_di:
    available_contexts:
        user: Vendor\Bundle\Interfaces\UserInterface
        customer: Vendor\Bundle\Entity\CustomerInterface
    cache_service: some.custom.cache.service.name
```

# Included Providers
Some providers for common use cases will be added soon.
