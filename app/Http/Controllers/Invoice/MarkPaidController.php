<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Services\InvoicesService;

class MarkPaidController extends Controller
{
    public function __construct(
        private readonly InvoicesService $service,
    ) {
    }

    public function __invoke($id)
    {
        return $this->service->markPaid($id);
    }
}
