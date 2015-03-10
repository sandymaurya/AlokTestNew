<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\OrderModel;

class OrderController extends Controller
{
    public function actionProcess()
    {
        $post = Yii::$app->request->post();
        
        $model = new OrderModel(['scenario' => $post['scenario']]);
        
        if ($model->load($post) && $model->validate()) {
            if($post['scenario'] == 'step4') {
                
                if(!$model->hasErrors())
                {
                    $connection = \Yii::$app->db;
                    $transaction = $connection->beginTransaction();
                    try {
                        $ticket = new \app\models\Ticket();
                        $ticket->Time = $model->ticketTime;
                        $ticket->HotelId = $model->ticketHotel;
                        $ticket->Quantity = $model->ticketQuantity;
                        $ticket->BookingDate = $model->bookingDate;
                        
                        $ticket->save();

                        $traveler = new \app\models\Traveler();
                        $traveler->TravelerType = $model->travelerType;
                        $traveler->Name = $model->travelerName;
                        $traveler->Address = $model->travelerAddress;
                        $traveler->DoB = $model->travelerDoBMonth.'-'.$model->travelerDoBYear;
                        $traveler->Email = $model->travelerEmail;
                        $traveler->PersonCount = substr_count($model->travelerPersonNames, '(');
                        $traveler->PersonNames = $model->travelerPersonNames;
                        $traveler->save();
                        
                        $cardDetail = new \app\models\CardDetail();
                        $cardDetail->CardType = $model->paymentOptionCardType;
                        $cardDetail->CardHolderName = $model->paymentOptionCardHolderName;
                        $cardDetail->CardNumber = $model->paymentOptionCardNumber;
                        $cardDetail->ExpiryMonth = $model->paymentOptionExpiryMonth;
                        $cardDetail->ExpiryYear = $model->paymentOptionExpiryYear;
                        $cardDetail->CV2Number = $model->paymentOptionCVV;
                        
                        $cardDetail->save();
                        
                        $paymentModel = new \app\models\Payment();
                        $paymentModel->CardDetailId = $cardDetail->Id;
                        $paymentModel->Date = date("Y-m-d H:i:s");
                        $paymentModel->PaidAmount = "99";
                        $paymentModel->Status = 1;
                        $paymentModel->save();
                        
                        $paymentProcessObj = $model->processPayment(); // Process payment and check if it has any error.
                        
                        if($paymentProcessObj['status']=='error') {
                            \yii::$app->getResponse()->setStatusCode("422", "Payment Failed.");
                            $model->addError ("paymentOptionCardNumber", $paymentProcessObj['message']);
                            $transaction->rollBack();
                            return json_encode($model->getErrors());
                        }
                        else
                        {
                            $paymentModel->Status = 3;
                            $paymentModel->save();
                            
                            $orderModel = new \app\models\Order();
                            $orderModel->TicketId = $ticket->Id;
                            $orderModel->TravelerId = $traveler->Id;
                            $orderModel->PaymentId = $paymentModel->Id;
                            $orderModel->Date = date("Y-m-d H:i:s");
                            $orderModel->SpecialNeed = $model->bookingSpecialNeeds;
                            $orderModel->InitialAmount = "99";
                            $orderModel->PromoCode = $model->ticketPromoCode;
                            $orderModel->FinalAmount = "99";
                            $orderModel->Status = 5;
                            
                            $transaction->commit();

                            $model->sendNotification(
                                    "newOrderConfirmation", 
//                                    "order@anniebananies.com", 
                                    "hornllp@gmail.com",                                     
                                    \Yii::$app->params['sitename'].' - New Order confirmation', 
                                    $model);

                            return "success";
                        }
                    }
                    catch (Exception $e)
                    {
                        $transaction->rollBack();
                        return $e->getMessage();
                    }
                }
            }
            else
                return "success";
        }
        \yii::$app->getResponse()->setStatusCode("422", "Validation Failed.");
        return json_encode($model->getErrors());
    }
}