- 获取产品和变体
- 创建结算单: 获取支付页[res: data.attributes.url]
- 支付回调
    - 支付成功: 提供服务
    - 支付失败
- 提现
    
创建结算单
```
curl -X "POST" "https://api.lemonsqueezy.com/v1/checkouts" \
     -H 'Accept: application/vnd.api+json' \
     -H 'Content-Type: application/vnd.api+json' \
     -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NGQ1OWNlZi1kYmI4LTRlYTUtYjE3OC1kMjU0MGZjZDY5MTkiLCJqdGkiOiIwOWQ5YmQxZDcyZmU0YzZkODRmYTUxZTc3NTk5Mjc1NDQzMzVhYzcwNDAwYzI2OTQ0NDE3YjQ4NWVlMjVjYWVjZDY4NDQxNWM5Y2IxN2EzYyIsImlhdCI6MTY4OTgyMDE4OS45NDY2NjgsIm5iZiI6MTY4OTgyMDE4OS45NDY2NzEsImV4cCI6MTcyMTQ0MjU4OS45Mzg3NTgsInN1YiI6Ijk2MjA3MyIsInNjb3BlcyI6W119.uIuN6BAXuE6rctHL7iHrFm28Smf1p4bUoPADnZKjHvXTPBASkkLPgF29xP0MyJoCkL_WNy2HLSo92YGC2s1AldvItbaX9txQ6h2uask5cHWEYHlyG61ONHOQV02lVtaWKovu6-_HDc8nyO7F4mwuULyfEJ7xdaC0CjXwiohkXcE_AtSDDgJ9noMcIl5JlTX3Y32_e01yvnwcm6Bp_2NDaiEDxoXoDTXZCZiKgjWwIBrA_MLoqnEs6Sh_IQ9jrX36Fo9iUZHHqe06EWLQCddP7T5dmcKc2H3rfGF49zN10Za2maOS59b4SJ-8t4VR6E7ZGvWPWkyZ3VWkYooZ0i5mN-oWlAOvUDfZsdR2yTPG_2uRSUcS1f_A0C_iEBDJx_f11Ee1QHXwk6_ngQ_HY2JaQ9KbS1zzxfOuf6SOadctu-mt_1K5Z1DR4nFGY9gaO9zjFJsnsryvFzQiIoAQZwUxEOiVnN0Hr25lkVfNy-X_RDkl4Ybtcdc7FsFNppcSVgwU' \
     -d $'{
            "data": {
              "type": "checkouts",
              "relationships": {
                "store": {
                  "data": {
                    "type": "stores",
                    "id": "36267"
                  }
                },
                "variant": {
                  "data": {
                    "type": "variants",
                    "id": "102129"
                  }
                }
              }
            }
          }'
```
  
列出所有variants     
```
curl "https://api.lemonsqueezy.com/v1/variants" \
     -H 'Accept: application/vnd.api+json' \
     -H 'Content-Type: application/vnd.api+json' \
     -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NGQ1OWNlZi1kYmI4LTRlYTUtYjE3OC1kMjU0MGZjZDY5MTkiLCJqdGkiOiIwOWQ5YmQxZDcyZmU0YzZkODRmYTUxZTc3NTk5Mjc1NDQzMzVhYzcwNDAwYzI2OTQ0NDE3YjQ4NWVlMjVjYWVjZDY4NDQxNWM5Y2IxN2EzYyIsImlhdCI6MTY4OTgyMDE4OS45NDY2NjgsIm5iZiI6MTY4OTgyMDE4OS45NDY2NzEsImV4cCI6MTcyMTQ0MjU4OS45Mzg3NTgsInN1YiI6Ijk2MjA3MyIsInNjb3BlcyI6W119.uIuN6BAXuE6rctHL7iHrFm28Smf1p4bUoPADnZKjHvXTPBASkkLPgF29xP0MyJoCkL_WNy2HLSo92YGC2s1AldvItbaX9txQ6h2uask5cHWEYHlyG61ONHOQV02lVtaWKovu6-_HDc8nyO7F4mwuULyfEJ7xdaC0CjXwiohkXcE_AtSDDgJ9noMcIl5JlTX3Y32_e01yvnwcm6Bp_2NDaiEDxoXoDTXZCZiKgjWwIBrA_MLoqnEs6Sh_IQ9jrX36Fo9iUZHHqe06EWLQCddP7T5dmcKc2H3rfGF49zN10Za2maOS59b4SJ-8t4VR6E7ZGvWPWkyZ3VWkYooZ0i5mN-oWlAOvUDfZsdR2yTPG_2uRSUcS1f_A0C_iEBDJx_f11Ee1QHXwk6_ngQ_HY2JaQ9KbS1zzxfOuf6SOadctu-mt_1K5Z1DR4nFGY9gaO9zjFJsnsryvFzQiIoAQZwUxEOiVnN0Hr25lkVfNy-X_RDkl4Ybtcdc7FsFNppcSVgwU'
```


<!-- 变体2：102178 -->

{
  "data": {
    "id": "970167",
    "type": "orders",
    "links": {
      "self": "https://api.lemonsqueezy.com/v1/orders/970167"
    },
    "attributes": {
      "tax": 0,
      "urls": {
        "receipt": "https://app.lemonsqueezy.com/my-orders/0e614d20-2917-44fa-bd60-0856cf75d191?signature=b9881c85a88cb0c162dfe7c4417840eacdda24054af38456675cc76a01fad927"
      },
      "total": 999,
      "status": "paid",
      "tax_usd": 0,
      "currency": "USD",
      "refunded": false,
      "store_id": 36267,
      "subtotal": 999,
      "tax_name": null,
      "tax_rate": "0.00",
      "test_mode": true,
      "total_usd": 999,
      "user_name": "tao tao",
      "created_at": "2023-07-20T10:44:53.000000Z",
      "identifier": "0e614d20-2917-44fa-bd60-0856cf75d191",
      "updated_at": "2023-07-20T10:44:54.000000Z",
      "user_email": "taoran1401@gmail.com",
      "customer_id": 933066,
      "refunded_at": null,
      "order_number": 2,
      "subtotal_usd": 999,
      "currency_rate": "1.00000000",
      "tax_formatted": "$0.00",
      "discount_total": 0,
      "total_formatted": "$9.99",
      "first_order_item": {
        "price": 999,
        "order_id": 970167,
        "test_mode": true,
        "created_at": "2023-07-20T10:44:54.000000Z",
        "product_id": 94881,
        "updated_at": "2023-07-20T10:44:54.000000Z",
        "variant_id": 102178,
        "product_name": "会员30天",
        "variant_name": "Default"
      },
      "status_formatted": "Paid",
      "discount_total_usd": 0,
      "subtotal_formatted": "$9.99",
      "discount_total_formatted": "$0.00"
    },
    "relationships": {
      "store": {
        "links": {
          "self": "https://api.lemonsqueezy.com/v1/orders/970167/relationships/store",
          "related": "https://api.lemonsqueezy.com/v1/orders/970167/store"
        }
      },
      "customer": {
        "links": {
          "self": "https://api.lemonsqueezy.com/v1/orders/970167/relationships/customer",
          "related": "https://api.lemonsqueezy.com/v1/orders/970167/customer"
        }
      },
      "order-items": {
        "links": {
          "self": "https://api.lemonsqueezy.com/v1/orders/970167/relationships/order-items",
          "related": "https://api.lemonsqueezy.com/v1/orders/970167/order-items"
        }
      },
      "license-keys": {
        "links": {
          "self": "https://api.lemonsqueezy.com/v1/orders/970167/relationships/license-keys",
          "related": "https://api.lemonsqueezy.com/v1/orders/970167/license-keys"
        }
      },
      "subscriptions": {
        "links": {
          "self": "https://api.lemonsqueezy.com/v1/orders/970167/relationships/subscriptions",
          "related": "https://api.lemonsqueezy.com/v1/orders/970167/subscriptions"
        }
      },
      "discount-redemptions": {
        "links": {
          "self": "https://api.lemonsqueezy.com/v1/orders/970167/relationships/discount-redemptions",
          "related": "https://api.lemonsqueezy.com/v1/orders/970167/discount-redemptions"
        }
      }
    }
  },
  "meta": {
    "test_mode": true,
    "event_name": "order_created"
  }
}