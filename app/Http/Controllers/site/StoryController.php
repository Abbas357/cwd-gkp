<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\User;

class StoryController extends Controller
{
    public function getStories(Request $request)
    {
        $seenUserIds = $request->input('seenUserIds', []);
        $expiredUsers = [];

        if (!empty($seenUserIds)) {
            $usersWithExpiredStories = User::whereIn('id', $seenUserIds)
                ->whereDoesntHave('stories', function ($query) {
                    $query->where('created_at', '>=', now()->subDay());
                })
                ->pluck('id')
                ->toArray();

            $expiredUsers = $usersWithExpiredStories;
        }

        $users = User::whereHas('stories', function ($query) {
            $query->where('created_at', '>=', now()->subDay());
        })->with(['stories' => function ($query) {
            $query->whereNotNull('published_at')->where('created_at', '>=', now()->subDay());
        }])->get();

        if ($users->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'result' => 'No stories available.',
                ],
                'expiredUsers' => $expiredUsers,
            ]);
        }

        $storiesData = [];

        foreach ($users as $user) {
            $items = [];

            foreach ($user->stories as $story) {
                $items[] = [
                    'id'       => $story->id,
                    'type'     => 'photo',
                    'length'   => 5,
                    'src'      => $story->getFirstMediaUrl('stories'),
                    'preview'  => $story->getFirstMediaUrl('stories', 'thumb'),
                    'link'     => 'javascript:void(false)',
                    'linkText' => $story->title . ' <div class=story-views-count>Views: ' . ' ' . $story->views . '</div>',
                    'time'     => $story->created_at->timestamp,
                ];
            }

            $storiesData[] = [
                'id'          => $user->id,
                'photo'       => getProfilePic($user),
                'name'        => $user->designation,
                'link'        => null,
                'lastUpdated' => $user->stories->max('created_at')->timestamp,
                'items'       => $items,
            ];
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'result' => $storiesData,
            ],
            'expiredUsers' => $expiredUsers,
        ]);
    }

    public function incrementSeen($userId)
    {
        $stories = User::find($userId)->stories;

        foreach ($stories as $story) {
            if ($story->created_at >= Carbon::now()->subHours(24)) {
                $story->views += 1;

                if (!$story->save()) {
                    return response()->json(['success' => 'false'], 500);
                }
            }
        }
        return response()->json(['success' => 'true', 200]);
    }
}
