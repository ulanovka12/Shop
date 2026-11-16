<?php

namespace Tests\Unit;

use App\Services\DeliveryService;
use PHPUnit\Framework\TestCase;

class DeliveryServiceTest extends TestCase
{
    public function test_delivery_is_free_from_5000(): void
    {
        // Arrange
        $service = new DeliveryService();

        // Act
        $result = $service->calculate(5000);

        // Assert
        $this->assertSame(0, $result);
    }
}
