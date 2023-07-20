- 创建结算单
- 支付回调
    - 支付成功
    - 支付失败
    

curl -X "POST" "https://api.lemonsqueezy.com/v1/checkouts" \
     -H 'Accept: application/vnd.api+json' \
     -H 'Content-Type: application/vnd.api+json' \
     -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NGQ1OWNlZi1kYmI4LTRlYTUtYjE3OC1kMjU0MGZjZDY5MTkiLCJqdGkiOiIwOWQ5YmQxZDcyZmU0YzZkODRmYTUxZTc3NTk5Mjc1NDQzMzVhYzcwNDAwYzI2OTQ0NDE3YjQ4NWVlMjVjYWVjZDY4NDQxNWM5Y2IxN2EzYyIsImlhdCI6MTY4OTgyMDE4OS45NDY2NjgsIm5iZiI6MTY4OTgyMDE4OS45NDY2NzEsImV4cCI6MTcyMTQ0MjU4OS45Mzg3NTgsInN1YiI6Ijk2MjA3MyIsInNjb3BlcyI6W119.uIuN6BAXuE6rctHL7iHrFm28Smf1p4bUoPADnZKjHvXTPBASkkLPgF29xP0MyJoCkL_WNy2HLSo92YGC2s1AldvItbaX9txQ6h2uask5cHWEYHlyG61ONHOQV02lVtaWKovu6-_HDc8nyO7F4mwuULyfEJ7xdaC0CjXwiohkXcE_AtSDDgJ9noMcIl5JlTX3Y32_e01yvnwcm6Bp_2NDaiEDxoXoDTXZCZiKgjWwIBrA_MLoqnEs6Sh_IQ9jrX36Fo9iUZHHqe06EWLQCddP7T5dmcKc2H3rfGF49zN10Za2maOS59b4SJ-8t4VR6E7ZGvWPWkyZ3VWkYooZ0i5mN-oWlAOvUDfZsdR2yTPG_2uRSUcS1f_A0C_iEBDJx_f11Ee1QHXwk6_ngQ_HY2JaQ9KbS1zzxfOuf6SOadctu-mt_1K5Z1DR4nFGY9gaO9zjFJsnsryvFzQiIoAQZwUxEOiVnN0Hr25lkVfNy-X_RDkl4Ybtcdc7FsFNppcSVgwU' \
     -d $'{
  "data": {
    "type": "checkouts",
    "attributes": {
      "custom_price": 50000,
      "product_options": {
        "enabled_variants": [
          1
        ]
      },
      "checkout_options": {
        "button_color": "#2DD272"
      },
      "checkout_data": {
        "discount_code": "10PERCENTOFF",
        "custom": {
          "user_id": 123
        }
      },
      "expires_at": "2022-10-30T15:20:06Z",
      "preview": true
    },
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
          "id": "1"
        }
      }
    }
  }
}'