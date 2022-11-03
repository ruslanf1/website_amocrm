<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExchangeRequest;
use App\Http\Requests\LeadRequest;
use App\Http\Requests\StatusRequest;
use App\Http\Requests\StoreRequest;
use App\Models\Account;
use App\Models\Exchange;
use App\Models\Lead;
use App\Services\amoCRM\Client;
use App\Services\amoCRM\Models\Contacts;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SiteController extends Controller
{
    /**
     * @throws Exception
     */

    // Берем почту из запроса и ищем в Амо такой контакт.
    // самый жирный запрос
    public function lead(LeadRequest $request)
    {
        $data = $request->validated();
        $amoApi = (new Client(Account::find(1)))->init();

        //тут записываем в бд

        if ($amoApi->auth == true) {

            $contact = Contacts::search(['Почта' => '{тут почта}'], $amoApi);

            if (!$contact) {

//                Contacts::create1

//                Contacts::update();
            }

//            $contact->id

            //отдаем ид сделки
            //{lead_id : lead->id}

        } else
            throw new Exception('Auth error');
    }

    // Ловим количество и тип перевода, кидаем запрос на биржу. Возвращаем данные пользователю.
    public function exchange(ExchangeRequest $request)
    {
        $data = $request->validated();
    }

    // +Принимаем хук о смене этапа в Амо.
    // Ищем лид в БД и меняем у него значение статус.
    // Пост запрос на роут status. В урле параметр статуса. В теле id сделки.
    // Все входящие запросы логируем. Если лид не найден, создаем в логе алерт.
    public function status(StatusRequest $request)
    {
//        $data = $request->validated();

        $leadId = $request->leads['status'][0]['id'];

        $leadStatus = $request->value;

        try {
            $model = Lead::query()
                ->where('lead_id', $leadId)
                ->firstOrFail();

            $model->status = $leadStatus;
            $model->save();

        } catch (ModelNotFoundException $exception) {

            dd($exception->getMessage());

        } catch (\Throwable $exception) {

            dd($exception->getMessage());
        }
    }

    // Сохраняем данные о пользователе и обмене в БД.
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
    }

    public function index(Lead $lead)
    {
//        return {status : $lead->status}
    }
}
