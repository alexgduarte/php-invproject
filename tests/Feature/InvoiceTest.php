<?php

use App\Enums\InvoiceTypeEnum;
use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\User;

beforeEach(function() {

});

test('set invoice type to session and redirect to create', function () {
    $user = User::factory()->create();

    @unlink(base_path("dbs/tenant_testing.sqlite"));
    $tenant = \App\Models\Tenant::create(['id'=>'testing','email'=>'test@test.test']);
    $tenant->createDomain("localhost");
    tenancy()->initialize($tenant);

    $config = \App\Models\Config::factory()->create();

    /**
     * \Tests\TestCase $this
     */
    $response = $this->actingAs($user)
            ->get('/invoices/create/'. InvoiceTypeEnum::Debit->value);

    $response->assertStatus(302);
    $response->assertRedirect("/invoices/create");
    $response->assertSessionHas("invoice.type", InvoiceTypeEnum::Debit->value);
});

test('mark invoice as paid', function () {
    $user = User::factory()->create();

    @unlink(base_path("dbs/tenant_testing.sqlite"));
    $tenant = Tenant::create(['id'=>'testing','email'=>'test@test.test']);
    $tenant->createDomain("localhost");
    tenancy()->initialize($tenant);

    $invoice = Invoice::create([
        'invoice_number' => '1',
        'invoice_series' => 'INV',
        'invoice_currency' => 'EUR',
        'document_date' => now()->toDateString(),
        'paid' => false,
    ]);

    $response = $this->actingAs($user)
        ->patch("/invoices/{$invoice->id}/mark-paid");

    $response->assertRedirect("/invoices");
    expect($invoice->fresh()->paid)->toBeTrue();
});
