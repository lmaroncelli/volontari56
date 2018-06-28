


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



https://git-scm.com/book/it/v1/Git-sul-Server








**I volontari devono __DIVENTARE__ users al posto delle associazioni**


- cambiare la relazione tra Associazione e User e diventa tra Volontario e User

- lo user_id viene messo sulla tabella tblVolontari

- loop sui volonatri e creazione per ognuno di un record nella tabella users con:
 	ruolo: associazione
 	name: NOME + COGNOME
 	username: NOME + COGNOME
 	pwd: NOME + COGNOME (da cambiare) 




1. Creazione nuovo Volonario/Utente

Rimane il form di adesso, ma 

se sono un utente ASSOCIAZIONE, aggiungo il form del volontario

- una combo per la selezione dell'associazione se sono un utente di quel tipo 
- nome 
- cognome
- registro
- data di nascita
- note 



2. spostamento di un volontario da un'associazione ad un'altra

anche cancellandolo da un'associazione non perde mai la relazione con lo user, quindi mantiene il suo login anche nello spostamento.


3. fare in modo che alcuni users non possano fare login ???

