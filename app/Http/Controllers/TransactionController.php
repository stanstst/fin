<?php

namespace App\Http\Controllers;

use App\Models\ParkingTicket;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TransactionController extends Controller
{

    const SORT_ID_DESC = 'idDesc';
    const SORT_USER_ASC = 'userAsc';
    const SORT_USER_DESC = 'userDesc';

    public function get(string $sort = 'id')
    {
        $query = Transaction::with(['account', 'account.user'])->orderBy(
            'id',
            $sort === self::SORT_ID_DESC ? 'desc' : 'asc'
        );

        if ($sort === self::SORT_USER_ASC || $sort === self::SORT_USER_DESC) {
            $query = Transaction::with(['account', 'account.user'])
                ->join('user_transaction_accounts', 'user_transaction_accounts.id', '=', 'transactions.account_id')
                ->join('users', 'users.id', '=', 'user_transaction_accounts.user_id')
                ->orderBy('users.name', $sort === self::SORT_USER_DESC ? 'desc' : 'asc');
        }

        try {
            return $query->get();
            // todo this must be put via serializer with groups in order to avoid payload overhead with all the fields in all the relations

        } catch (Throwable $e) {
            return new JsonResponse(null, Response::HTTP_BAD_GATEWAY);
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate(
                [
                    'amount' => [
                        'required',
                        'numeric',
                        'gt:0',
                    ],
                    'type' => [
                        'required',
                        Rule::in(Transaction::TYPES),

                    ],
                    'account_id' => [
                        'required',
                        Rule::exists('user_transaction_accounts', 'id'),
                    ],
                ]
            );

            $transaction = Transaction::create(
                [
                    'amount' => $request->amount,
                    'type' => $request->type,
                    'account_id' => $request->account_id,
                ]
            );

            $transaction->save();
        } catch (ValidationException $exception) {

            return new JsonResponse(['errors' => $exception->errors(), Response::HTTP_BAD_REQUEST]);
        } catch (Throwable $exception) {

            return new JsonResponse(['Error creating transaction', Response::HTTP_BAD_GATEWAY]);
        }

        return new JsonResponse($transaction);
    }
}
