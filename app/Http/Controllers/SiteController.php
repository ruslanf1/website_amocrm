<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExchangeRequest;
use App\Http\Requests\LeadRequest;
use App\Http\Requests\StatusRequest;
use App\Http\Resources\Lead\IdResource;
use App\Http\Resources\Lead\StatusResource;
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
    public function lead(LeadRequest $request)
    {
        try {
            $data = $request->input();

            $amoApi = (new Client(Account::first()))->init();

            if ($amoApi->auth) {
                $contact = Contacts::search(['Почта' => $data['email']], $amoApi);

                if (!$contact) {
                    $contact = Contacts::create($amoApi, $data['email']);
                }
                $lead = Leads::create($contact, $data);

                Lead::create([
                    'contact_id' => $contact->id,
                    'lead_id' => $lead->id,
                    'wallet' => $data['wallet'],
                    'type_exchange' => $data['type'],
                    'email' => $data['email'],
                    'method_pay' => $data['method'],
                    'send_cost' => $data['send'][0]['cost'],
                    'send_currency' => $data['send'][0]['currency'],
                    'need_cost' => $data['need'][0]['cost'],
                    'need_currency' => $data['need'][0]['currency'],
                    'exchange_rate' => $data['exchange_rate'],
                ]);
            } else {
                throw new Exception('Auth error');
            }
            return new IdResource($lead);

        } catch (\Throwable $exception) {
            $exception->getMessage();
        }
    }

    // Ловим количество и тип перевода, кидаем запрос на биржу. Возвращаем данные пользователю.
    public function exchange(ExchangeRequest $request)
    {
        $data = $request->validated();
    }

    public function status(StatusRequest $request)
    {
        $leadId = $request->leads['status'][0]['id'];
        $leadStatus = $request->value;

        try {
            $model = Lead::query()
                ->where('lead_id', $leadId)
                ->firstOrFail();

            $model->lead_status = $leadStatus;
            $model->save();

        } catch (ModelNotFoundException $exception) {

            return $exception->getMessage();

        } catch (\Throwable $exception) {

            return $exception->getMessage();
        }
    }

    public function index(Lead $lead)
    {
            return new StatusResource($lead);
    }
}
