<?php

declare(strict_types=1);

namespace Larastan\Larastan\ReturnTypes;

use Illuminate\Contracts\Auth\Guard;
use Larastan\Larastan\Concerns;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

use function count;

final class GuardExtension implements DynamicMethodReturnTypeExtension
{
    use Concerns\HasContainer;
    use Concerns\LoadsAuthModel;

    /**
     * {@inheritdoc}
     */
    public function getClass(): string
    {
        return Guard::class;
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection->getName() === 'user';
    }

    public function getTypeFromMethodCall(
        MethodReflection $methodReflection,
        MethodCall $methodCall,
        Scope $scope
    ): ?Type {
        $config = $this->getContainer()->get('config');
        $authModel = null;

        if ($config !== null) {
            $guard = $this->getGuardFromMethodCall($scope, $methodCall);
            $authModel = $this->getAuthModel($config, $guard);
        }

        if ($authModel === null) {
            return null;
        }

        return TypeCombinator::addNull(new ObjectType($authModel));
    }

    private function getGuardFromMethodCall(Scope $scope, MethodCall $methodCall): ?string
    {
        if (
            ! ($methodCall->var instanceof StaticCall) &&
            ! ($methodCall->var instanceof MethodCall) &&
            ! ($methodCall->var instanceof FuncCall)
        ) {
            return null;
        }

        if (count($methodCall->var->args) !== 1) {
            return null;
        }

        $guardType = $scope->getType($methodCall->var->getArgs()[0]->value);
        $constantStrings = $guardType->getConstantStrings();

        if (count($constantStrings) !== 1) {
            return null;
        }

        return $constantStrings[0]->getValue();
    }
}
