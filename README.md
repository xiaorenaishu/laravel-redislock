# 简易好用的redis分布式锁
> 支持原子上锁，原子解锁，同端保证

### 引入 composer:

```
 composer require "cxr/laravel-redislock:dev-master"
```

### 如何使用
>laravel 需开启 Redis Facades
```php
    DistributedLock::lock('key', 3, 'default'); //上锁3s，指定连接串default
    
    DistributedLock::unlock('key', 'default');  //解锁，指定连接串default
 
```