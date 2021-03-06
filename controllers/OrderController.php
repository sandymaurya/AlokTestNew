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
            $tourModel = \app\models\Tour::findOne(['Url' => $model->tourId]);
            $intialAmount = 0;
            $finalAmount = 0;
            if(!$tourModel) {
                throw new \yii\web\HttpException(404, "Invalid Request");
                return;
            }
            else {
                $initialAmount = $finalAmount = $model->ticketQuantity * $tourModel->Price;
                $couponDetails = $this->getCoupon($model->ticketPromoCode);
                if($couponDetails && !isset($couponDetails['error']) && $couponDetails['valid']) {
                    $discount = 0;
                    if($couponDetails['finalAmount'])
                        $discount = ($initialAmount * $couponDetails['finalAmount'] / 100);
                    else 
                        $discount = $couponDetails['amount_off'];
                    $finalAmount = $finalAmount - $discount;
                }
            }
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
                        $order->InitialAmount = $initialAmount;
                        $order->PromoCode = $model->ticketPromoCode;
                        $order->FinalAmount = $finalAmount;
                        $order->Status = 1;
                        $order->save();

                        $paymentModel = new \app\models\Payment();
                        $paymentModel->CardDetailId = $cardDetail->Id;
                        $paymentModel->Date = date("Y-m-d H:i:s");
                        $paymentModel->PaidAmount = $finalAmount;
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
                                    \Yii::$app->params['salesEmail'],
                                    \Yii::$app->params['sitename'] . ' - New Order Alert', 
                                    $model,
                                    \Yii::$app->params['sitename'] . ' - New Order Alert');
                                                        
                            $model->sendNotification(
                                    "OrderConfirmation",
                                    $model->travelerEmail, 
                                    \Yii::$app->params['sitename'] . ' - Order confirmation',
                                    $model,
                                    \Yii::$app->params['sitename'] . ' - Order confirmation');

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
    
    public function actionCoupon($token) {
        ini_set('error_reporting', E_ALL);
        
        $return = $this->getCoupon($token);
        
        if(isset($return['error']) && $return['error']) {
            Yii::$app->getResponse()->setStatusCode(422, "Data validation error");
        }
        
        return json_encode($return);
    }
    
    public function getCoupon($token) {
        $stripeKey = Yii::$app->params['stripeKey'];
        $return = [];

        \Stripe\Stripe::setApiKey($stripeKey['api']);
        
        try {
            $return = \Stripe\Coupon::retrieve($token);
            
            if($return->redeem_by <= time() || $return->max_redemptions < $return->times_redeemed || !$return->valid) {
                $return = ['error' => "Expired coupon: $token"];
            }
            else
            {
                $temp = [];
                $temp['id'] = $return->id;
                $temp['percent_off'] = $return->percent_off;
                $temp['amount_off'] = $return->amount_off;
                $temp['valid'] = $return->valid;
                $return =$temp;
            }
            
        } catch (\Stripe\Error\ApiConnection $e) {
            $return = ['error' => $e->getMessage()];
            // Network problem, perhaps try again.
        } catch (\Stripe\Error\InvalidRequest $e) {
            $return = ['error' => $e->getMessage()];
            // You screwed up in your programming. Shouldn't happen!
        } catch (\Stripe\Error\Api $e) {
            $return = ['error' => $e->getMessage()];
            // Stripe's servers are down!
        } catch (\Stripe\Error\Card $e) {
            $return = ['error' => $e->getMessage()];
            // Card was declined.
        }
        return $return;
    }
}
