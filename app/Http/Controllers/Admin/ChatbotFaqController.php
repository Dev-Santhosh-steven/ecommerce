<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotFaq;
use App\Models\ChatbotLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatbotFaqController extends Controller
{
    /**
     * Knowledge base + questions the bot couldn't answer.
     */
    public function index()
    {
        $faqs = ChatbotFaq::orderBy('sort_order')->orderBy('question')->paginate(25);

        $unanswered = ChatbotLog::query()
            ->where('answered', false)
            ->select('message', DB::raw('COUNT(*) as times'), DB::raw('MAX(created_at) as last_asked'))
            ->groupBy('message')
            ->orderByDesc('last_asked')
            ->limit(20)
            ->get();

        $stats = [
            'total' => ChatbotLog::count(),
            'answered' => ChatbotLog::where('answered', true)->count(),
            'week' => ChatbotLog::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        return view('admin.chatbot.index', compact('faqs', 'unanswered', 'stats'));
    }


    public function create(Request $request)
    {
        $faq = new ChatbotFaq([
            'question' => $request->query('question'),
            'status' => true,
        ]);

        return view('admin.chatbot.create', compact('faq'));
    }


    public function store(Request $request)
    {
        $faq = ChatbotFaq::create($this->validated($request));

        // The question is answered now; clear it from the "unanswered" list.
        ChatbotLog::where('answered', false)->where('message', $request->input('from_log'))->delete();

        return redirect()
            ->route('admin.chatbot.index')
            ->with('success', "Answer \"{$faq->question}\" added. The chatbot will use it right away.");
    }


    public function edit(ChatbotFaq $chatbot)
    {
        return view('admin.chatbot.edit', ['faq' => $chatbot]);
    }


    public function update(Request $request, ChatbotFaq $chatbot)
    {
        $chatbot->update($this->validated($request));

        return redirect()
            ->route('admin.chatbot.index')
            ->with('success', 'Answer updated successfully.');
    }


    public function destroy(ChatbotFaq $chatbot)
    {
        $chatbot->delete();

        return redirect()
            ->route('admin.chatbot.index')
            ->with('success', 'Answer deleted successfully.');
    }


    /**
     * Dismiss an unanswered question without adding an answer.
     */
    public function dismissLog(Request $request)
    {
        ChatbotLog::where('answered', false)->where('message', $request->input('message'))->delete();

        return back()->with('success', 'Question dismissed.');
    }


    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'keywords' => ['nullable', 'string', 'max:2000'],
            'answer' => ['required', 'string', 'max:3000'],
            'button_text' => ['nullable', 'string', 'max:60', 'required_with:button_url'],
            'button_url' => ['nullable', 'string', 'max:255', 'required_with:button_text'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        return [
            ...$validated,
            'show_as_suggestion' => $request->boolean('show_as_suggestion'),
            'status' => $request->boolean('status'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ];
    }
}
