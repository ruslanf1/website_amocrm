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

    // Берем почту из запроса и ищем в Амо такой контакт.
    public function lead(LeadRequest $request)
    {
        $data = $request->validated();
        $amoApi = (new Client(Account::find(1)))->init();
        $leads = $amoApi->service->leads;
        print_r($leads);
    }

    // Ловим количество и тип перевода, кидаем запрос на биржу. Возвращаем данные пользователю.
    public function exchange(ExchangeRequest $request)
    {
        $data = $request->validated();
    }

    // Принимаем хук о смене этапа в Амо. Ищем лид в БД и меняем у него значение статус.
    // Пост запрос на роут status. В урле параметр статуса. В теле id сделки.
    // Все входящие запросы логируем. Если лид не найден, создаем в логе алерт.
    public function status(StatusRequest $request)
    {
        $data = $request->validated();
    }

    // Сохраняем данные о пользователе и обмене в БД.
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
    }
}
