# 简易好用的redis分布式锁
> 支持保证原子性上锁／解锁，同端解锁保证

### 引入 composer:

```
 composer require "cxr/laravel-redislock"
```

### 如何使用
>laravel 需开启 Redis Facades
```php
    DistributedLock::lock('key', 3); //上锁3s，可指定连接串，默认default
    
    DistributedLock::unlock('key');  //解锁，可指定连接串，默认default
 
```