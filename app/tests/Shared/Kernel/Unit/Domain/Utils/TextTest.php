<?php

declare(strict_types=1);

namespace Tests\App\Shared\Kernel\Unit\Domain\Utils;

use App\Shared\Kernel\Domain\Utils\Text;
use PHPUnit\Framework\Attributes\Test;
use Tests\App\Shared\Kernel\Unit\UnitTestCase;

final class TextTest extends UnitTestCase
{
    #[Test]
    public function shouldReturnUnderScoreFromSnakeCase(): void
    {
        $this->assertEquals(
            'IT_SHOULD_RETURN_CAPS_UNDER_SCORE',
            Text::snakeCasetoCapsUnderScore('ItShouldReturnCapsUnderScore')
        );
    }
}
