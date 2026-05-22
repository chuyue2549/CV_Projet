<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Database\DatabaseConnection;

/**
 * Tests the DatabaseConnection class.
 */
class DatabaseConnectionTest extends TestCase
{
    /**
     * Ensures that DatabaseConnection creates a PDO instance.
     */
    public function testConnectionReturnsPDO()
    {
        $db = new DatabaseConnection();
        $this->assertInstanceOf(PDO::class, $db->getDb());
    }
}
