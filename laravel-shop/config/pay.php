<?php

return [
    'alipay' => [
        'app_id'         => '2016091700533850',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA1zH5wGT/QA4R95wzS5JH1eUHEAqjBa+YKkiEH+6p7oY1/2NKBzpYRXhIPf2NsYQNKcZobmvD4tArOjZ2SSngtYD2EOvkGDlK2aFNHwE+Nyk2wA3FOaa2+A+8I2appxr1YlEqPtoU4+lJ7LbRx6AiQRSkxQ8DIM+JWjh5hqAs/72dhCGDBbwb/LkGNMsf49j5YviTPmgLzvrWJZpj4LCrAHvNu3HTCF+pr+AYk9Nhqo/Aiwqq7GPFcw1lRUi7KzNLLP7wH9ZFU5EBz+pD3QhbmhRc7VNjSVCEcsDWioQI+lazwRlrqS5djxkRyq9kVyyVyCNSQzrwgZ3cSsFk+1t4zwIDAQAB',
        'private_key'    => 'MIIEpAIBAAKCAQEAuq+wchkj/LF2jcDYwOH+dUKTKPu0LvHQutWu/JdE/M3yC/zpFfVRcFq61X/MchZT/7JYGM2NkK3c2LJssFoil/XyDx+DEcukYPzz/QRC99XnalET1YSu+fE0rJ71BY511EKAvLl8jpGy+TGF/fyzt2db7/eI4PPWQc6vPTQBq7a4Rhy7y1YLr3T9dPNCRW9hKPW8lvX0cn3VFwk8SAhyTVL/hJoYGUqjoyXy1COwB3ZGR9XbHB6JAeUKvxfLqCoXBDk58ZeRPc/57zLws/RmBuwOey0rCPRfSyp1gMiiISfR8tCSGZy72k6qUr0OYIpUzEeuk9lk+/oGgNQCnIIjZQIDAQABAoIBAQCK6ncywBBuVaOxYcIo7UILAYo94ea3VAuNK7q1jN6x+5HUZ9MOGukJ4QnMGvgIISNKTuyNME/aS/Xdbg/AvqGlUEdaB4nhsRZVcYUhTo2CnDJCg6htpvkJVfprRTFwfAyj8QSY6rGL6VEzay2YzPTyUcAw9ZJuSiOx/lmaAlwH6H8X0FkcpPxHTM3dlxMbwVS5OnoP0INhmZD8HLSKI6MT/4q1EJ7HgfV6XxHNUs0iWA+xQyJcePLjC1rum/yOH80447wn5/tq5Bho5Am2yG30SxDXBLF3JKUVoX5M6WyU+2++plAmmp6KQKvAXrVTgc+1cviI+9LmODdLe5EeJrlVAoGBAN7Wgd/B2F/JimrtQQACfjCvQuPowgqu1YQBA3dYrjBIiFDauaJbnGz2jubQ5P9FKT0yGPoYbA1zgo95W6rM5hVVLOl9BWdVR4T9poj3QpkG4XQDaMgZGD9P5iKT9ISd1dtw/jG4P+/Vb38NNU3qzSoY1dm7wz7K0BQaZz2mYQRnAoGBANZ36EComeynYmfvFv9U9hGfFYuJy3lqOQ0yUZbEUQ9I4Q0+uSh5PVL+RMQf51paLVFvuDV8RS06qkidiaIM2EfgNZ3ho1lFATKnTvEENQHHlAXYTT9kznr8C8hOU/1EyeIAlynplkMOZ1WjxBngwOc9J7rxi2LD5rLeGOwHgtpTAoGBAJsoQMXL8xy+9+H70IZxNewwHCMUrgdCNOj0y7UNyjtURZYGtbqWjxRPmLCeQtR7E3vIpht9Zb737rB3j5wdjxbLd7obkuegOWwgMRStFXH3mINu3EZ3MqritxrcaiTswTtKMbPs1pfnxPpx9+uI0dG9+Sjh09Ck5r0YpUoHzwWBAoGALWmEZzSMKz0iLCnHL9eYpxCNaleKGzJv1CiEeC0nkNn4tWpDoJtTbeBjRTgQL+SKVgUW91RR/Yq/hdK90u9vWIDUOZMOmJdw8n3UzFn8s1zELhyn9rVst0PpZseXJzjKmq1PVNOeOqKxJMQhgO1DS3N6ly4QOqCKl/NJSakpfvsCgYBGxBUHrlp+eKzMwIhULYD9RffWvzx5sALA8tczGSrPCWBQLV6Dt6y3XvvwXY+fHE6KQo7LsV/uxPqX8uRV0opIq4cOGyCLRSKu2psAm8STZDuN0OImZ861p1aSCWrmaCkG0LFqdctfq2s5Ez7/LgoriLC91wmPtHsTujXS2DALIw==',
        'log'            => [
            'file' => storage_path('logs/alipay.log'),
        ],
    ],

    'wechat' => [
        'app_id'      => '',
        'mch_id'      => '',
        'key'         => '',
        'cert_client' => resource_path('wechat_pay/apiclient_cert.pem'),
        'cert_key'    => resource_path('wechat_pay/apiclient_key.pem'),
        'log'         => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],
    ],
];