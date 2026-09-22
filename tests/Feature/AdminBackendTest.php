<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminBackendTest extends TestCase
{
    public function test_admin_dashboard_is_accessible(): void
    {
        $response = $this->get('/admin');

        $response->assertOk();
        $response->assertSee('Admin Dashboard');
    }

    public function test_admin_products_page_is_accessible(): void
    {
        $response = $this->get('/admin/products');

        $response->assertOk();
        $response->assertSee('Products');
    }
}
