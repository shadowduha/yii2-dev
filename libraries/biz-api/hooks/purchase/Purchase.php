<?php

namespace biz\api\hooks\purchase;

use Yii;
use biz\api\models\inventory\GoodsMovement as MGoodsMovement;
use biz\api\models\purchase\Purchase as MPurchase;
use yii\helpers\ArrayHelper;

/**
 * Purchase
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 3.0
 */
class Purchase extends \yii\base\Behavior
{
    public $types = [100,];

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            'eMovementApply' => 'movementApply',
            'eMovementReject' => 'movementReject',
            'eMovementApplied' => 'movementApplied',
            'eMovementRejected' => 'movementRejected',
        ];
    }

    /**
     * Handler for Good Movement created.
     * It used to update stock
     * @param \dee\base\Event $event
     */
    public function movementApply($event)
    {
        /* @var $model MGoodsMovement */
        $model = $event->params[0];
        if (!in_array($model->reff_type, $this->types)) {
            return;
        }

        $purchase = MPurchase::findOne($model->reff_id);
        $purchaseItems = ArrayHelper::index($purchase->items, 'product_id');
        // change total qty for reff document
        /* @var $purcDtl \biz\api\models\purchase\PurchaseDtl */
        foreach ($model->items as $detail) {
            $purcDtl = $purchaseItems[$detail->product_id];
            // set qty avaliable for GR
            $detail->avaliable = $purcDtl->qty - $purcDtl->total_receive;
        }
    }

    /**
     * Handler for Good Movement created.
     * It used to update stock
     * @param \dee\base\Event $event
     */
    public function movementApplied($event)
    {
        /* @var $model MGoodsMovement */
        $model = $event->params[0];
        if (!in_array($model->reff_type, $this->types)) {
            return;
        }

        $purchase = MPurchase::findOne($model->reff_id);
        $purchaseItems = ArrayHelper::index($purchase->items, 'product_id');
        // change total qty for reff document
        /* @var $purcDtl \biz\api\models\purchase\PurchaseDtl */
        foreach ($model->items as $detail) {
            $purcDtl = $purchaseItems[$detail->product_id];

            $purcDtl->total_receive += $detail->qty;
            $purcDtl->save(false);
        }
    }

    /**
     * Handler for Good Movement created.
     * It used to update stock
     * @param \dee\base\Event $event
     */
    public function movementReject($event)
    {
        /* @var $model MGoodsMovement */
        $model = $event->params[0];
        if (!in_array($model->reff_type, $this->types)) {
            return;
        }

        //$purchase = MPurchase::findOne($model->reff_id);
    }

    /**
     * Handler for Good Movement created.
     * It used to update stock
     * @param \dee\base\Event $event
     */
    public function movementRejected($event)
    {
        /* @var $model MGoodsMovement */
        $model = $event->params[0];
        if (!in_array($model->reff_type, $this->types)) {
            return;
        }

        $purchase = MPurchase::findOne($model->reff_id);
        $purchaseItems = ArrayHelper::index($purchase->items, 'product_id');
        // change total qty for reff document
        /* @var $purcDtl \biz\api\models\purchase\PurchaseDtl */
        foreach ($model->items as $detail) {
            $purcDtl = $purchaseItems[$detail->product_id];

            $purcDtl->total_receive -= $detail->qty;
            $purcDtl->save(false);
        }
    }

}