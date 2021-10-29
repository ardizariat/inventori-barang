<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gudang;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GudangRequest;
use App\Repositories\Interfaces\GudangRepositoryInterface;

class GudangController extends Controller
{
    private $gudangRepository;

    public function __construct(GudangRepositoryInterface $gudangRepository)
    {
        $this->gudangRepository = $gudangRepository;
    }

    public function index()
    {
        if (request()->ajax()) {
            return $this->gudangRepository->index();
        }

        $title = 'Gudang';
        return view('admin.gudang.index', compact(
            'title',
        ));
    }

    public function store(GudangRequest $request)
    {
        return $this->gudangRepository->store($request);
    }

    public function show(Gudang $gudang)
    {
        return response()->json([
            'data' => $gudang
        ], 200);
    }

    public function update(GudangRequest $request, Gudang $gudang)
    {
        return $this->gudangRepository->update($request, $gudang);
    }

    public function destroy(Gudang $gudang)
    {
        return $this->gudangRepository->destory($gudang);
    }
}
