<?php

use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get(
    '/user',
    function (Request $request) {
        return $request->user();
    }
);

Route::get('transactions/{sort?}', [TransactionController::class, 'get']);

Route::get(
    'transactions/{id}',
    function (int $id) {
        try {
            $transaction = Transaction::with(['account', 'account.user'])->find($id);

            if (empty($transaction)) {
                return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
            }

        } catch (Throwable $e) {
            return new JsonResponse(null, Response::HTTP_BAD_GATEWAY);
        }

        return $transaction;
    }
);

Route::post('transactions', [TransactionController::class, 'create']);
