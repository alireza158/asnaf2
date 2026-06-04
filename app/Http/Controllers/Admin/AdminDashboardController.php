<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Services\ContentApprovalService;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(ContentApprovalService $approvalService): View
    {
        return view('admin.dashboard', [
            'pendingApprovals' => $approvalService->pendingItems(8),
            'unreadContactMessagesCount' => ContactMessage::query()->unread()->count(),
        ]);
    }
}
