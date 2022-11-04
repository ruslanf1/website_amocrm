<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExchangeRequest;
use App\Http\Requests\LeadRequest;
use App\Http\Requests\StatusRequest;
use App\Http\Requests\StoreRequest;
use App\Models\Account;
use App\Models\Lead;
use App\Services\amoCRM\Client;
use App\Services\amoCRM\Models\Contacts;
use App\Services\amoCRM\Models\Leads;
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
        $data = $request->all();
        $data['send_cost'] = $data['send'][0]['cost'];
        $data['send_currency'] = $data['send'][0]['currency'];
        $data['need_cost'] = $data['need'][0]['cost'];
        $data['need_currency'] = $data['need'][0]['currency'];
        $data['type_exchange'] = $data['type'];
        $data['method_pay'] = $data['method'];
        unset($data['send'], $data['need'], $data['type'], $data['method']);

        $amoApi = (new Client(Account::all()->last()))->init();

        if ($amoApi->auth) {
            $contact = Contacts::search(['Почта' => $data['email']], $amoApi);

            if (!$contact) {
                $contact = Contacts::create($amoApi, $data['email']);
            }

            $lead = Leads::create($contact, $data);

            $data['contact_id'] = $contact->id;
            $data['lead_id'] = $lead->id;

            $this->store($data);

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
    public function store($data)
    {
        Lead::firstOrCreate(['lead_id' => $data['lead_id']], $data);
    }

    public function index(Lead $lead)
    {
//        return {status : $lead->status}
    }
}
