<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Product extends Main
{
    use HasFactory;

    const  PRICE_TYPE_ORDINARY = 1;
    const  PRICE_TYPE_DOLLAR = 2;


    const  MANAGE_STOCK_ACTIVE = 1;
    const  MANAGE_STOCK_DISABLE = 3;


    const  STOCK_STATUS_STOCK = 1;
    const  STOCK_STATUS_INSTOCK = 2;

    public static function priceTypeList()
    {
        $result = [
            self::PRICE_TYPE_ORDINARY => "عادی",
            self::PRICE_TYPE_DOLLAR => "دلاری",
        ];
        return $result;
    }

    public static function manageStockList()
    {
        $result = [
            self::MANAGE_STOCK_ACTIVE => "فعال",
            self::MANAGE_STOCK_DISABLE => "غیر فعال",
        ];
        return $result;
    }

    public static function stockStatusList()
    {
        $result = [
            self::STOCK_STATUS_STOCK => "موجود",
            self::STOCK_STATUS_INSTOCK => "ناموجود",
        ];
        return $result;
    }

    public function calculateStock($qty)
    {
        $result = [];

        $statusActive = self::MANAGE_STOCK_ACTIVE;
        $statusDiactive = self::MANAGE_STOCK_ACTIVE;
        $isStock = Main::STOCK;
        $inStock = Main::IN_STOCK;

        if ($this->manage_stock == $statusActive) {
            $stockStatus = $isStock;
            $currentQty = $this->stock_qty;
            if ($currentQty <= 0) {
                $stockStatus = $inStock;
            } else {
                if ($qty > $currentQty) {
                    $qty = $currentQty;
                }
                $result['currentQty'] = $currentQty;
                $result['qty'] = $qty;
            }
            $result['status'] = $stockStatus;

        } else {
            $stockStatus = $inStock;
            if ($this->stock_status == $statusActive) {
                $stockStatus = $isStock;
            }
            $result['status'] = $stockStatus;
        }


        return $result;
    }

    protected $fillable = [
        'main_image',
        'header_image',
        'title',
        'sub_title',
        'en_title',
        'categories',
        'tags',
        'description',
        'seo_title',
        'seo_description',
        'content_title',
        'slug',
        'status',
        'brand_id',
        'author_id',
        'redirect',
        'canonical',
        'related_articles',
        'related_products',
        'published_at',
        'count_visit',
        'count_comment',
        'count_score',
        'is_commentable',
        'sidebar',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',

        'show_price',
        'price_type',
        'price',
        'price_special',
        'price_currency',
        'price_currency_special',
        'price_special_from',
        'price_special_to',

        'manage_stock',
        'stock_status',
        'stock_qty',
        'low_stock',
        'sitemap_check',
    ];


    public static function getCategoriesChild()
    {
        return Categories::where(['type' => Main::CATEGORY_TYPE_PRODUCT, 'is_deleted' => Main::STATUS_DISABLED])->whereNull('parent_id')->with('children')->get();
    }



    public function calculatePrice()
    {
        $price = $this->price;
        if (doubleval($this->price_special) > 0) {
            $now = new \DateTime();
            $today = $now->format('Y-m-d H:i:s');

            if (!empty($this->price_special_from) && empty($this->price_special_to)) {
                if ($this->price_special_from <= $today) {
                    $price = $this->price_special;
                } else {
                    $price = $this->price;
                }
            } elseif (!empty($this->price_special_from) && !empty($this->price_special_to)) {
                if ($today >= $this->price_special_from && $today < $this->price_special_to) {
                    $price = $this->price_special;
                } else {
                    $price = $this->price;
                }

            } elseif (empty($this->price_special_from) && !empty($this->price_special_to)) {
                if ($today < $this->price_special_to) {
                    $price = $this->price_special;
                } else {
                    $price = $this->price;
                }
            } else {
                $price = $this->price_special;
            }
        }

        if ($this->price_type == self::PRICE_TYPE_DOLLAR) {
            if (doubleval($this->price_currency_special) > 0) {

                $now = new \DateTime();
                $today = $now->format('Y-m-d H:i:s');

                if (!empty($this->price_special_from) && empty($this->price_special_to)) {
                    if ($this->price_special_from <= $today) {
                        $price = $this->price_currency_special;
                    } else {
                        $price = $this->price_currency;
                    }
                } elseif (!empty($this->price_special_from) && !empty($this->price_special_to)) {
                    if ($today >= $this->price_special_from && $today < $this->price_special_to) {
                        $price = $this->price_currency_special;
                    } else {
                        $price = $this->price_currency;
                    }

                } elseif (empty($this->price_special_from) && !empty($this->price_special_to)) {
                    if ($today < $this->price_special_to) {
                        $price = $this->price_currency_special;
                    } else {
                        $price = $this->price_currency;
                    }
                } else {
                    $price = $this->price_currency_special;
                }
            }
            $price *= 60000; //curent currency price
        }

        return $price;
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tags::class, 'taggable', 'taggables', 'tag_id');
    }
}
