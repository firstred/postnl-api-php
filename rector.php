<?php
/** @noinspection PhpArgumentWithoutNamedIdentifierInspection */

declare(strict_types=1);

use Rector\TypeDeclaration\Rector\Property\CompleteVarDocTypePropertyRector;
use Rector\TypeDeclaration\Rector\Property\PropertyTypeDeclarationRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->set(PropertyTypeDeclarationRector::class);
    $services->set(CompleteVarDocTypePropertyRector::class);
};
