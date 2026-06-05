<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CongratulationMessage;
use Illuminate\View\View;

class CongratulationMessageController extends Controller
{
    public function show(string $slug): View
    {
        $message = CongratulationMessage::query()
            ->published()
            ->with('union')
            ->where('slug', $slug)
            ->firstOrFail();

        abort_if($message->union && ! $message->union->congratulations_enabled, 404);

        return view('frontend.congratulation_messages.show', compact('message'));
    }
}
