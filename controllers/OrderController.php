<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\CardDetail;
use app\models\CardType;
use app\models\CreditCardValidator;
use app\models\Hotel;
use app\models\Order;
use app\models\OrderModel;
use app\models\Payment;
use app\models\Ticket;
use app\models\Traveler;
use app\models\TravelerType;

class OrderController extends Controller {

    public function actionProcess() {
        $post = Yii::$app->request->post();

        $model = new OrderModel(['scenario' => $post['scenario']]);

        if ($model->load($post) && $model->validate()) {
            if ($post['scenario'] == 'step4') {

                if (!$model->hasErrors()) {
                    $connection = \Yii::$app->db;
                    $transaction = $connection->beginTransaction();
                    try {
                        $ticket = new Ticket();
                        $ticket->Time = $model->ticketTime;
                        $ticket->HotelId = Hotel::findOne(['Code'=>$model->ticketHotel])->Id ;
                        $ticket->Quantity = $model->ticketQuantity;
                        $ticket->BookingDate = $model->bookingDate;
                        $ticket->save();

                        $traveler = new \app\models\Traveler();
                        $traveler->TravelerType = $model->travelerType;
                        $traveler->Name = $model->travelerName;
                        $traveler->Address = $model->travelerAddress;
                        $traveler->DoB = $model->travelerDoBMonth . '-' . $model->travelerDoBYear;
                        $traveler->Email = $model->travelerEmail;
                        $traveler->PersonCount = substr_count($model->travelerPersonNames, ',');
                        $traveler->PersonNames = $model->travelerPersonNames;
                        $traveler->save();

                        $cardDetail = new \app\models\CardDetail();
                        $cardDetail->CardType = CardType::findOne(['Type'=>$model->paymentOptionCardType])->Id;
                        $cardDetail->CardHolderName = $model->paymentOptionCardHolderName;
                        $cardDetail->CardNumber = $model->paymentOptionCardNumber;
                        $cardDetail->ExpiryMonth = $model->paymentOptionExpiryMonth;
                        $cardDetail->ExpiryYear = $model->paymentOptionExpiryYear;
                        $cardDetail->CV2Number = $model->paymentOptionCVV;
                        $cardDetail->save();

                        $order = new \app\models\Order();
                        $order->TicketId = $ticket->Id;
                        $order->TravelerId = $traveler->Id;
                        $order->PaymentId = null;
                        $order->Date = date("Y-m-d H:i:s");
                        $order->SpecialNeed = $model->bookingSpecialNeeds;
                        $order->InitialAmount = "99";
                        $order->PromoCode = $model->ticketPromoCode;
                        $order->FinalAmount = "99";
                        $order->Status = 1;
                        $order->save();

                        $paymentModel = new \app\models\Payment();
                        $paymentModel->CardDetailId = $cardDetail->Id;
                        $paymentModel->Date = date("Y-m-d H:i:s");
                        $paymentModel->PaidAmount = "99";
                        $paymentModel->OrderId = $order->Id;
                        $paymentModel->Status = 1;
                        $paymentModel->save();

                        $paymentProcessObj = $model->processPayment(); // Process payment and check if it has any error.

                        if ($paymentProcessObj['status'] == 'error') {
                            \yii::$app->getResponse()->setStatusCode("422", "Payment Failed.");
                            $model->addError("paymentOptionCardNumber", $paymentProcessObj['message']);
                            $transaction->rollBack();
                            return json_encode($model->getErrors());
                        } else {
                            $paymentModel->Status = 2;
                            $paymentModel->save();

                            $orderModel = new \app\models\Order();
                            $orderModel->PaymentId = $paymentModel->Id;
                            $orderModel->Status = 3;

                            $transaction->commit();

                            $model->sendNotification(
                                    "OrderAlert",                                    
                                    $app->params['salesEmail'],
//                                    "hornllp@gmail.com",
                                    \Yii::$app->params['sitename'] . ' - New Order Alert', 
                                    $model);
                                                        
                            $model->sendNotification(
                                    "OrderConfirmation",
                                    $model->travelerEmail, 
                                    \Yii::$app->params['sitename'] . ' - Order confirmation', 
                                    $model);

                            return "success";
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        return $e->getMessage();
                    }
                }
            } else
                return "success";
        }
        \yii::$app->getResponse()->setStatusCode("422", "Validation Failed.");
        return json_encode($model->getErrors());
    }
}
