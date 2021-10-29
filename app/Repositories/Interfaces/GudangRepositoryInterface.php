<?php

namespace App\Repositories\Interfaces;

use App\Models\Gudang;
use App\Http\Requests\Admin\GudangRequest;

interface GudangRepositoryInterface
{
  public function index();

  public function store(GudangRequest $request);

  public function update(GudangRequest $request, Gudang $gudang);

  public function destory(Gudang $gudang);
}
