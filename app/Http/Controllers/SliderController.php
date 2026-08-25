<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use App\Information;
use App\Promo;
use App\News;
use App\Ref;
use Illuminate\Support\Facades\Cache;

class SliderController extends Controller
{
    public function main($id)
    {
        $slider = Cache::remember(
            'main_slider',
            now()->addMinutes(5),
            function () {
                return Slider::where('is_active', 1)->get();
            }
        );

        return response()->json([
            'success' => true,
            'message' => 'List Slider',
            'data' => $slider
        ]);
    }


    public function information()
    {
        $info = Cache::remember(
            'information_active',
            now()->addMinutes(5),
            function () {
                return Information::where('is_active', 1)->get();
            }
        );

        return response()->json([
            'success' => true,
            'message' => 'list information',
            'data' => $info
        ]);
    }


    public function promo()
    {
        $promo = Cache::remember(
            'promo_active',
            now()->addMinutes(5),
            function () {
                return Promo::where('is_active', 1)->get();
            }
        );

        return response()->json([
            'success' => true,
            'message' => 'list promo',
            'data' => $promo
        ]);
    }


    public function news()
    {
        $news = Cache::remember(
            'news_active',
            now()->addMinutes(5),
            function () {
                return News::where('is_active', 1)->get();
            }
        );

        return response()->json([
            'success' => true,
            'message' => 'list berita',
            'data' => $news
        ]);
    }


    public function menu()
    {
        $menu = Cache::remember(
            'main_menu',
            now()->addMinutes(5),
            function () {
                return \App\MainMenu::with('icon_items')->get();
            }
        );

        return response()->json([
            'success' => true,
            'message' => 'list icon',
            'data' => $menu
        ]);
    }


    public function menu2($userid)
    {
        $user = \App\User::with('kelas.tingkat')->find($userid);

        if (!$user || !$user->kelas || !$user->kelas->tingkat) {
            return response()->json([
                'success' => false,
                'message' => 'User atau tingkat tidak ditemukan.',
            ], 404);
        }

        $tingkatId = $user->kelas->tingkat->id;

        $cacheKey = 'main_menu_tingkat_' . $tingkatId;

        $menu = Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($tingkatId) {

                return \App\MainMenu::with([
                    'icon_items' => function ($query) use ($tingkatId) {
                        $query->where('tingkat_id', $tingkatId);
                    }
                ])->get();
            }
        );

        return response()->json([
            'success' => true,
            'message' => 'list icon',
            'data' => $menu
        ]);
    }


    public function refList(Request $request)
    {
        $idKelas = $request->input('id_kelas');
        $limit = $request->input('limit');

        $cacheKey = 'ref_list_kelas_' . $idKelas . '_limit_' . $limit;

        $rows = Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($idKelas, $limit) {

                $ref = Ref::where('is_active', 1)->get();

                $rows = [];
                $baris = 1;

                foreach ($ref as $k) {

                    $kelas = explode(",", $k->id_kelas);

                    $cek = array_search(
                        (string) $idKelas,
                        $kelas,
                        true
                    );

                    if ($cek !== false) {

                        if ($limit == 1) {

                            if ($baris < 7) {
                                $rows[] = [
                                    'id' => $k->id,
                                    'ref_title' => $k->ref_title,
                                    'ref_url' => $k->ref_url,
                                    'ref_image' => $k->ref_image,
                                    'id_kelas' => $k->id_kelas,
                                ];
                            }

                        } else {

                            $rows[] = [
                                'id' => $k->id,
                                'ref_title' => $k->ref_title,
                                'ref_url' => $k->ref_url,
                                'ref_image' => $k->ref_image,
                                'id_kelas' => $k->id_kelas,
                            ];
                        }

                        $baris++;
                    }
                }

                return $rows;
            }
        );

        return response()->json([
            'success' => true,
            'data' => $rows
        ]);
    }
}