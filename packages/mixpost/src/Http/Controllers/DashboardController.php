<?php

namespace Inovector\Mixpost\Http\Controllers;

use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Inovector\Mixpost\Enums\PostStatus;
use Inovector\Mixpost\Http\Resources\AccountResource;
use Inovector\Mixpost\Models\Account;
use Inovector\Mixpost\Models\Post;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Dashboard', [
            'accounts' => fn () => AccountResource::collection(Account::oldest()->get())->resolve(),
            // KPI tiles on the dashboard: one grouped query, every status present (0 when none).
            'stats' => fn () => $this->postStats(),
        ]);
    }

    private function postStats(): array
    {
        $counts = Post::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $count = fn (PostStatus $status) => (int) ($counts[$status->value] ?? 0);

        return [
            'scheduled' => $count(PostStatus::SCHEDULED),
            'published' => $count(PostStatus::PUBLISHED),
            'drafts' => $count(PostStatus::DRAFT),
            'failed' => $count(PostStatus::FAILED),
        ];
    }
}
