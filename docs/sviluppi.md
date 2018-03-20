


SELECT v.* , u.login_utenti 
FROM `volontari` v join utenti u on v.`id_volontari_utenti` = u.id_utenti 
order by u.login_utenti asc

https://stackoverflow.com/questions/31847054/how-to-use-multiple-database-in-laravel


https://sujipthapa.co/blog/laravel-v55-login-register-with-username-or-email



https://jamesmcfadden.co.uk/custom-authentication-in-laravel-with-guards-and-user-service-providers

Authentication in Laravel is centered around guards which allow us to specify varying ways that a user can be authenticated.
The first thing we’ll do is add our own guard for authenticating volontari users. We can do this in /config/auth.php:



https://code.tutsplus.com/tutorials/how-to-create-a-custom-authentication-guard-in-laravel--cms-29667

Guards
You could think of a guard as a way of supplying the logic that’s used to identify the authenticated users. In the core, Laravel provides different guards like session and token. 


Providers
If the guard defines the logic of authentication, the authentication provider is responsible for retrieving the user from the back-end storage. If the guard requires that the user must be validated against the back-end storage then the implementation of retrieving the user goes into the authentication provider. Laravel ships with two default authentication providers—Database and Eloquent.





https://laracasts.com/series/laravel-from-scratch-2017/episodes/17

https://laracasts.com/series/laravel-5-fundamentals/episodes/15
