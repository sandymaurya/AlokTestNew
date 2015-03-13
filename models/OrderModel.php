<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\CardType;
use app\models\Hotel;
use app\models\PaymentStatusType;
use app\models\OrderStatusType;
use app\models\TravelerType;

use app\enums\TravelerTypeEnum;

/**
 * ContactForm is the model behind the contact form.
 */
class OrderModel extends Model {    
    public $ticketTime;
    public $ticketHotel;
    public $ticketQuantity;
    public $ticketPromoCode;
    public $bookingDate;
    public $bookingDay;
    public $bookingMonth;
    public $bookingYear;
    public $bookingSpecialNeeds;
    public $travelerType;
    public $travelerName;
    public $travelerAddress;
    public $travelerDoBMonth;
    public $travelerDoBYear;
    public $travelerEmail;
    public $travelerPersonNames;
    public $paymentOptionCardType;
    public $paymentOptionCardHolderName;
    public $paymentOptionCardNumber;
    public $paymentOptionExpiryDate;
    public $paymentOptionExpiryMonth;
    public $paymentOptionExpiryYear;
    public $paymentOptionCVV;
    public $amount;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // START: STEP 1 //
            [['ticketTime', 'ticketHotel', 'ticketQuantity'], 'required', "on" => ['step1', 'step2', 'step3', 'step4']],
            // END: STEP 1 //
            // START: STEP 2 //
            [['bookingDate'], 'required', 'on' => ['step2', 'step3', 'step4']],
            [['bookingDate'], "date", 'format' => 'php:Y-m-d', 'message' => 'Invalid booking date.', 'on' => ['step2', 'step3', 'step4']],
            [['bookingDate'], "checkMinDate", 'on' => ['step2', 'step3', 'step4']],
            // END: STEP 2 //
            // START: STEP 3 //
            [['travelerType', 'travelerName', 'travelerAddress', 'travelerEmail'], 'required', 'message' => 'This field cannot be empty.', 'on' => ['step3', 'step4']],
            [['travelerPersonNames'], 'required', 'when' => function ($model) {
            return $model->travelerType == TravelerTypeEnum::FAMILY;            
        }, 'message' => 'Names cannot be empty.', 'on' => ['step3', 'step4']],
            [['travelerDoBMonth'], 'required', 'message' => "Select Month.", 'on' => ['step3', 'step4']],
            [['travelerDoBYear'], 'required', 'message' => "Select Year.", 'on' => ['step3', 'step4']],
            [['travelerEmail'], 'email', 'message' => 'Email address is not valid.', 'on' => ['step3', 'step4']],
            [['travelerName'], 'match', 'pattern' => '/[A-Za-z .]{2,100}$/', 'on' => ['step3', 'step4']],
            // END: STEP 3 //
            // START: STEP 4 //
            [['paymentOptionCardType', 'paymentOptionCardHolderName', 'paymentOptionCardNumber', 'paymentOptionCVV'], 'required', 'message' => 'This field cannot be empty.', 'on' => 'step4'],
            ['paymentOptionCardNumber', 'validateCreditCard', 'message' => 'Invalid credit card number.', 'on' => ['step4']],
            [['paymentOptionExpiryMonth'], 'required', 'message' => 'Select Month.', 'on' => 'step4'],
            [['paymentOptionExpiryYear'], 'required', 'message' => 'Select Year.', 'on' => 'step4'],            
                // END: STEP 4 //
        ];
    }

    public function validateCreditCard($attribute, $params) {
        $cardFormat = $this->paymentOptionCardType;

        $creditCardValidator = new CreditCardValidator(['message' => "Invalid credit card number.", 'messageFormat' => 'Invalid credit card type.']);

        $creditCardValidator->format = $cardFormat;

        if (!$creditCardValidator->validateName($this->paymentOptionCardHolderName))
            $this->addError('paymentOptionCardHolderName', 'Invalid card holder name.');
        
        if (!$creditCardValidator->validateDate($this->paymentOptionExpiryMonth, $this->paymentOptionExpiryYear))
            $this->addError('paymentOptionExpiryDate', 'Invalid expiry date.');
        
        $creditCardValidator->validateAttribute(@$this, "paymentOptionCardNumber");
    }

    public function checkMinDate($attribute, $params) 
    {   
        $y = intval(date('Y'));
        $m = intval(date('m'));
        $d = intval(date('d'));
        
        $arr = explode('-', $this -> $attribute);
        $ay = intval($arr[0]);
        $am = intval($arr[1]);
        $ad = intval($arr[2]);
        
        if($ay<$y || ($ay==$y && $am < $m) || ($ay==$y && $am == $m && $ad <= $d))
        {
            $this->addError($attribute, 'Please select a future date.');
        }
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email) {
        return Yii::$app->mailer->compose()
                        ->setTo($email)
                        ->setFrom([$this->email => $this->name])
                        ->setSubject($this->subject)
                        ->setTextBody($this->body)
                        ->send();
    }

    public function getTimeList() {
        return [
            '09am' => '09 a.m.',
            '11am' => '11 a.m.',
            '01pm' => '01 p.m.',
            '03pm' => '03 p.m.'
        ];
    }
    
    public function getHotelsList() {
        $entities = Hotel::find()->all();        
        foreach($entities as $entity)
        {
            $arr[$entity->Code] = $entity->Name;
        }        
        return $arr;
    }

    public function getSlider2Images() {
        return [
            [
                'url' => '/mm-images/downloaded/pawn-stars-tours.png',
                'height' => '200',
                'width' => '357'
            ],
            [
                'url' => '/mm-images/downloaded/book-now-mgm.png',
                'height' => '200',
                'width' => '357'
            ],
            [
                'url' => '/mm-images/downloaded/pawn-stars-gold-silver-pawn-shop.jpg',
                'height' => '200',
                'width' => '357'
            ]
        ];
    }

    public function getTravelerTypeList() {
        $entities = TravelerType::find()->all();        
        foreach($entities as $entity)
        {
            $arr[$entity->Id] = $entity->Type;
        }        
        return $arr;        
    }

    public function getPaymentOptionCardTypeList() {
        $entities = CardType::find()->all();        
        foreach($entities as $entity)
        {
            $arr[$entity->Type] = $entity->Name;
        }        
        return $arr;        
    }

    public function getMonthNames() {
        return array_combine(range(1, 12), ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ticketTime' => 'Time',
            'ticketHotel' => 'Hotel',
            'ticketQuantity' => 'Quantity',
            'ticketPromoCode' => 'Promo code',
            'bookingDate' => 'Booking date',
            'bookingDay' => 'Day',
            'bookingMonth' => 'Month',
            'bookingYear' => 'Year',
            'bookingSpecialNeeds' => 'Special needs',
            'travelerType' => 'Booking for',
            'travelerName' => "Traveler's name",
            'travelerAddress' => 'Home address',
            'travelerDoBMonth' => 'Month',
            'travelerDoBYear' => 'Year',
            'travelerEmail' => 'Email',
            'travelerPersonNames' => "Traveller's names",
            'paymentOptionCardType' => 'Card Options',
            'paymentOptionCardHolderName' => 'Card holder name',
            'paymentOptionCardNumber' => 'Card number',
            'paymentOptionExpiryMonth' => 'Month',
            'paymentOptionExpiryYear' => 'Year',
            'paymentOptionCVV' => 'CVV',
        ];
    }

    public function processPayment() {
        $stripeKey = Yii::$app->params['stripeKey'];
        $error = "";
        ini_set('error_reporting', E_ALL);

        \Stripe\Stripe::setApiKey($stripeKey['api']);
        $myCard = [
            'number' => $this->paymentOptionCardNumber,
            'exp_month' => $this->paymentOptionExpiryMonth,
            'exp_year' => $this->paymentOptionExpiryYear,
            'name' => $this->travelerName,
            'address_line1' => $this->travelerAddress
        ];
        try {
            $charge = \Stripe\Charge::create(array('card' => $myCard, 'amount' => '9900', 'currency' => 'usd'));
        } catch (\Stripe\Error\ApiConnection $e) {
            $error = $e->getMessage();
            // Network problem, perhaps try again.
        } catch (\Stripe\Error\InvalidRequest $e) {
            $error = $e->getMessage();
            // You screwed up in your programming. Shouldn't happen!
        } catch (\Stripe\Error\Api $e) {
            $error = $e->getMessage();
            // Stripe's servers are down!
        } catch (\Stripe\Error\Card $e) {
            $error = $e->getMessage();
            // Card was declined.
        }
        if ($error)
            return ['status' => 'error', 'message' => $error];
        else
            return ['status' => 'success', 'charge' => $charge];
    }

    public function sendNotification($template, $to, $subject, $data, $from = "") {
        $mail = \Yii::$app->mailer->compose($template, ['data' => $data]);
        if (!$from)
            $mail->setFrom([\Yii::$app->params['alertsEmail'] => \Yii::$app->name . ' automatic confirmation']);
        else
            $mail->setFrom($from);
        $mail->setTo($to);
        $mail->setSubject($subject);
        $mail->send();
    }

}
