<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;

use Tests\TestCase;

class DatabaseConfigurationTest extends TestCase
{
    public function test_the_test_environment_uses_a_separate_database(): void
    {
        $this->assertSame(
            'portal_berita_testing',
            config('database.connections.mysql.database')
        );

        $this->assertSame(
            'portal_berita_testing',
            DB::connection()->getDatabaseName(),
        );
    }
}
