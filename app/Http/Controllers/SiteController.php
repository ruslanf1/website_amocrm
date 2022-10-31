<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExchangeRequest;
use App\Http\Requests\LeadRequest;
use App\Http\Requests\StatusRequest;
use App\Http\Requests\StoreRequest;

class SiteController extends Controller
{
    public function exchange(ExchangeRequest $request)
    {
        $data = $request->validated();
    }

    public function status(StatusRequest $request)
    {
        $data = $request->validated();
    }

    public function lead(LeadRequest $request)
    {
        $data = $request->validated();
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
    }
}
