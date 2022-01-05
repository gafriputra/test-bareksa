<?php

namespace App\Http\Controllers;

use Backpack\NewsCRUD\app\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApiController extends Controller
{
    public function index()
    {
        $data = Cache::remember('all-article', 60*60, function(){
            return Article::with(
                        [
                            'category' => function($q){
                                $q->with(['parent', 'children']);
                            },
                            'tags'
                        ]
                    )->get();
        });
        return ResponseFormatter::success($data);
    }

    public function detail(Request $request, $slug)
    {
        $data = Cache::remember($slug, 60*60, function() use($slug){
            return Article::with(
                [
                    'category' => function($q) use($slug){
                        $q->with([
                            'parent', 'children',
                            'articles' => function($q) use($slug) {
                                // this is similars article
                                $q->where('slug', '!=', $slug);
                            }
                        ]);
                    },
                    'tags'
                ]
            )->where('slug', $slug)->first();
        });
        return ResponseFormatter::success($data);
    }
}
