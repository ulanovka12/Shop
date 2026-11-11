<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SalesReportService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(SalesReportService $salesReportService): View
    {
        // Просто просит сервис выдать готовый массив и передает его в шаблон.
        return view('admin.dashboard', [
            'report' => $salesReportService->getLastWeekReport(),
        ]);
    }
}
