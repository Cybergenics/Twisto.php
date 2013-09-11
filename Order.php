<?php

namespace Twisto;


class Order {
    /**
     * @var string
     */
    public $order_id;

    /**
     * @var DateTime
     */
    public $created;

    /**
     * @var Twisto\Address
     */
    public $billing_address;
    
    /**
     * @var Twisto\Address
     */
    public $delivery_address;

    /**
     * @var bool
     */
    public $total_price_vat;
     
    /**
     * @var bool
     */
    public $is_paid;
     
    /**
     * @var bool
     */
    public $is_delivered;    
    
    /**
     * @var bool
     */
    public $is_returned;
    
     /**
     * @var array
     */
    public $items;
    

    public function __construct(array $data) {
        $this->order_id = $data['order_id'];
        $this->created = new \DateTime($data['created']);
        $this->billing_address = $data['billing_address'];
        $this->delivery_address = isset($data['delivery_address']) ? $data['delivery_address'] : null;
        $this->total_price_vat = $data['total_price_vat'];
        $this->is_paid = $data['is_paid'];
        $this->is_delivered = $data['is_delivered'];
        $this->is_returned = $data['is_returned'];     
        $this->items = $data['items'];
    }

    public function serialize() {
        $data = array(
            'order_id' => $this->order_id,
            'created' => $this->created->format('c'), // ISO 8601
            'billing_address' => $this->billing_address->serialize(),
            'delivery_address' => $this->delivery_address->serialize(),
            'total_price_vat' => $this->total_price_vat,
            'is_paid' => ($this->is_paid == 0 ? false : true), 
            'is_delivered' => ($this->is_delivered == 0 ? false : true),
            'is_returned' => ($this->is_returned == 0 ? false : true),
            'items' => array()
        );    
        
        foreach ($this->items as $item) {
            $data['items'][] = $item->serialize();
        }
        
        return $data;

    }
}