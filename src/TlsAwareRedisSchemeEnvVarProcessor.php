<?php

namespace WeAreKadence;

use Symfony\Component\DependencyInjection\EnvVarProcessorInterface;

class TlsAwareRedisSchemeEnvVarProcessor implements EnvVarProcessorInterface
{
    public function getEnv(string $prefix, string $name, \Closure $getEnv): string
    {
        $envVar = $getEnv($name);

        $parts = explode('://', $envVar);

        if (count($parts) > 1) {
            [$scheme, $uri] = $parts;
            if ('rediss' === $scheme) {
                return 'tls://'.$uri;
            } else {
                return $uri;
            }
        }

        return $envVar;
    }

    /**
     * @return string[]
     */
    public static function getProvidedTypes(): array
    {
        return [
            'tlsAwareRedisScheme' => 'string',
        ];
    }
}
