<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExchangeRequest;
use App\Http\Requests\LeadRequest;
use App\Http\Requests\StatusRequest;
use App\Http\Requests\StoreRequest;
use App\Models\Account;
use App\Services\amoCRM\Client;
use Exception;

class SiteController extends Controller
{
    /**
     * @throws Exception
     */
    public function lead(LeadRequest $request)
    {
        $amoApi = (new Client(Account::find(1)))->init();

        $leads = $amoApi->service->leads;
        dd($leads);
    }

    public function exchange(ExchangeRequest $request)
    {
        $data = $request->validated();

        // Запрос в API биржи
    }

    public function status(StatusRequest $request)
    {
        $data = $request->validated();
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
    }
}
