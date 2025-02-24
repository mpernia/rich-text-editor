<?php

namespace Src\Domain\Contracts\Actions;

interface DestroyerAction
{
    public static function destroy(int|string $value) : void;
}
